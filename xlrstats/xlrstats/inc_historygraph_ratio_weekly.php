<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2010 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
 ***************************************************************************/

/***************************************************************************
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Library General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 *  http://www.gnu.org/copyleft/gpl.html
 ***************************************************************************/

require_once('inc_mysql.php');
require_once('func-globallogic.php');
require_once('languages/languages.php');

session_start();
cleanglobals();

// If statsconfig.php exists, we won't enable multiconfig functionality
if (file_exists("config/statsconfig.php"))
{
  $currentconfig = "config/statsconfig.php";
  $currentconfignumber = 0;
}
elseif (file_exists("config/statsconfig1.php"))
{
  $currentconfig = "config/statsconfig1.php";
  $currentconfignumber = 1;
  // Was a config set in the url?
  if (isset($_GET['config'])) 
  {
    $currentconfignumber = escape_string($_GET['config']);
    $currentconfig = "config/statsconfig".$currentconfignumber.".php";
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  if (isset($_SESSION['currentconfignumber']))
  {
    $currentconfignumber = $_SESSION['currentconfignumber'];
    $currentconfig = "config/statsconfig".$currentconfignumber.".php";
  }
  // double check config number found point to an existing config file or fallback to config 1
  if (!file_exists($currentconfig)) 
  {
    $currentconfig = "config/statsconfig1.php";
    $currentconfignumber = 1;
  }
}
require_once($currentconfig);

// Do we have template specific settings?
if (isset($_SESSION['template']))
  $template = $_SESSION['template'];

$xlrpath = pathlink($pop);
$csspath = $xlrpath . "templates/" . $template . "/style.css";
// Include existing php dynamic css?
$template_dyn_css = $xlrpath . "templates/" . $template . "/style-css.php?config=" . $currentconfignumber;

// Lets get the holiday templates
if (file_exists("templates/holidaypack/"))
{
  $xlrpath = GetFileDir($_SERVER['PHP_SELF']);
  if (date("d.m") == "25.12" || date("d.m") == "26.12")
  {
    $csspath = $xlrpath . "templates/holidaypack/xmas.css";
    $template_dyn_css = "";
    $template = "holidaypack";
  }
  elseif (date("d.m") == "31.12" || date("d.m") == "01.01")
  {
    $csspath = $xlrpath . "templates/holidaypack/ny.css";
    $template_dyn_css = "";
    $template = "holidaypack";
  }
  elseif (date("d.m") == "31.10")
  {
    $csspath = $xlrpath . "templates/holidaypack/halloween.css";
    $template_dyn_css = "";
    $template = "holidaypack";
  }
}
  

$templateconfig = "templates/" . $template . "/config.php";
if (file_exists($templateconfig))
  include($templateconfig);
$main_width = $main_width ? $main_width : 800; 


global $coddb;
if($coddb == null)
{
  $coddb = new sql_db($db_host, $db_user, $db_pass, $db_db, false);
  if(!$coddb->db_connect_id) 
    die("Could not connect to the database");
}

function time2ymd($time, $char='-') {
	return date(implode($char, array('Y','m','d')), $time);
}

if(isset($_GET['id']))
{
  $plid = $_GET['id'];
  $query = "SELECT ${t['b3_clients']}.name, ${t['history_weekly']}.*
              FROM ${t['b3_clients']}, ${t['history_weekly']}, ${t['players']} 
              WHERE ${t['players']}.id = \"$plid\"
              AND ${t['players']}.client_id = ${t['b3_clients']}.id
              AND ${t['b3_clients']}.id = ${t['history_weekly']}.client_id
              ORDER BY ${t['history_weekly']}.year DESC, ${t['history_weekly']}.week DESC
              ";   
}
else if(isset($_GET['dbid']))
{
  $plid = $_GET['dbid'];
  $query = "SELECT ${t['b3_clients']}.name, ${t['history_weekly']}.*
              FROM ${t['b3_clients']}, ${t['history_weekly']}
              WHERE ${t['b3_clients']}.id = \"$plid\"
              AND ${t['b3_clients']}.id = ${t['history_weekly']}.client_id
              ORDER BY ${t['history_weekly']}.year DESC, ${t['history_weekly']}.week DESC
              ";        
}
else
  return;
$data = array();

//echo $query;

global $t;
$count = 0;
$link = baselink();
$result = $coddb->sql_query($query);

// Do not show the graph on an empty result
if (mysql_num_rows($result) == 0) 
{
  header('Content-type: image/png');
  $im = imagecreatetruecolor(340, 30);
  $bg = imagecolorallocate($im, 204, 204, 204);
  $grey = imagecolorallocate($im, 88, 88, 88);
  imagefilledrectangle($im, 0, 0, 399, 29, $bg);
  $text = 'There\'s not enough data for ratio graph yet!';
  $font = 'sig/fonts/lucon.ttf';
  imagettftext($im, 9, 0, 21, 21, $grey, $font, $text); // Add some shadow to the text

  imagepng($im);
  imagedestroy($im);
  return;
}

//===========================================================================================================================

include ("lib/jpgraph/jpgraph.php");
include ("lib/jpgraph/jpgraph_line.php");

$records = mysql_num_rows($result);

for($i=0;$i<$records;$i++)
{
   $row  = mysql_fetch_row($result);
   $name = $row[0];
   $a1[] = $row[8];
   $a2[] = $row[15]."-w".$row[17];
}

$datay  = array_reverse(array_merge($a1));
$datax  = array_reverse(array_merge($a2));

// Setup graph
$graph = new Graph($main_width,300,"auto");                            // breedte hoogte
$graph->img->SetMargin(40,40,50,60);	                       // Links,rechts,boven,beneden
$graph->SetScale("textlin");

//Setup title
$graph->title->SetMargin(10);                                  // marge boven de koptekst
$graph->title->Set($name." ".$text["weeklyhistory_ratio_img_title"]);
$graph->title->SetFont(FF_FONT2,FS_BOLD,18);

// set margin color
$graph->SetMarginColor('#c4c4c4');                             // kleur van het gebied om de grafiek
 
$graph->ygrid->SetFill(true,'#EFEFEF@0.6','#e5e5e5@0.6');      // kleur van de horizontale strepen  @0.5 maakt de kleur zachter. eerste = de onderste balk
                                                               // hoe hoger @0,? hoe lichter de kleur
$graph->xgrid->Show();                                         // de vertikale gridlijnen                                      

// Slightly adjust the legend from it's default position
$graph->legend->Pos(0.02,0.03,"right","top");                  // plaats van de index de eerst is horizontaal de tweede is vertikaal
$graph->legend->SetFont(FF_FONT1,FS_BOLD);

// Setup X-scale
$graph->xaxis->SetTextTickInterval(2);                         // hier de ticks instellen
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_FONT1,FS_NORMAL,8);

// Create the first line
$p1 = new LinePlot($datay);
$p1->mark->SetType(MARK_DIAMOND);
$p1->mark->SetFillColor("green");
$p1->mark->SetWidth(6);
$p1->SetColor("green");
$p1->SetCenter();
$p1->SetLegend("Ratio");
$graph->Add($p1);

// Display the graph
$graph->Stroke();

?>
