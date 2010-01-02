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

include("../inc_mysql.php");
include("../func-globallogic.php");

echo "<td width=\"100%\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">";
echo "<tr><td align=\"left\" valign=\"top\">";

if (!isset($pop))
  $pop = 1;

$cpath = abs_pathlink($pop);

error_reporting(0);

//scan available configs and save the appropriate awardfiles
configscanner();
end_process();

//********************************************************************************
//  FUNCTIONS
//********************************************************************************

function identify_config()
{
  global $currentconfignumber;
  global $currentconfig;
  global $cpath;
  // If statsconfig.php exists, we won't enable multiconfig functionality
  if (file_exists($cpath."config/statsconfig.php"))
  {
    $currentconfig = "statsconfig.php";
    $currentconfignumber = 0;
  }
  elseif (file_exists($cpath."config/statsconfig1.php"))
  {
    $currentconfig = "statsconfig1.php";
    $currentconfignumber = 1;
    // Was a config set in the url?
    if (isset($_GET['config'])) 
    {
      $currentconfignumber = escape_string($_GET['config']);
      $currentconfig = "statsconfig".$currentconfignumber.".php";
      $_SESSION['currentconfignumber'] = $currentconfignumber;
    }
    if (isset($_SESSION['currentconfignumber']))
    {
      $currentconfignumber = $_SESSION['currentconfignumber'];
      $currentconfig = "statsconfig".$currentconfignumber.".php";
    }
  }
}

function identify_function()
{
  global $func;

  if (isset($_GET['func']))
    $func = escape_string($_GET['func']);
}

function configscanner()
{
  global $currentconfig;
  global $currentconfignumber;
  global $db_host;
  global $db_user;
  global $db_pass;
  global $db_db;
  global $coddb;
  global $filename;
  global $buffer;
  global $t;
  global $cpath;

  $c = true;
  $cnt = 0;
  //$configlist[]= "";
  while ($c == true)
  {
    $cnt++;
    $filename = $cpath."config/statsconfig".$cnt.".php";
    if (file_exists($filename)) $configlist[] = $cnt;
    else $c = false;
  }
  if ($cnt > 2)
  {
    foreach  ($configlist as $value)
    {
      $currentconfignumber = $value;
      $config = $cpath."config/statsconfig".$value.".php";
      include($config);
      echo "<p class=\"fontTitle\">Reading configfile nr. ".$value." (for game: ".$game.")</p><br />";
      startbuffer();
      $tfunc = $game."_awards();";
      eval($tfunc);
      closebuffer_write();
      unset($tfunc);
    }
  }
  else
  {
    $currentconfignumber = 0;
    $config = $cpath."config/statsconfig.php";
    include($config);
    echo "<p class=\"fontTitle\">Reading configfile (for game: ".$game.")</p><br />";
    startbuffer();
    $tfunc = $game."_awards();";
    eval($tfunc);
    closebuffer_write();
    unset($tfunc);
  }
}

function startbuffer()
{
  global $currentconfig;
  global $currentconfignumber;
  global $db_host;
  global $db_user;
  global $db_pass;
  global $db_db;
  global $coddb;
  global $filename;
  global $buffer;
  global $cpath;
  // Open the file
  $buffer = "<?php\n";
  
  $buffer .= "//------------------------------------------------------\n";
  $buffer .= "// This is an automatically generated file!\n";
  $buffer .= "// Do not alter this unless you know what you are doing!\n";
  $buffer .= "//------------------------------------------------------\n";
  
  $coddb = new sql_db($db_host, $db_user, $db_pass, $db_db, false);
  if(!$coddb->db_connect_id) 
  {
      die('<p class="attention">Could not connect to the database!<br />Did you setup this statsconfig file ('.$currentconfig.') correctly?</p></body></html>');
  }
  
  if ($currentconfignumber == 0)
    $filename = $cpath."dynamic/award_idents.php";
  else
    $filename = $cpath."dynamic/award_idents_$currentconfignumber.php";
  
  if (!file_exists($filename))
  {
    touch($filename);
    if (!file_exists($filename))
      die('<p class="attention">Could not create the configfile. Make sure your config directory is writable!</p></body></html>');
  }
  
  if (!is_writable($filename))
    die('<p class="attention">The file is not writable</p></body></html>');
  echo "<span class=\"precheckOK\">...writing ".$filename."</span><br /><br />";
}

function closebuffer_write()
{
  global $coddb;
  global $buffer;
  global $filename;

  $buffer .= "?".">\n";
  file_put_contents($filename, $buffer);
  $coddb->sql_close();
}

function end_process()
{
  echo "<p class=\"precheckOK\"><strong>Your awards have been identified using the current database content.</strong></p>";
  echo "<p class=\"fontNormal\">1.) You may run \"install_award_idents.php\" file located in \"config\" directory at any time if you feel that certain awards are not good or certain weapons have only recently been used for the first time.<br />"; 
  //echo "Bookmark current URL to rerun this file later.</i></p>";
  echo "<p class=\"attention\">2.) When you're sure all awards are correct and all weapons have been used, delete/move the install directory so it can no longer be called directly.)</p>";
  echo "<p class=\"fontNormal\">Click \"Index\" button to return to the frontpage</p>";
  echo "<p class=\"fontNormal\"><a href=\"http://www.xlr8or.com/\">(made at www.xlr8or.com)</a></p>";
  echo "<tr>";
  echo "<td valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
  echo "<tr>";
  echo "<td>&nbsp;</td>";
  echo "<td width=\"80\" align=\"center\" valign=\"middle\"><a href=\"../index.php\">";
  echo "<label>";
  echo "<input name=\"Next\" type=\"button\" class=\"line1\" id=\"Next\" value=\"Index\" />";
  echo "</label>";
  echo "</a></td>";
  echo "</tr>";
  echo "</table>";
}

//********************************************************************************
//  AWARDS
//********************************************************************************


function cod1_awards()
{
  global $t;
  global $coddb;
  global $buffer;
  
  //-- Weapons -------------------------------------------------------------------
  $buffer .= "\n// Weapons / Means of Death --------\n";
  
  // Bashes
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'mod_melee'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_bashes = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Nades
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name LIKE '%frag%'
            OR name LIKE '%granate%'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_nades = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Snipers
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('springfield_mp', 'kar98k_sniper_mp', 'mosin_nagant_sniper_mp', 'enfield_scope_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_snipers = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Pistols
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('colt_mp', 'luger_mp', 'webley_mp', 'TT30_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_pistols = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Accidents
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('none', 'mod_falling')
            OR name LIKE '%frag%'
            OR name LIKE '%granate%'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_accidents = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  //-- Bodyparts -----------------------------------------------------------------
  $buffer .= "\n// Bodyparts ---------------------\n";
  
  // Head 
  $query = "SELECT id 
            FROM ${t["bodyparts"]}
            WHERE name = 'head'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$bp_head = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
}

function coduo_awards()
{
  global $t;
  global $coddb;
  global $buffer;
  
  //-- Weapons -------------------------------------------------------------------
  $buffer .= "\n// Weapons / Means of Death --------\n";
  
  // bomb (satchell)
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'satchelcharge_mp'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_bomb = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Bashes
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'mod_melee'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_bashes = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Nades
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name LIKE '%frag%'
            OR name LIKE '%granate%'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_nades = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Snipers
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('springfield_mp', 'kar98k_sniper_mp', 'mosin_nagant_sniper_mp', 'enfield_scope_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_snipers = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Pistols
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('colt_mp', 'luger_mp', 'webley_mp', 'tt33_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_pistols = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Accidents
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('none', 'binoculars_artillery_mp')
            OR name LIKE '%frag%'
            OR name LIKE '%granate%'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_accidents = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  //-- Bodyparts -----------------------------------------------------------------
  $buffer .= "\n// Bodyparts ---------------------\n";
  
  // Head 
  $query = "SELECT id 
            FROM ${t["bodyparts"]}
            WHERE name = 'head'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$bp_head = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
}

function cod2_awards()
{
  global $t;
  global $coddb;
  global $buffer;
  
  //-- Weapons -------------------------------------------------------------------
  $buffer .= "\n// Weapons / Means of Death --------\n";
  
  // Bashes
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'mod_melee'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_bashes = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Nades
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name LIKE '%frag_grenade%'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_nades = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Snipers
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('springfield_mp', 'kar98k_sniper_mp', 'mosin_nagant_sniper_mp', 'enfield_scope_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_snipers = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Pistols
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('colt_mp', 'luger_mp', 'webley_mp', 'TT30_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_pistols = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Accidents
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'none'
            OR name LIKE '%frag_grenade%'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_accidents = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  //-- Bodyparts -----------------------------------------------------------------
  $buffer .= "\n// Bodyparts ---------------------\n";
  
  // Head 
  $query = "SELECT id 
            FROM ${t["bodyparts"]}
            WHERE name = 'head'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$bp_head = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
}

function cod4_awards()
{
  global $t;
  global $coddb;
  global $buffer;
  
  //-- Weapons -------------------------------------------------------------------
  $buffer .= "\n// Weapons / Means of Death --------\n";
  
  // Claymore
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'claymore_mp'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_claymore = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Fireman (Car)
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'destructible_car'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_fireman = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // bomb (C4)
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'c4_mp'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_bomb = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Knives
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'mod_melee'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_knives = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Nades
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('frag_grenade_mp', 'frag_grenade_short_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_nades = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Snipers
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('m40a3_acog_mp', 'm40a3_mp', 'm21_acog_mp', 'm21_mp','dragunov_mp', 'dragunov_acog_mp', 'remington700_mp', 'remington700_acog_mp', 'humvee_50cal_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_snipers = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Pistols
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('colt45_mp', 'colt45_silencer_mp', 'usp_mp', 'usp_silencer_mp', 'beretta_mp', 'beretta_silencer_mp', 'deserteagle_mp', 'deserteaglegold_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_pistols = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Accidents
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('artillery_mp', 'mod_falling', 'none')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_accidents = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  //-- Bodyparts -----------------------------------------------------------------
  $buffer .= "\n// Bodyparts ---------------------\n";
  
  // Head 
  $query = "SELECT id 
            FROM ${t["bodyparts"]}
            WHERE name = 'head'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$bp_head = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
}

function codwaw_awards()
{
  global $t;
  global $coddb;
  global $buffer;
  
  //-- Weapons -------------------------------------------------------------------
  $buffer .= "\n// Weapons / Means of Death --------\n";
  
  // Bouncing Betty
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'mine_bouncing_betty_mp'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_bouncingbetty = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
    // Molotov
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'molotov_mp'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_molotov = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);

    // Flame Thrower
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'm2_flamethrower_mp'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_flamethrower = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);

  // Bashes
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'mod_melee'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_knives = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Nades
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name LIKE ('%frag_grenade%')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_nades = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Snipers
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('springfield_scoped_mp', 'kar98k_scoped_mp', 'm1garand_scoped_mp', 'mosinrifle_scoped_mp', 'type99rifle_scoped_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_snipers = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Pistols
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('colt_mp', 'luger_mp', 'webley_mp', 'TT30_mp')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_pistols = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Fireman (Car)
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'destructible_car'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_fireman = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);

  // Accidents
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'none'
            OR name LIKE '%frag_grenade%'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_accidents = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);

  // Barrel Victim
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 'explodable_barrel'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_barrel = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);

  //-- Bodyparts -----------------------------------------------------------------
  $buffer .= "\n// Bodyparts ---------------------\n";
  
  // Head 
  $query = "SELECT id 
            FROM ${t["bodyparts"]}
            WHERE name = 'head'
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$bp_head = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
}

function urt_awards()
{
  global $t;
  global $coddb;
  global $buffer;
  
  //-- Weapons -------------------------------------------------------------------
  $buffer .= "\n// Weapons / Means of Death --------\n";
  
  // Not used by UrT
  //$buffer .= "\$wp_bomb = 0;\n";
  //$buffer .= "\$wp_fireman = 0;\n";
  //$buffer .= "\$wp_claymore = 0;\n";
  
  // Knives
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('12', '13')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_knives = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Nades
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('22', '25', '37')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_nades = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Snipers
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('21', '28')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_snipers = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Pistols
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('14', '15')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_pistols = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Accidents
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('1', '6', 'mod_falling', '7', '31')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_accidents = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  //-- Bodyparts -----------------------------------------------------------------
  $buffer .= "\n// Bodyparts ---------------------\n";
  
  // Head and Helmet
  $query = "SELECT id 
            FROM ${t["bodyparts"]}
            WHERE name IN ('0', '1')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$bp_head = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
}

function wop_awards()
{
  global $t;
  global $coddb;
  global $buffer;
  
  //-- Weapons -------------------------------------------------------------------
  $buffer .= "\n// Weapons / Means of Death --------\n";
  
  // Knives - Punchy
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 2
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_punchy = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Nades - Ballooney
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('4', '5')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_ballooney = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Snipers - Betty
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('6', '7')
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_betty = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Pistols - Killerducks
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name = 14
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_killerducks = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
  
  // Accidents
  $query = "SELECT id 
            FROM ${t["weapons"]}
            WHERE name IN ('15', '16', '17', '18', '19', 'mod_falling', '20',)
            LIMIT 0 , 30";
  
  $result = $coddb->sql_query($query);
  $numrows = $coddb->sql_numrows($result);
  
  $buffer .= "\$wp_accidents = \"(";
  $c = 0;
  while ($row = $coddb->sql_fetchrow($result))
  {
    $c += 1;
    $buffer .= $row["id"];
    if($c < $numrows)
      $buffer .=  ", ";
  }
  $buffer .= ")\";\n";
  $coddb->sql_freeresult($result);
}

//delete cache to display new medal owners
$files = glob("../dynamic/cache/*.txt");
foreach($files as $file) 
{
  unlink($file);
}  

?>
