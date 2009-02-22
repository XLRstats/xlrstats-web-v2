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

include("lib/rss/FeedWriter.php");
include("inc_mysql.php");
include("func-globallogic.php");

session_start();
cleanglobals();

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
include($currentconfig);
include("languages/languages.php");

// Get other commandline parameters
if (isset($_GET['sortby']) && $_GET['sortby']!= "")
  $sortby = escape_string($_GET['sortby']);
else
  $sortby = "skill";

if (isset($_GET['direction']))
{
  $direction = escape_string($_GET['direction']);
  if ($direction != "DESC" || $direction != "ASC")
    $direction = "DESC";
}
else
  $direction = "DESC";

if (isset($_GET['filter']))
{
  $clan_name = escape_string($_GET['filter']);
  $clan_name = unescape_hash($clan_name);
}
else
  $clan_name = "";

if (isset($_GET['limit']))
  $limit = escape_string($_GET['limit']);
else
  $limit = $toplist_max;


$current_time = time();
$timelimit = $maxdays*60*60*24;
$statslink = httplink()."?config=".$currentconfignumber;
$feeddescription = "These are the top players of ".$statstitle." (ordered by ".$sortby."). Connect (with your ".$game." gameclient) to: ".$public_ip." and compete with them!";
$feeddescriptionshort = "XLRstats Top Players Feed";
$feedlogo = "http://www.bigbrotherbot.com/images/b3_power_88_2.gif";

//Creating an instance of FeedWriter class. 
$XLRfeed = new FeedWriter(RSS2);

//Setting the channel elements
//Use wrapper functions for common channel elements
$XLRfeed->setTitle($statstitle);
$XLRfeed->setLink($statslink);
$XLRfeed->setDescription($feeddescription);

//Image title and link must match with the 'title' and 'link' channel elements for valid RSS 2.0
$XLRfeed->setImage($feeddescriptionshort,$statslink,$feedlogo);

// DATABASE
$coddb = new sql_db($db_host, $db_user, $db_pass, $db_db, false);
if(!$coddb->db_connect_id) 
  die("Could not connect to the database");

//Detriving informations from database addin feeds
$query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills, deaths, ratio, skill, winstreak, losestreak, rounds, fixed_name, ip
    FROM ${t['b3_clients']}, ${t['players']}
    WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
    AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
    AND (${t['players']}.hide = 0)
    AND ($current_time - ${t['b3_clients']}.time_edit  < $timelimit)";
if ($clan_name != "")
  $query .= " AND (${t['b3_clients']}.name like '%%$clan_name%%')";
$query .= " ORDER BY $sortby $direction 
    LIMIT 0, $limit";

$result = $coddb->sql_query($query);
$timestamp = time();

$count = 1;
while ($row = $coddb->sql_fetchrow($result))
{
	//Create an empty FeedItem
	$newItem = $XLRfeed->createNewItem();
	
  if ($use_localtime == 1)
    $time_edit = date("j F Y, G:i T", $row['time_edit']+date("Z"));
  else
    $time_edit = date("j F Y, G:i", $row['time_edit']). " GMT";
	$tname = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
	$name = "#".$count.": ".$tname;
	$link = httplink()."?config=".$currentconfignumber."&func=player&playerid=".$row['id'];
	//$time_edit = $row['time_edit'];
  if ($sortby == "kills")
  	$description = "<strong>[Kills: ".$row['kills']."]</strong> [Skill: ".$row['skill']."] [Ratio: ".$row['ratio']."] [Deaths: ".$row['deaths']."] [Last seen: ".$time_edit." ]";
  elseif  ($sortby == "ratio")
  	$description = "<strong>[Ratio: ".$row['ratio']."]</strong> [Skill: ".$row['skill']."] [Kills: ".$row['kills']."] [Deaths: ".$row['deaths']."] [Last seen: ".$time_edit." ]";
  else
  	$description = "<strong>[Skill: ".$row['skill']."]</strong> [Ratio: ".$row['ratio']."] [Kills: ".$row['kills']."] [Deaths: ".$row['deaths']."] [Last seen: ".$time_edit." ]";
  //Add elements to the feed item
	$newItem->setTitle($name);
	$newItem->setLink($link);
	$newItem->setDate($timestamp);
	$newItem->setDescription($description);
	
	//Now add the feed item
	$XLRfeed->addItem($newItem);
	$count++;
	// Manipulate feed creation time to preserve correct sorting!
	$timestamp -= 60;
}

//OK. Everything is done. Now genarate the feed.
$XLRfeed->genarateFeed();

?>
