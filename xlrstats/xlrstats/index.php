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

// Set flag that this is a parent file
define( '_XLREXEC', 1 );

include("lib/ctracker.php");
include("inc_mysql.php");
include("func-globallogic.php");
include("func-playerlistlogic.php");
include("func-sectionlogic.php");
include("func-awardlogic.php");
include("func-clan.php");
include("lib/geoip.inc");

session_start();
checkinstalldir();
cleanglobals();
pageloader_start();

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

  if (isset($_POST['config'])) 
  {
    $currentconfignumber = escape_string($_POST['config']);
    $currentconfig = "config/statsconfig".$currentconfignumber.".php";
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  // Was a config set in the url?
  elseif (isset($_GET['config'])) 
  {
    $currentconfignumber = escape_string($_GET['config']);
    $currentconfig = "config/statsconfig".$currentconfignumber.".php";
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  elseif (isset($_SESSION['currentconfignumber']))
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
include($currentconfig);
include("config/inc_constants.php");
include("languages/languages.php");
include("config/ranks.php");
include("config/awards.php");
include("config/".$game.".php");

if($game == "bfbc2")
  include("func-bfbc2global.php");

// Debug mode?
if (!isset($debug))
  $debug = 1;
if ($debug == 1)
  error_reporting(E_ALL);
else
  error_reporting(0);

// Retrieve cookie contents
//if (isset($_COOKIE["XLR_template"]))
//  $template = $_COOKIE["XLR_template"];
if (isset($_COOKIE['XLR_playerid']))
{
  foreach ($_COOKIE['XLR_playerid'] as $key => $value)
  {
    if ($key == $currentconfignumber)
      $myplayerid = $value;
  }
}

// Was a templatestyle set in the url?
if (isset($_GET['style'])) 
{
  $template = escape_string($_GET['style']);
  $_SESSION['template'] = $template;
}

//------------------------------------------------------------------------------
$coddb = new sql_db($db_host, $db_user, $db_pass, $db_db, false);
if(!$coddb->db_connect_id) 
  die($text["cantconnectdb"]);

//------------------------------------------------------------------------------
// fetch the func variable, which tells us what we need to do
$func = "index";
if(isset($_GET['func']))
{
	$func = escape_string($_GET['func']);
	$func = $_GET['func'];
}

if ($func == "")
  $func = "index";
  
if ($func == "savelang")
{
  savelanguage();

  if(!empty($_SERVER['HTTP_REFERER']))
  {
    header('Refresh: 0,URL="'.$_SERVER['HTTP_REFERER'].'"');
  }
  else
  {
    echo '<script type="text/javascript">setTimeout("history.go(-1);",0);</script>';
  }
  exit;
}

// Save cookies if requested
if ($func == "saveme")
{
  $errmsg = "<span class=\"attention\">".$text["errmsg"]." <br /><a href=\"http://www.google.com/cookies.html\" target=\"_blank\">".$text["googleisbest"]."</a><br /><br /></span>";
  $okmsg = "<span class=\"highlight\">".$text["okmsg"]."<br /><br />".$text["goingback"]."<br /><br /></span>";
  if (isset($_GET['playerid']))
    $myplayerid = escape_string($_GET['playerid']);

  saveme();

  if(!empty($_SERVER['HTTP_REFERER']))
  {
    header('Refresh: 8,URL="'.$_SERVER['HTTP_REFERER'].'"');
    displayheader();
    echo ($okmsg);    
  }
  else
  {
    displayheader();
    echo '<script type="text/javascript">setTimeout("history.go(-1);",8000);</script>';
    echo ($okmsg);
  }
  exit;
}

if ($func == "info")
{
  if ($debug == 1)
  {
    info();
    exit;
  }
  else
    $func = "index";
}

if ($func == "server")
{
  welcometext();
  //currentplayers();
  exit;
}

if ($func == "cron")
{
  run_cronjobs();
  exit;
}

// Include award idents for normal page generation -----------------------------
if ($currentconfignumber == 0)
  include("dynamic/award_idents.php");
else
  include("dynamic/award_idents_".$currentconfignumber.".php");

// Display header --------------------------------------------------------------
displayheader();
        
// perform the search, and handle error cases
if ($func == "search")
{
  $result = 0;
  
  if (isset($_POST['input_name']))
    $input_name = escape_string($_POST['input_name']);
  else
    $input_name = "";
  if (isset($_POST['aliases']))
    $search_aliases = escape_string($_POST['aliases']);
  else
    $search_aliases = "false";
  if (isset($_POST['clansearch']))
    $search_clan = escape_string($_POST['clansearch']);
  else
    $search_clan = "false";

  if ($search_clan == "true")
  {
      $func = "clan";
  }
      
  // check if we're still in the normal search mode, it could also be clanfiltering
  if ($func == "search")
  {
    if ( ($input_name != "") && (strlen($input_name) > 2 ) )
    {
      $result = do_search($input_name, $search_aliases);
    }
    if ($result == 0)
    {
      if (strlen($input_name) < 3)
        echo "<span class=\"attention\">".$text["searchterm"]."</span><br/></br>";
      else
        echo "<span class=\"attention\">".$text["searchresult"]."</span><br/><br/>";
          
      $func = "index";
    }
  }
}


// show stats about a specific player
if ($func == "player")
{
  global $game;
  global $groupbits;
  global $limitplayerstats;
  global $actionbased;

  global $main_width;
  // variables for tabcontrol (playerstats tabs)
  global $ptab_backgroundColor;
  global $ptab_selectedBgColor;
  global $ptab_mouseOverColor;
  global $ptab_borderColor;
  global $ptab_borderSize;
  global $ptab_borderStyle;
  global $ptab_font;
  global $ptab_textAlign;
  global $ptab_fontSize;
  global $ptab_fontWeight;
  global $ptab_Color;

  require("inc_tabControlClass.php");           
  if (isset($_GET['playerid']))
  {
    $playerid = escape_string($_GET['playerid']);
    //make calls to show all data about a particular player
    player_short($playerid);
    echo "<br/>";
    if ($groupbits > 0 || $limitplayerstats == 0)
    {
      player_badges($playerid);
      echo "<br/>";
    }      
    // ------------------------------------------------------------------------------

    //player_weapons_s($playerid);              
    $tabControl    = new TabControl();     
    $content1 = player_weapons_s($playerid);
    $content2 = player_bodyparts_s($playerid);  
    $content3 = player_maps_s($playerid);          
    $content4 = player_opponents_s($playerid);
    $content5 = player_activity_s($playerid);
    $content6 = player_actions_s($playerid);
    $content7 = player_history_weekly_s($playerid);

    if($game == "bfbc2")
      $content8 = player_bfbc2_globalstats($playerid);


      if ($groupbits > 0 || $limitplayerstats == 0)
      {
        if ($actionbased == 0)
        {
          if($game == "bfbc2")
          {
            $tabControl->defineSettings(1,$main_width,100,7,2,"center","middle",
            array($text["activity"],$text["weeklyhistory"], $text["actweapons"],$text["hitzones"],$text["mapachieve"], $text["worstenemies"], $text["globalstats"]),
            array($content5, $content7, $content1, $content2, $content3, $content4, $content8),
            array($text["last31days"],$text["weeklyhistoryexpl"],$text["favweapused"],$text["favhitzones"],$text["yourmapachiev"],$text["worstenemies"], $text["yourglobalstats"]));
          }
          else
          {
            $tabControl->defineSettings(1,$main_width,100,6,2,"center","middle",
            array($text["activity"],$text["weeklyhistory"], $text["actweapons"],$text["hitzones"],$text["mapachieve"], $text["worstenemies"]),
            array($content5, $content7, $content1, $content2, $content3, $content4),
            array($text["last31days"],$text["weeklyhistoryexpl"],$text["favweapused"],$text["favhitzones"],$text["yourmapachiev"],$text["worstenemies"]));
          }
        }
        else
        {
          if($game == "bfbc2")
          {
            $tabControl->defineSettings(1,$main_width,100,8,2,"center","middle",
            array($text["activity"],$text["weeklyhistory"], $text["actweapons"],$text["hitzones"],$text["mapachieve"], $text["actions"], $text["worstenemies"], $text["globalstats"]),
            array($content5, $content7, $content1, $content2, $content3, $content6, $content4, $content8),
            array($text["last31days"],$text["weeklyhistoryexpl"],$text["favweapused"],$text["favhitzones"],$text["yourmapachiev"],$text["actionbased"],$text["worstenemies"], $text["yourglobalstats"]));
          }
          else
          {
            $tabControl->defineSettings(1,$main_width,100,7,2,"center","middle",
            array($text["activity"],$text["weeklyhistory"], $text["actweapons"],$text["hitzones"],$text["mapachieve"], $text["actions"], $text["worstenemies"]),
            array($content5, $content7, $content1, $content2, $content3, $content6, $content4),
            array($text["last31days"],$text["weeklyhistoryexpl"],$text["favweapused"],$text["favhitzones"],$text["yourmapachiev"],$text["actionbased"],$text["worstenemies"]));
          }
        }
      }
      else
      {
        $tabControl->defineSettings(1,$main_width,100,2,2,"center","middle",
          array($text["activity"], $text["hitzones"]),
          array($content5, $content2),
          array($text["last31days"],$text["favhitzones"]));
      }
    
      $tabControl->defineStyle($ptab_backgroundColor,$ptab_selectedBgColor,$ptab_mouseOverColor,$ptab_borderColor,$ptab_borderSize,$ptab_borderStyle,$ptab_font,$ptab_textAlign,$ptab_fontSize,$ptab_fontWeight,$ptab_Color);
      //generate control
      $tabControl->writeControl();
    } 
 
  // -------------------------------------------------------------------------------

  if (isset($_GET['playerdbid']))
  { 
    $playerdbid = escape_string($_GET['playerdbid']);
    //make calls to show all data about a particular player
    player_short($playerdbid, true);
    echo "<br/>";
    if ($groupbits > 0 || $limitplayerstats == 0)
    {
      player_badges($playerdbid, true);
      echo "<br/>";
    }  
    // ------------------------------------------------------------------------------
    //player_weapons_s($playerid);              
    $tabControl    = new TabControl();     
    $content1 = player_weapons_s($playerdbid, true);
    $content2 = player_bodyparts_s($playerdbid, true);  
    $content3 = player_maps_s($playerdbid, true);          
    $content4 = player_opponents_s($playerdbid, true);
    $content5 = player_activity_s($playerdbid, true);          
    $content6 = player_actions_s($playerdbid, true);
    $content7 = player_history_weekly_s($playerdbid, true);

    if($game == "bfbc2")
      $content8 = player_bfbc2_globalstats($playerdbid, true);

    if ($groupbits > 0 || $limitplayerstats == 0)
    {
      if ($actionbased == 0)
      {
        if($game == "bfbc2")
        {
          $tabControl->defineSettings(1,$main_width,100,7,2,"center","middle",
          array($text["activity"],$text["weeklyhistory"], $text["actweapons"],$text["hitzones"],$text["mapachieve"], $text["worstenemies"], $text["globalstats"]),
          array($content5, $content7, $content1, $content2, $content3, $content4, $content8),
          array($text["last31days"],$text["weeklyhistoryexpl"], $text["favweapused"],$text["favhitzones"],$text["yourmapachiev"],$text["worstenemies"], $text["yourglobalstats"]));
        }
        else
        {
          $tabControl->defineSettings(1,$main_width,100,6,2,"center","middle",
          array($text["activity"],$text["weeklyhistory"], $text["actweapons"],$text["hitzones"],$text["mapachieve"], $text["worstenemies"]),
          array($content5, $content7, $content1, $content2, $content3, $content4),
          array($text["last31days"],$text["weeklyhistoryexpl"], $text["favweapused"],$text["favhitzones"],$text["yourmapachiev"],$text["worstenemies"]));
        }
      }
      else
      {
        if($game == "bfbc2")
        {
          $tabControl->defineSettings(1,$main_width,100,8,2,"center","middle",
          array($text["activity"],$text["weeklyhistory"], $text["actweapons"],$text["hitzones"],$text["mapachieve"], $text["actions"], $text["worstenemies"], $text["globalstats"]),
          array($content5, $content7, $content1, $content2, $content3, $content6, $content4, $content8),
          array($text["last31days"],$text["weeklyhistoryexpl"], $text["favweapused"],$text["favhitzones"],$text["yourmapachiev"],$text["actionbased"],$text["worstenemies"], $text["yourglobalstats"]));
        }
        else
        {
          $tabControl->defineSettings(1,$main_width,100,7,2,"center","middle",
          array($text["activity"],$text["weeklyhistory"], $text["actweapons"],$text["hitzones"],$text["mapachieve"], $text["actions"], $text["worstenemies"]),
          array($content5, $content7, $content1, $content2, $content3, $content6, $content4),
          array($text["last31days"],$text["weeklyhistoryexpl"], $text["favweapused"],$text["favhitzones"],$text["yourmapachiev"],$text["actionbased"],$text["worstenemies"]));
        }
      }
    }
    else
    {
      $tabControl->defineSettings(1,$main_width,100,1,2,"center","middle",
        array($text["activity"]),
        array($content5),
        array($text["last31days"]));
    }

    $tabControl->defineStyle($ptab_backgroundColor,$ptab_selectedBgColor,$ptab_mouseOverColor,$ptab_borderColor,$ptab_borderSize,$ptab_borderStyle,$ptab_font,$ptab_textAlign,$ptab_fontSize,$ptab_fontWeight,$ptab_Color);
    //generate control
    $tabControl->writeControl();
  }  
}

//
if ($func == "comp")
{
  $playerid = escape_string($_GET['playerid']);    
  $playerid2 = escape_string($_GET['playerid2']);    

  if (!isset($_GET['playerid']))
    die($text["noplayedid"]);
  if (!isset($playerid2))
    die($text["whoareyou"]);

  player_compare($playerid2, $playerid);
}

// show stats about a specific weapon
if ($func == "weapon")
{
  $weaponid = escape_string($_GET['weaponid']);
  if (isset($weaponid))
  { 
    //make calls to show all data about a particular player
    weapon_short($weaponid);
    echo "<br/>";
    weapon_players($weaponid);
  }
}

// show stats about a specific map
if ($func == "map")
{
  $mapid = escape_string($_GET['mapid']);
  if (isset($mapid))
  { 
    //make calls to show all data about a particular map
    map_short($mapid);
    echo "<br/>";
    map_players($mapid);
  }
}

if ($func == "show")
{
  global $clan_name;
  global $useppllist;
  global $b3_status_url;
  $pageid = escape_string($_GET['page']);
  if (!isset($pageid))
  { 
      $pageid = 1;
  }

  global $showclansearch;
  // show general data for index page
  welcometext();
  echo "<br/>";
  if($useppllist == 1)
  {
    $fp = @fopen($b3_status_url, "r");
    if (@fread($fp, 4096))
    {
      currentplayers();
      echo "<br/>";
    }
  }

  menubox($pageid);
  //echo "<br/>";

  $pagenumber = 1;
  if(isset($_GET['pagenumber']))
    $pagenumber = escape_string($_GET['pagenumber']);

  $offset = ($pagenumber-1)*$toplist_max;

  if($pageid == 1)
    topplayers("skill", "DESC", $offset, $clan_name);
  elseif($pageid == 2)
    topplayers("kills", "DESC", $offset, $clan_name);
  elseif($pageid == 3)
    topplayers("ratio", "DESC", $offset, $clan_name);
  elseif($pageid == 4)
  {
    $offset = ($pagenumber-1)*$weaplist_max;
    topweapons(false, "kills", "DESC", $offset);
  }
  elseif($pageid == 5)
  {
    $offset = ($pagenumber-1)*$maplist_max;
    topmaps(false, "kills", "DESC", $offset);
  }
  else 
    topplayers("skill");

  echo "<br/>";
  global_awards();   

  echo "<br/>";
  global_lame_awards();
}

// show a "clan" page with clan stats. This is the default as well
if ($func == "clan")
{
  if (isset($_GET['filter']))
    $clan_name = escape_string($_GET['filter']);
  elseif (isset($_POST['input_name']))
    $clan_name = escape_string($_POST['input_name']);
  $clan_name = unescape_hash($clan_name);

  if (isset($_GET['page']))
    $pageid = escape_string($_GET['page']);
  else
    $pageid = 1;

  // show general data for index page
  welcometext();
  echo "<br/>";
  /*currentplayers();
  echo "<br/>";*/

  menubox($pageid, $clan_name);

  $pagenumber = 1;
  if(isset($_GET['pagenumber']))
    $pagenumber = escape_string($_GET['pagenumber']);

  $offset = ($pagenumber-1)*$toplist_max;

  if($pageid == 1)
    topplayers("skill", "DESC", $offset, $clan_name);
  elseif($pageid == 2)
    topplayers("kills", "DESC", $offset, $clan_name);
  elseif($pageid == 3)
    topplayers("ratio", "DESC", $offset, $clan_name);
  elseif($pageid == 4)
  {
    $offset = ($pagenumber-1)*$weaplist_max;
    topweapons(false, "kills", "DESC", $offset);
  }
  elseif($pageid == 5)
  {
    $offset = ($pagenumber-1)*$maplist_max;
    topmaps(false, "kills", "DESC", $offset);
  }
  else 
    topplayers("skill");
}

// show a "index" page with general stats. This is the default as well
if ($func == "index")
{
  global $useppllist;
  global $b3_status_url;
  // show general data for index page
  welcometext();
  echo "<br/>";

  if($useppllist == 1)
  {
    $fp = @fopen($b3_status_url, "r");
    if (@fread($fp, 4096))
    {
      currentplayers();
      echo "<br/>";
    }
  }
  menubox(1);
  //echo "<br/>";

  topplayers("skill");
  echo "<br/>";
  global_awards();   
  echo "<br/>";
  global_lame_awards();
}

if($func == "medal")
{
  if(isset($_GET['fname'])) {
    $fname = $_GET['fname'];
    $all_medals = array_merge($pro_medals, $shame_medals);
    if( in_array($fname, $all_medals, true) ) eval($fname."();");
    else die('Hacking attempt!');
    }
}

// Close the page properly (footer)
displayfooter();
?>
