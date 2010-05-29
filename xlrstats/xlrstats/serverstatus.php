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

/***************************************************************************
 * READ ME & SCRIPT USAGE
 ***************************************************************************
 * This is an inclusion file to display your real time server status such as 
 * current map, current players, top 5 skill etc. on your website. In order  
 * to use this script, your website must be written in php.
 *
 * To use this script, open php file and insert following code where you want 
 * the server status window to be displayed.
 *
 * code: readfile('http://yourdomain.com/location/of/xlrstats/serverstatus.php?config=1');
 * 
 * Set $main_width if necessary! You can also modify css at the lower section 
 * of this page so that server status window better fits your web layout
 ***************************************************************************/

$main_width="100%"; // Enter a value (i.e. $main_width="400px";) if you need to set a fixed width.
$onlineplayers_bgcolor = ""; //Background color for online players. (you can leave blank)

include("inc_mysql.php");
include("func-globallogic.php");
include("func-block.php");
include("func-clan.php");
require_once("config/inc_constants.php");

//Add below, if you are running other game types, don't forget to use commas after each input EXCEPT for the last one
$gametypes = array(
                    "tdm" => "Team Death Match",
                    "ffa" => "Free For All",
                    "dm" => "Death Match",
                    "war" => "War",
                    "sd" => "Search & Destroy",
                    "htf" => "Hold the Flag",
                    "re" => "Retreival",
                    "ctf" => "Capture the Flag",
                    "hq" => "Head Quarters",
                    "ts" => "Team Survivor",
                    "lms" => "Last Man Standing",
                    "koth" => "King of the Hill"
                  );

$ffa_modes = array('dm', 'ffa', 'syc-ffa');

$images_folder = httplink() . 'images';

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
include($currentconfig);

//------------------------------------------------------------------------------
$coddb = new sql_db($db_host, $db_user, $db_pass, $db_db, false);
if(!$coddb->db_connect_id) {
    die('Cannot connect to database');
}

//------------------------------------------------------------------------------
// fetch the func variable, which tells us what we need to do
$func = escape_string($_GET['func']);

if ($func == "")
  $func = "skill";

//Get information from status file
if(@simplexml_load_file($b3_status_url)) //do we have a valid xml file?
{
  $xml=new simpleXMLElement($b3_status_url,NULL,TRUE);

  foreach($xml->Game->Data as $serverdata)
  {
    if ($serverdata['Name'] == "gamename")
      $gameName = $serverdata['Value'];

    if ($serverdata['Name'] == "sv_hostname")
      $servername = $serverdata['Value'];

    if ($serverdata['Name'] == "gameType")
      $gametype = $serverdata['Value'];

    if ($serverdata['Name'] == "sv_punkbuster")
      $punkbuster = $serverdata['Value'];

    if ($serverdata['Name'] == "mapName")
      $mapname = $serverdata['Value'];
  }
}

include_once('config/'.$game.'.php');
if(isset($m["$mapname"]))
  $nmapname = $m["$mapname"];
else
  $nmapname = $mapname;

if($punkbuster == 1)
  $punkbuster = "<span><font color=\"green\">On</font></span>";
else
  $punkbuster = "<span><font color=\"red\">Off</font></span>";

foreach($gametypes as $key => $value)
{
  if($key == $gametype)
  {
    $gametype_short = $key;
    $gametype = $value;
  }
}

function ColorizeName($s) 
{
    $corrupt_replacement = '<span style="background-color: yellow">&nbsp;</span>';
    
    $pattern[0]="^0";    $replacement[0]='</font><font color="black">';
    $pattern[1]="^1";    $replacement[1]='</font><font color="red">';
    $pattern[2]="^2";    $replacement[2]='</font><font color="lime">';
    $pattern[3]="^3";    $replacement[3]='</font><font color="yellow">';
    $pattern[4]="^4";    $replacement[4]='</font><font color="blue">';
    $pattern[5]="^5";    $replacement[5]='</font><font color="aqua">';
    $pattern[6]="^6";    $replacement[6]='</font><font color="#FF00FF">';
    $pattern[7]="^7";    $replacement[7]='</font><font color="white">';
    $pattern[8]="^8";    $replacement[8]='</font><font color="white">';
    $pattern[9]="^9";    $replacement[9]='</font><font color="gray">';
    $pattern[10]="\xff!\xff";    $replacement[10]=$corrupt_replacement;

    $s = str_replace($pattern, $replacement, htmlspecialchars($s));
    $i = strpos($s, '</font>');
    if ($i !== false)
        {return substr($s, 0, $i) . substr($s, $i+7, strlen($s)) . '</font>';}
    else
        {return $s;}
}

//ONLINE PLAYERS

include('lib/geoip.inc');
include('languages/en.php'); //Only English
include('func-playerlistlogic.php');

function listOnlinePlayers()
{
  global $ffa_modes;
  global $clientsBlue;
  global $clientsRed;
  global $clientsSpec;
  global $team1;
  global $team2;
  global $spectators;
  global $onlineplayers_bgcolor;
  global $gametype_short;
  global $geoip_path;

  if (!isset($pll_noteams))
    $pll_noteams = 0;

  loadData();
  
  echo "
    <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\">
    <tr class=\"serverstatus\"><td align=\"center\" class=\"onlineplayers\">Online Players";

  echo " (".(count($clientsBlue) + count($clientsRed) + count($clientsSpec))." Players)";
  echo "
    </td></tr><tr class=\"serverstatus\"><td class=\"serverstatus\">
    <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\">
    <tr class=\"serverstatus\">
    <td class=\"playerstitle_exp\" align=\"center\" width=\"\">Lp.</td>
    <td class=\"playerstitle_exp\" align=\"center\" width=\"\">Nick</td>
    <td class=\"playerstitle_exp\" align=\"center\">Score</td>";

  if (file_exists($geoip_path."GeoIP.dat"))
    echo "<td class=\"playerstitle_exp\" align=\"center\">Cntry</td>";

  echo "    <td class=\"playerstitle_exp\" align=\"center\">Level</td>
    <td class=\"playerstitle_exp\" align=\"center\">Con</td>
    </tr>";

  if (in_array($gametype_short, $ffa_modes) || ($pll_noteams != 0))
    {
      echo "<tr class=\"serverstatus\"><td class=\"teams\" colspan=6 align=\"center\" class=\"status-spectators\">Players (".count($clientsSpec).") </td></tr>";
      addClientsNew($clientsSpec, $onlineplayers_bgcolor);
    }
  else
  {
    echo "<tr class=\"serverstatus\"><td class=\"teams\" colspan=6 align=\"center\" class=\"status-blueteam\">$team2 (".count($clientsBlue).") </td></tr>";
    addClientsNew($clientsBlue, $onlineplayers_bgcolor);
    echo "<tr class=\"serverstatus\"><td class=\"teams\" colspan=6 align=\"center\" class=\"status-redteam\">$team1 (".count($clientsRed).") </td></tr>";
    addClientsNew($clientsRed, $onlineplayers_bgcolor);
    echo "<tr class=\"serverstatus\"><td class=\"teams\" colspan=6 align=\"center\" class=\"status-spectators\">$spectators (".count($clientsSpec).") </td></tr>";
    addClientsNew($clientsSpec, $onlineplayers_bgcolor);
  }

  echo " 
         </table> 
       </table>";
}

function addClientsNew($clients, $backgroundColor)
{
  global $geoip_path;
  global $public_ip;
  global $currentconfignumber;
  global $onlineplayers_bgcolor;
  global $images_folder;

  $link = baselink();

  $x = 1;
  foreach($clients as $client)
  {       
    echo '<tr bgcolor="'.$onlineplayers_bgcolor.'" valign="middle" class="playerlist">
    <td style="background:'.$onlineplayers_bgcolor.' none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" align="center">'.$x.'</td>';
    if($client -> levelInt == 0)
      echo '<td style="background: '.$onlineplayers_bgcolor.' none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" align="center">'.(utf2iso(ColorizeName($client -> colorname))).'</td>';
    else 
      echo '<td style="background: '.$onlineplayers_bgcolor.' none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" align="center"><a href='.$link.'?func=player&playerdbid='.($client -> dbid).'&config=' .$currentconfignumber .'>'.(utf2iso(ColorizeName($client -> colorname))).'</a></td>';
    echo '<td style="background: '.$onlineplayers_bgcolor.' none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" align="center">'.$client -> score.'</td>';

    if (file_exists($geoip_path."GeoIP.dat"))
    {
      if ($client -> level == "BOT")
      {
        $tip = explode(":", $public_ip);
        $ip = $tip[0];
      }
      else
        $ip = $client -> ip;
      $geocountry = $geoip_path."GeoIP.dat";
      $gi = geoip_open($geocountry,GEOIP_STANDARD);
      $countryid = strtolower (geoip_country_code_by_addr($gi, $ip));
      $country = geoip_country_name_by_addr($gi, $ip);
      if ( !is_null($countryid) and $countryid != "") 
        $flag = "<img src=\"".$images_folder."/flags/".$countryid.".gif\" title=\"".$country."\" alt=\"".$country."\">";
      else 
        $flag = "<img width=\"16\" height=\"11\" src=\"".$images_folder."/spacer.gif\" title=\"".$country."\" alt=\"".$country."\">"; 

      geoip_close($gi);
      echo '<td style="background: '.$onlineplayers_bgcolor.' none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" align="center">'.$flag.'</td>';
    }

    echo '<td style="background: '.$onlineplayers_bgcolor.' none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" align="center">'.$client -> level.'</td>';
    echo '<td style="background: '.$onlineplayers_bgcolor.' none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" align="center">'.$client -> connections.'</td>
    </tr>';
    $x++;
  }
}

if(!isset($pop))
  $pop = 1;

$currentpath = abs_pathlink($pop);

//Current map image
if(file_exists($currentpath.'images/maps/'.$game.'/middle/'.$mapname.'.jpg'))
  $img_map = $images_folder.'/maps/'.$game.'/middle/'.$mapname.'.jpg';
else 
  $img_map = $images_folder.'/maps/nomapimage.jpg';

//Background pattern image
$img_pattern = $images_folder.'/pattern.gif';
?>
<style type="text/css">
.maintable{
    background:#070707;
}
.map{
    background: #1B1B1B;
    padding: 6px;
}
.servername{
    background-image: url(<?php echo $img_pattern; ?>);
    border-top: 1px solid #48780E;
    border-bottom: 1px solid #222;
    height: 34px;
    font-weight: bold;
}
.serverinfo{
    border-bottom: 1px dotted #222;
}
.onlineplayers{
    background-image: url(<?php echo $img_pattern; ?>);
}
.playerstitle_exp{
    background-image: url(<?php echo $img_pattern; ?>);
    border-bottom: 1px solid #222;
}
.teams{
    background-image: url(<?php echo $img_pattern; ?>);
    border-bottom: 1px solid #222;
}
.playerlist{
    border-bottom: 1px dotted #222;
}
.topfive{
    border: 1px solid #222;
    padding: 5px;
}
.bottom {
    background-image: url(<?php echo $img_pattern; ?>);
    border-top: 1px solid #222;
    border-bottom: 1px solid #222;
    padding-right: 10px;
}
tr.serverstatus {
    border:0px;
    padding:0px;
}
td.serverstatus {
    border:0px;
    padding:0px;
}
</style>

<table class="maintable" width="<?php echo $main_width; ?>" border="0" cellpadding="0" cellspacing="0">
  <tr class="serverstatus">
    <td class="serverstatus" width="150" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr class="serverstatus">
        <td class="serverstatus" colspan="4" align="center"><img class="map" src="<?php echo $img_map ?>">
        </td>
      </tr>
      <tr class="serverstatus">
        <td class="serverstatus">
          <table width="100%" border="0" cellpadding="5" cellspacing="0">
            <td class="map" align="center">Con:<?php echo gamelauncher('xfire'); echo gamelauncher('qtracker'); echo gamelauncher('gsc'); echo gamelauncher('hlsw'); ?></td>
          </table>
        </td>
      </tr>
      <tr class="serverstatus">
        <td class="topfive" colspan="4"><?php topplayersblock($sortby=$func); ?></td>
      </tr></table>
    </td>
    <td class="serverstatus" width="5">&nbsp;</td>
    <td class="serverstatus" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr class="serverstatus">
        <td class="serverstatus">
          <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr class="serverstatus">
              <td colspan="3" class="servername"><?php echo utf2iso(ColorizeName($servername)); ?></td>
            </tr>
            <tr class="serverinfo">
              <td class="serverstatus" width="100" align="left">Game</td><td width="5">:</td><td align="left"><?php echo $gameName; ?></td>
            </tr>
            <tr class="serverinfo">
              <td class="serverstatus" align="left">Server IP</td><td class=\"serverstatus\">:</td><td align="left"><?php echo $public_ip; ?></td>
            </tr>
            <tr class="serverinfo">
              <td class="serverstatus" align="left">Current Map</td><td class=\"serverstatus\">:</td><td align="left"><?php echo $nmapname; ?></td>
            </tr>
            <tr class="serverinfo">
            <td class="serverstatus" align="left">Game Type</td><td class=\"serverstatus\">:</td><td align="left"><?php echo $gametype; ?></td>
            </tr>
            <tr class="serverinfo">
              <td class="serverstatus" align="left">Punkbuster</td><td class=\"serverstatus\">:</td><td align="left"><?php echo $punkbuster; ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr class="serverstatus">
        <td class="serverstatus"><?php listOnlinePlayers(); ?></td>
      </tr></table>    
    </td>
  </tr>
  <tr class="serverstatus">
    <td colspan="3" class="bottom" align="right">Powered by: <a href="http://www.xlrstats.com" target="_blank" title="XLRstats: Real Time Game Stats">XLRstats</a></td>
  </tr>
</table>