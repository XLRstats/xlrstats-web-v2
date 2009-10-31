<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2009 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
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
  $query = "SELECT ${t['b3_clients']}.name, ctime.id, ctime.gone, ctime.came
              FROM ${t['b3_clients']}, ctime, ${t['players']} 
              WHERE ${t['players']}.id = \"$plid\"
              AND ${t['players']}.client_id = ${t['b3_clients']}.id
              AND ${t['b3_clients']}.guid = ctime.guid
              ORDER BY ctime.id DESC";      
}
else if(isset($_GET['dbid']))
{
  $plid = $_GET['dbid'];
  $query = "SELECT ${t['b3_clients']}.name, ctime.id, ctime.gone, ctime.came
              FROM ${t['b3_clients']}, ctime
              WHERE ${t['b3_clients']}.id = \"$plid\"
              AND ${t['b3_clients']}.guid = ctime.guid
              ORDER BY ctime.id DESC";        
}
else
  return;
$data = array();

global $t;
$count = 0;
$link = baselink();
$result = $coddb->sql_query($query);

// Do not show the graph on an empty result
if (mysql_num_rows($result) == 0) return;

$d = array();
$max = 31;
$idx = 1;
$suma = 0;
while ($row = $coddb->sql_fetchrow($result))
{
  $start = $row['came'];
  $end = $row['gone'];
  $d1 = date("Y-m-d", $start);
  $d2 = date("Y-m-d", $end);
  
  if (count($data) and $data[count($data)-1][1] > $d1)
  {
    $diff = floor(($data[count($data)-1][4] - $start) / (60*60*24));
    $empty = $data[count($data)-1][4];
    for ($i=0; $i < $diff; $i++)
    {
      if (count($d) >= $max) break;
      $empty = $empty - 60*60*24;
      if (!$d[time2ymd($empty)]) $d[time2ymd($empty)] = $idx++;
      $data[] = array(
          $d[time2ymd($empty)]-1,
          date("Y-m-d", $empty),
          '00:00',
          '00:00',
          $empty
          );
    }
  }

  // need to wrap the session to the next day
  if ($d2 > $d1)
  {
    if (!$d[$d2]) 
      $d[$d2] = $idx++;
    $data[] = array(
      $d[$d2]-1,
      date("Y-m-d", $end),
      "00:00",
      date("H:i", $end),
      $start
      );
  }

  if (!$d[$d1]) $d[$d1] = $idx++;
  $data[] = array(
      $d[$d1]-1,
      date("Y-m-d", $start),
      date("H:i", $start),
      $d2 <= $d1 ? date("H:i", $end) : "23:59",
      $start
      );
  
  $suma += $row['gone'] - $row['came'];
}

include ("lib/jpgraph/jpgraph.php");
include ("lib/jpgraph/jpgraph_gantt.php");

$imgfilename = 'auto';
$graph = new GanttGraph($main_width-10,0, $imgfilename, 1);
$graph->SetMarginColor( '#C4C4C4');
$graph->SetColor('white');
$graph->SetFrame(true,'gray', 1);
$graph->ShowHeaders(GANTT_HHOUR);
$graph->scale->UseWeekendBackground(false);
$graph->scale->hour->SetBackgroundColor('lightyellow:1.5');
$graph->scale->hour->SetSundayFontColor('black');
$graph->scale->day->SetBackgroundColor('lightyellow:1.5');
$graph->scale->day->SetSundayFontColor('black');
$graph->scale->hour->SetFont(FF_FONT1);
$graph->scale->hour->SetIntervall(1);
$graph->scale->hour->SetStyle(HOURSTYLE_H24);
$graph->hgrid->SetRowFillColor('whitesmoke@0.9','darkblue@0.9');
$graph->setMargin(0,0,0,20);
$graph->scale->hour->SetFont(FF_FONT1);
$graph->scale->day->SetFont(FF_FONT1,FS_BOLD);
$graph->title->SetColor('white');
$graph->scale->UseWeekendBackground(false);
$graph->scale->day->SetWeekendColor('lightyellow:1.5');
$graph->scale->week->SetFont(FF_FONT1);
$graph->hgrid->Show(true);
$graph->hgrid->SetRowFillColor('whitesmoke@0.9','darkblue@0.9');

if($suma > 0)
{
  for($i=0; $i<count($data); ++$i)
  {
    $bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3]);
    $bar->SetPattern(BAND_RDIAG, 'lightgray');
    $bar->SetFillColor('brown');
    $bar->SetShadow(true, 'black@0.5');
    $graph->Add($bar);
  }
}
else
{
  $bar = new GanttBar(0,$text["noactivity"],"23:59","00:00");
  $bar->SetPattern(BAND_RDIAG, 'white@1');
  $graph->Add($bar);
}

$graph->footer->left->Set($text["totalingame"]." ".formatTD($suma));
$graph->footer->left->SetColor('black@0.5');
$graph->footer->left->SetFont(FF_FONT2,FS_BOLD);
$graph->Stroke();
?>
