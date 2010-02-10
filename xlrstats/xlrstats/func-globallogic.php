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

$clientsRed  = array();
$clientsBlue  = array();
$clientsSpec  = array();
$supportedgames = array('cod', 'coduo', 'cod2', 'cod4', 'cod5', 'etpro', 'iourt41', 'smg', 'wop'); // B3 parsernames
$ffa_modes = array('dm', 'ffa', 'syc-ffa');

$sv_privateClients = 0;
$gameType = "";
$mapName = "";
$sv_maxclients = 0;
$shortversion = 0;
$sv_hostname = "";


function baselink()
{
  return $_SERVER['PHP_SELF'];
}

function abs_pathlink($pop=0)
{
  $serversoftware = $_SERVER['SERVER_SOFTWARE'];
  if (substr($serversoftware,0,6)=="Apache")
  {  
    $ptemp = explode("/", GetFileDir($_SERVER['SCRIPT_FILENAME']));
    //array_shift($ptemp);
    array_pop($ptemp);
    while ($pop > 0)
    {
      array_pop($ptemp);
      $pop--;
    }
    return implode("/", $ptemp)."/";
  }
  else return $_SERVER['APPL_PHYSICAL_PATH'];

}

function pathlink($pop=0)
{
  $ptemp = explode("/", GetFileDir($_SERVER['PHP_SELF']));
  //$ptemp = explode("/", getcwd());
  //array_shift($ptemp);
  array_pop($ptemp);
  while ($pop > 0)
  {
    array_pop($ptemp);
    $pop--;
  }
  return implode("/", $ptemp)."/";
}

function httplink($pop=0)
{
  $ptemp = explode("/", GetFileDir($_SERVER['PHP_SELF']));
  //array_shift($ptemp);
  array_pop($ptemp);
  while ($pop > 0)
  {
    array_pop($ptemp);
    $pop--;
  }
  return "http://".$_SERVER['HTTP_HOST'].implode("/", $ptemp)."/";
}

function getvisitorip()
{
  // Get the visitors IP address
  return $_SERVER['REMOTE_ADDR']; 
}

function checklang($pop=0)
{
  global $lang_file;
  //var_dump($lang_file);
  if ($lang_file != 'en.php')
    return "<a href=index.php?func=savelang><img src=\"".pathlink($pop)."images/flags/gb.gif\" border=\"0\" align=\"absmiddle\" title=\"Switch to English\"></a>&nbsp;";
}

function checkinstalldir()
{
  $configfiles = scandir('config');
  // Check the [array] config dir for a filename containing 'statsconfig'
  $statsconfig_exists = array_find('statsconfig', $configfiles);
  if (is_dir('install') && $statsconfig_exists)
  {
    echo '<html>
<head>
<title>XLRstats B3 - ERROR</title>
  <style type="text/css">
  body{text-align: center; font-family:Arial, Helvetica, sans-serif; font-weight: bold}
  </style>
</head>
<body>
  <p>We found a valid configfile for XLRstats, seems you have finished installation.</p>
  <p>However, your installation directory is still at the default location!<br />
  Before you can continue, you need to</p>
  <p style="font-size:1.5em; color: red"><i>Remove</i> or <i>Rename</i> your installation directory.</p>
</body>
</html>';
    exit;
  }
  elseif (is_dir('install'))
  {
    // Not installed yet, forward to the install folder
    $install_loc =  httplink() . 'install/';
    header("Location: $install_loc");
  }
}

function array_find($needle, $haystack) // Find a part of a value in an array 
{
  foreach ($haystack as $item)
  {
    if (strpos($item, $needle) !== false)
    {
      return true;
      break;
    }
  }
  return false;
}

function sumuparrays($array1, $array2) //sum up two arrays
{
  if(($array1 != NULL) && ($array2 != NULL))
  {
    for($i=0; $i<count($array1); $i++)
    {
      $arraytotal[] = $array1[$i] + $array2[$i];
    }
    return $arraytotal;
  }
}

function cleanglobals()
{
  if (ini_get('register_globals') == 1)
  {
    if (is_array($_REQUEST)) foreach(array_keys($_REQUEST) as $var_to_kill) unset($$var_to_kill);
    if (is_array($_SESSION)) foreach(array_keys($_SESSION) as $var_to_kill) unset($$var_to_kill);
    if (is_array($_SERVER))  foreach(array_keys($_SERVER)  as $var_to_kill) unset($$var_to_kill);
    unset($var_to_kill);
  }
}

function feedlink($pop=0)
{
  global $currentconfignumber;
  global $clan_name;
  global $rss_sortby;
  global $text;

  $url_clan_name = escape_hash($clan_name);

  if ($rss_sortby == "")
    $rss_sortby = "skill";

	if ($clan_name != "")
    $temp = "<a href=\"".pathlink($pop)."rss.php?config=".$currentconfignumber."&sortby=".$rss_sortby."&filter=".$url_clan_name."\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/feed.png\" border=\"0\" align=\"absbottom\" title=\"".$text["rssfiltered"]."\"></a>\n";
	else
    $temp = "<a href=\"".pathlink($pop)."rss.php?config=".$currentconfignumber."&sortby=".$rss_sortby."\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/feed.png\" border=\"0\" align=\"absbottom\" title=\"".$text["rssfeed"]."\"></a>\n";

  return $temp;
}

function info()
{
  phpinfo();
}

// My own function for neutralizing harmful input
function escape_string($data)
{
  $patterns[0] = "/\"/";
  $patterns[1] = "/\'/";
  $patterns[2] = "/\n/";
  $patterns[3] = "/\r/";
  $patterns[4] = "/%/";
  $patterns[5] = "/_/";

  $replacements[0]= "\\\"";
  $replacements[1] = "\\\'";
  $replacements[2] = "\\n";
  $replacements[3]= "\\r";
  $replacements[4] = "\\%'";
  $replacements[5] = "\\_";

  ksort($patterns);
  ksort($replacements);

  return preg_replace($patterns, $replacements, $data);
}

function escape_hash($data)
{
  $patterns[0] = "/#/";

  $replacements[0] = "-hashsign-";

  ksort($patterns);
  ksort($replacements);

  return preg_replace($patterns, $replacements, $data);
}

function unescape_hash($data)
{
  $patterns[0] = "/-hashsign-/";

  $replacements[0] = "#";

  ksort($patterns);
  ksort($replacements);

  return preg_replace($patterns, $replacements, $data);
}

function getCurrentMapName($servstatus)
{
  $pattern  = "/map: ([A-Za-z]{2}_[A-Za-z]+)/";
  $arraynum = preg_match($pattern, $servstatus, $stat);
  if($arraynum > 0)
  {
      $map = preg_replace ("/map: /", "", $stat[0]);
      return $map;
  }
  else 
  {
      return "n/a";
  }
}

function utf2iso($tekst)
{                                        
  $nowytekst = str_replace("%u0104","\xA1",$tekst);    //•
  $nowytekst = str_replace("%u0106","\xC6",$nowytekst);    //∆
  $nowytekst = str_replace("%u0118","\xCA",$nowytekst);    // 
  $nowytekst = str_replace("%u0141","\xA3",$nowytekst);    //£
  $nowytekst = str_replace("%u0143","\xD1",$nowytekst);    //—
  $nowytekst = str_replace("%u00D3","\xD3",$nowytekst);    //”
  $nowytekst = str_replace("%u015A","\xA6",$nowytekst);    //å
  $nowytekst = str_replace("%u0179","\xAC",$nowytekst);    //è
  $nowytekst = str_replace("%u017B","\xAF",$nowytekst);    //Ø

  $nowytekst = str_replace("%u0105","\xB1",$nowytekst);    //π
  $nowytekst = str_replace("%u0107","\xE6",$nowytekst);    //Ê
  $nowytekst = str_replace("%u0119","\xEA",$nowytekst);    //Í
  $nowytekst = str_replace("%u0142","\xB3",$nowytekst);    //≥
  $nowytekst = str_replace("%u0144","\xF1",$nowytekst);    //Ò
  $nowytekst = str_replace("%u00D4","\xF3",$nowytekst);    //Û
  $nowytekst = str_replace("%u015B","\xB6",$nowytekst);    //ú
  $nowytekst = str_replace("%u017A","\xBC",$nowytekst);    //ü
  $nowytekst = str_replace("%u017C","\xBF",$nowytekst);    //ø

  $nowytekst = str_replace("%3c","<",$nowytekst);    //ø
  $nowytekst = str_replace("%3e",">",$nowytekst);    //ø
  $nowytekst = str_replace("%26","&",$nowytekst);    //ø


  return ($nowytekst);
}

function utf16_2_utf8 ($nowytekst) 
{
  $nowytekst = str_replace('•','%u0104',$nowytekst);    //•
  $nowytekst = str_replace('∆','%u0106',$nowytekst);    //∆
  $nowytekst = str_replace(' ','%u0118',$nowytekst);    // 
  $nowytekst = str_replace('£','%u0141',$nowytekst);    //£
  $nowytekst = str_replace('—','%u0143',$nowytekst);    //—
  $nowytekst = str_replace('”','%u00D3',$nowytekst);    //”
  $nowytekst = str_replace('å','%u015A',$nowytekst);    //å
  $nowytekst = str_replace('è','%u0179',$nowytekst);    //è
  $nowytekst = str_replace('Ø','%u017B',$nowytekst);    //Ø

  $nowytekst = str_replace('π','%u0105',$nowytekst);    //π
  $nowytekst = str_replace('Ê','%u0107',$nowytekst);    //Ê
  $nowytekst = str_replace('Í','%u0119',$nowytekst);    //Í
  $nowytekst = str_replace('≥','%u0142',$nowytekst);    //≥
  $nowytekst = str_replace('Ò','%u0144',$nowytekst);    //Ò
  $nowytekst = str_replace('Û','%u00F3',$nowytekst);    //Û
  $nowytekst = str_replace('ú','%u015B',$nowytekst);    //ú
  $nowytekst = str_replace('ü','%u017A',$nowytekst);    //ü
  $nowytekst = str_replace('ø','%u017C',$nowytekst);    //ø

  return ($nowytekst);
} 

// credit: http://sourceforge.net/projects/phgstats/
function quake3color($text) {
	$clr = array ( // colors
	"\"#000000\"", "\"#DA0120\"", "\"#00B906\"", "\"#E8FF19\"", //  1
	"\"#170BDB\"", "\"#23C2C6\"", "\"#E201DB\"", "\"#FFFFFF\"", //  2
	"\"#CA7C27\"", "\"#757575\"", "\"#EB9F53\"", "\"#106F59\"", //  3
	"\"#5A134F\"", "\"#035AFF\"", "\"#681EA7\"", "\"#5097C1\"", //  4
	"\"#BEDAC4\"", "\"#024D2C\"", "\"#7D081B\"", "\"#90243E\"", //  5
	"\"#743313\"", "\"#A7905E\"", "\"#555C26\"", "\"#AEAC97\"", //  6
	"\"#C0BF7F\"", "\"#000000\"", "\"#DA0120\"", "\"#00B906\"", //  7
	"\"#E8FF19\"", "\"#170BDB\"", "\"#23C2C6\"", "\"#E201DB\"", //  8
	"\"#FFFFFF\"", "\"#CA7C27\"", "\"#757575\"", "\"#CC8034\"", //  9
	"\"#DBDF70\"", "\"#BBBBBB\"", "\"#747228\"", "\"#993400\"", // 10
	"\"#670504\"", "\"#623307\""                                // 11
	);

	$replace = array (
	"&<font color=$clr[0]>", "&<font color=$clr[1]>",   //  1
	"&<font color=$clr[2]>", "&<font color=$clr[3]>",   //  2
	"&<font color=$clr[4]>", "&<font color=$clr[5]>",   //  3
	"&<font color=$clr[6]>", "&<font color=$clr[7]>",   //  4
	"&<font color=$clr[8]>", "&<font color=$clr[9]>",   //  5
	"&<font color=$clr[10]>", "&<font color=$clr[11]>", //  6
	"&<font color=$clr[12]>", "&<font color=$clr[13]>", //  7
	"&<font color=$clr[14]>", "&<font color=$clr[15]>", //  8
	"&<font color=$clr[16]>", "&<font color=$clr[17]>", //  9
	"&<font color=$clr[18]>", "&<font color=$clr[19]>", // 10
	"&<font color=$clr[20]>", "&<font color=$clr[21]>", // 11
	"&<font color=$clr[22]>", "&<font color=$clr[23]>", // 12
	"&<font color=$clr[24]>", "&<font color=$clr[25]>", // 13
	"&<font color=$clr[26]>", "&<font color=$clr[27]>", // 14
	"&<font color=$clr[28]>", "&<font color=$clr[29]>", // 15
	"&<font color=$clr[30]>", "&<font color=$clr[31]>", // 16
	"&<font color=$clr[32]>", "&<font color=$clr[33]>", // 17
	"&<font color=$clr[34]>", "&<font color=$clr[35]>", // 18
	"&<font color=$clr[36]>", "&<font color=$clr[37]>", // 19
	"&<font color=$clr[38]>", "&<font color=$clr[39]>", // 20
	"&<font color=$clr[40]>", "&<font color=$clr[41]>", // 21
	"", "", "", "", "", "",                             // 22
	"", "</font><", "\$1"                               // 23
	);

	$search  = array (
	"/\^0/", "/\^1/", "/\^2/", "/\^3/",        //  1
	"/\^4/", "/\^5/", "/\^6/", "/\^7/",        //  2
	"/\^8/", "/\^9/", "/\^a/", "/\^b/",        //  3
	"/\^c/", "/\^d/", "/\^e/", "/\^f/",        //  4
	"/\^g/", "/\^h/", "/\^i/", "/\^j/",        //  5
	"/\^k/", "/\^l/", "/\^m/", "/\^n/",        //  6
	"/\^o/", "/\^p/", "/\^q/", "/\^r/",        //  7
	"/\^s/", "/\^t/", "/\^u/", "/\^v/",        //  8
	"/\^w/", "/\^x/", "/\^y/", "/\^z/",        //  9
	"/\^\//", "/\^\*/", "/\^\-/", "/\^\+/",    // 10
	"/\^\?/", "/\^\@/", "/\^</", "/\^>/",      // 11
	"/\^\&/", "/\^\)/", "/\^\(/", "/\^[A-Z]/", // 12
	"/\^\_/",                                  // 14
	"/&</", "/^(.*?)<\/font>/"                 // 15
	);
	$ctext = preg_replace($search, $replace, $text);

	if ($ctext != $text)
	{
		$ctext = preg_replace("/$/", "</font>", $ctext);
		$ctext = preg_replace("/<font color=\"#[0-9A-F]{6}\"><\/font>/", "", $ctext);
	}
	return $ctext;
}

function removequake3color($text) {
	$search  = array (
	"/\^0/", "/\^1/", "/\^2/", "/\^3/",        //  1
	"/\^4/", "/\^5/", "/\^6/", "/\^7/",        //  2
	"/\^8/", "/\^9/", "/\^a/", "/\^b/",        //  3
	"/\^c/", "/\^d/", "/\^e/", "/\^f/",        //  4
	"/\^g/", "/\^h/", "/\^i/", "/\^j/",        //  5
	"/\^k/", "/\^l/", "/\^m/", "/\^n/",        //  6
	"/\^o/", "/\^p/", "/\^q/", "/\^r/",        //  7
	"/\^s/", "/\^t/", "/\^u/", "/\^v/",        //  8
	"/\^w/", "/\^x/", "/\^y/", "/\^z/",        //  9
	"/\^\//", "/\^\*/", "/\^\-/", "/\^\+/",    // 10
	"/\^\?/", "/\^\@/", "/\^</", "/\^>/",      // 11
	"/\^\&/", "/\^\)/", "/\^\(/", "/\^[A-Z]/", // 12
	"/\^\_/",                                  // 14
	"/&</", "/^(.*?)<\/font>/"                 // 15
	);
	$ctext = preg_replace($search, "", $text);
	return $ctext;
}

function cmp($a, $b)
{
    // it must be inverted 
	if(($a -> score) >  ($b -> score))
		return -1;
	if(($a -> score) <  ($b -> score))
		return 1;
	if(($a -> score) ==  ($b -> score))
		return 0;
}


// Welcometext acting as an introduction on the Main index of xlrstats
function welcometext($pop=0)
{
  global $func;
  global $currentconfig;
  include($currentconfig);

  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $m;
  global $minkills;
  global $minrounds;
  global $bp_head;
  global $text;
  
  // test if the status file exists
  $fp = @fopen($b3_status_url, "r");
  if (!@fread($fp, 4096))
    return;
  
  // load data from settings.xml
  loadData();	  

  $query = "SELECT SUM( kills ) AS kills FROM ${t['players']} WHERE 1";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $kills = $row['kills']; 

  $result = null;
  $row = null;

  $query = "SELECT SUM(kills) as kills FROM ${t['playerbody']} WHERE bodypart_id IN $bp_head";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $headshots = $row['kills']; 

  $result = null;
  $row = null;

  $hpk = 0;

  if ($kills>0)
      $hpk = sprintf("%.4f", ($headshots/$kills));
  else  
      $hpk = sprintf("%.4f", 0); 	


  $query = "SELECT SUM( rounds ) AS rounds FROM ${t['maps']} WHERE 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $rounds = $row['rounds']; 

  $result = null;
  $row = null;	  

  $query = " SELECT count( client_id ) AS players FROM ${t['players']} WHERE 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $players = $row['players']; 

  $result = null;
  $row = null;	   

  //$statusgame = htmlspecialchars( rcon("status"));

  //$currentmap = getCurrentMapName($statusgame);

  global $clientsRed;
  global $clientsBlue;
  global $clientsSpec;  

  global $sv_hostname;
  global $sv_privateClients;
  global $gameType;
  global $mapName;
  global $sv_maxclients;
  global $shortversion;


  $result = null;
  $row = null;	

  $curnumplayers = (count($clientsBlue) + count($clientsRed) + count($clientsSpec));
  $currentmap = $mapName;

  $maxPlayers = $sv_maxclients - $sv_privateClients;

  // Replace the mapname with a friendly name
  if (isset($m[$currentmap]))
    $currentmap = $m[$currentmap];

  $today = date('l jS \of F Y h:i:s A');
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\">";
  if ($func != "server") echo "<tr><td align=\"center\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$text["welcome"]."&nbsp;&nbsp;&nbsp;<span class=\"tiny\">($today)</span></td><td width=\"40px\">".checklang($pop)."<a href=\"http://xlrstatshelp.xlr8or.com\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/help.png\" border=\"0\" align=\"absmiddle\" title=\"Need help on XLRstats?\"></a></td></tr>";
  echo "<tr>
      <td colspan=\"2\">
        <table align=\"center\" bgcolor=\"#99aaaa\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\" width=\"100%\">
      	<tr bgcolor=\"#cccccc\" valign=\"bottom\">
      		<td style=\"padding: 4px;\" width=\"37%\">
            <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
            <tr><td><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["server"]."</font></font></td>
            <td><div align=\"right\">
    ";
      echo gamelauncher('xfire');
      echo gamelauncher('qtracker');
      echo gamelauncher('gsc');
      echo gamelauncher('hlsw');
      
      echo "
      </div></td><tr></table>
      </td>
  		<td style=\"padding: 4px;\" width=\"18%\"><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["address"]."</font></font></td>
  		<td style=\"padding: 4px;\" align=\"center\" width=\"14%\"><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["map"]."</font></font></td>
  		<td style=\"padding: 4px;\" align=\"center\" width=\"10%\"><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["playing"]."</font></font></td>
  		<td style=\"padding: 4px;\" align=\"center\" width=\"7%\"><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["rounds"]."</font></font></td>
  		<td style=\"padding: 4px;\" align=\"center\" width=\"10%\"><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["players"]."</font></font></td>
  		<td style=\"padding: 4px;\" align=\"center\" width=\"6%\"><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["killed"]."</font></font></td>
  		<td style=\"padding: 4px;\" align=\"center\" width=\"6%\"><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["headshots"]."</font></font></td>
  		<td style=\"padding: 4px;\" align=\"center\" width=\"6%\"><font class=\"fontSmall\" size=\"1\"><font color=\"#000000\">&nbsp;".$text["hpk"]."</font></font></td>
  	</tr>";

  $flag = NULL;
  if (file_exists($geoip_path."GeoIP.dat"))
  {
    $geocountry = $geoip_path."GeoIP.dat";
    $ip = explode(":", $public_ip);
    $ip = $ip[0];
    $gi = geoip_open($geocountry,GEOIP_STANDARD);
    $countryid = strtolower (geoip_country_code_by_addr($gi, $ip));
    $country = geoip_country_name_by_addr($gi, $ip);
    if ( !is_null($countryid) and $countryid != "") 
      $flag = "<img style=\"vertical-align: middle;\" src=\"images/flags/".$countryid.".gif\" title=\"".$country."\" alt=\"".$country."\">";
    geoip_close($gi);
  }

  echo "
  	<tr bgcolor=\"#cccccf\" valign=\"middle\">
  		<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"left\"><font class=\"fontNormal\" size=\"2\"><img style=\"vertical-align: middle;\" src=\"images/ico/icon_$game.gif\">&nbsp;$flag&nbsp;<b><a class=info  href=\"#\">$sv_hostname<span>".$text["serverversion"]."$shortversion</span></a></b></font></td>
    	<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"left\"><font class=\"fontNormal\" size=\"2\">$public_ip</font></td>
    	<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"center\"><font class=\"fontNormal\" size=\"2\">$currentmap ($gameType)</font></td>
    	<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"center\"><font class=\"fontNormal\" size=\"2\">$curnumplayers/$maxPlayers ($sv_maxclients)</font></td>
    	<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"center\"><font class=\"fontNormal\" size=\"2\">$rounds</font></td>
    	<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"center\"><font class=\"fontNormal\" size=\"2\">$players</font></td>
    	<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"center\"><font class=\"fontNormal\" size=\"2\">$kills</font></td>
    	<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"center\"><font class=\"fontNormal\" size=\"2\">$headshots</font></td>
    	<td style=\"background: white none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: black;\" align=\"center\"><font class=\"fontNormal\" size=\"2\">$hpk</font></td>
  	</tr>
   </table> 
 </td>
 </tr>
 </table>
      ";
  flush();
}

function gamelauncher($type)
{
  global $currentconfig;
  global $text;
  include($currentconfig);

  if ($type == 'xfire')
  {
    if ($game == 'cod1') $tgame = 'codmp';
    if ($game == 'coduo') $tgame = 'coduomp';
    if ($game == 'cod2') $tgame = 'cod2mp';
    if ($game == 'cod4') $tgame = 'cod4mp';
    if ($game == 'codwaw') $tgame = 'codwawmp';
    if ($game == 'urt') $tgame = 'utq3';
    if ($game == 'q3a') $tgame = 'q3';    
    if ($game == 'wop') $tgame = 'wopad';    
    $link = ' <a href="xfire:join?game='.$tgame.'&amp;server='.$public_ip.'"><img src="images/ico/icon_xfire.jpg" title="'.$text["conwxfire"].'" alt="xfire" width="16" height="16" border="0" align="absmiddle" id="xfire" /></a>'; 
  }
  elseif ($type == 'qtracker')
  {
    if ($game == 'cod1') $tgame = 'CallOfDuty';
    if ($game == 'coduo') $tgame = 'CallOfDutyUnitedOffensive';
    if ($game == 'cod2') $tgame = 'CallOfDuty2';
    if ($game == 'cod4') $tgame = 'CallOfDuty4';
    if ($game == 'codwaw') $tgame = 'CallOfDutyWorldAtWar';
    if ($game == 'urt') $tgame = 'UrbanTerror';
    if ($game == 'q3a') $tgame = 'Quake3';    
    if ($game == 'wop') $tgame = 'WorldOfPadman';    
    $link = ' <a href="qtracker://'.$public_ip.'/?game='.$tgame.'&action=join"><img src="images/ico/icon_qtracker.jpg" title="'.$text["conwqtracker"].'" alt="qtracker" width="16" height="16" border="0" align="absmiddle" id="qtracker" /></a>';
  }
  elseif ($type == 'hlsw')
  {
    $link = ' <a href="hlsw://'.$public_ip.'"><img src="images/ico/icon_hlsw.jpg" title="'.$text["conwhlsw"].'" alt="hlsw" width="16" height="16" border="0" align="absmiddle" id="hlsw" /></a>';
  }
  elseif ($type == 'gsc')
  {
    if ($game == 'cod1') $tgame = 'cod';
    if ($game == 'coduo') $tgame = 'uo';
    if ($game == 'cod2') $tgame = 'cod2';
    if ($game == 'cod4') $tgame = 'cod4';
    if ($game == 'codwaw') $tgame = 'codww';
    if ($game == 'urt') $tgame = 'urbanterror';
    if ($game == 'q3a') $tgame = 'q3';    
    if ($game == 'wop') $tgame = 'wop';    
    $temp = explode(":", $public_ip);
    $link = ' <a href="gsc://joinGame:game='.$tgame.'&ip='.$temp[0].'&port='.$temp[1].'"><img src="images/ico/icon_gsc.jpg" title="'.$text["conwgsc"].'" alt="gsc" width="16" height="16" border="0" align="absmiddle" id="gsc" /></a>';
  }
  return $link;
}


// These 4 functions open a table with width $twidth and a row to contain cells of the function opencell
function opentablerow($twidth=100)
{
  echo "<table width=\"$twidth%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr>";
}

function closetablerow()
{
	echo "</tr></table>";
}

function opentablecell($cwidth=100)
{
  echo "<td width=\"$cwidth%\" class=\"innertable\">";
}

function closetablecell()
{
	echo "</td>";
}

// This function emits a description for the specified weapon/map
function get_desc($name)
{
  global $module_name;
  global $text;   
  $path = "desc/$name.txt";

  if ( file_exists("$path") )
    readfile($path);
  else
  {
    $path = "desc/".dirname($name)."/nodesc.txt";
    if ( file_exists("$path") )
      readfile($path);
    else
      echo $text["nodescavail"];
  }
}

// This function emits a <img /> tag for the specified image
// It finds out itself if the imqage is png, jpg or gif
function get_pic($name, $recurse = 1)
{
  global $module_name;   
  $basepath = "$name";

  if ( file_exists("$basepath.png") )
    echo "<img src=\"$basepath.png\" class=\"images\" />";
  else if ( file_exists("$basepath.jpg") )
    echo "<img src=\"$basepath.jpg\" class=\"images\" />";
  else if ( file_exists("$basepath.gif") )
    echo "<img src=\"$basepath.gif\" class=\"images\" />";

  // Warning: ugly hack arising!!
  else if ($recurse == 1)
  {
    $basepath = dirname($name)."/nopic";
    get_pic($basepath, 0);    
  }
}

//usage: GetFileDir($_SERVER['PHP_SELF']); 
function GetFileDir($php_self)
{
  $filename2 = "";
  $filename = explode("/", $php_self); // THIS WILL BREAK DOWN THE PATH INTO AN ARRAY
  for( $i = 0; $i < (count($filename) - 1); ++$i )
    {
    $filename2 .= $filename[$i].'/';
    }
  return $filename2;
}

function configpicker($cpath="config")
{
  global $currentconfignumber;
  //$currentconfignumber = trim(trim($currentconfig, "config/statsconfig"), ".php");
  global $disable_configpicker;

  if ($disable_configpicker) return;

  $c = true;
  $cnt = 0;
  //$configlist[]= "";
  while ($c == true)
  {
    $cnt++;
    $filename = $cpath."/statsconfig".$cnt.".php";
    if (file_exists($filename)) $configlist[] = $cnt;
    else $c = false;
  }
  if ($cnt > 2)
  {
    //find all status file paths
    foreach ($configlist as $value)
    {
      $str = file("config/statsconfig".$value.".php");

      foreach ($str as $phrase)
      {
       if(strstr($phrase, 'b3_status_url'))
         $b3_status_url = explode('"',$phrase);
      }
      $b3_status_url_list[] = $b3_status_url[1];
    }

    //get server names from each status url
    $scnt = 0;
    foreach ($b3_status_url_list as $status)
    {
      $scnt++;
      $servername = "Server " . $scnt;

      if(@simplexml_load_file($status)) //do we have a valid xml file?
      {
        $xml=new simpleXMLElement($status,NULL,TRUE);
        
        foreach($xml->Game->Data as $serverdata)
        {
          if ($serverdata['Name'] == "sv_hostname")
            $servername = removequake3color(htmlentities($serverdata['Value']));
        }
      }

      if (strlen($servername) > 24)
        $serverlist[] = substr($servername,0,24).'...'; //Show max 24 characters in dropdown list.
      else
        $serverlist[] = $servername;
    }

    echo "<form name=\"configselector\" id=\"configselector\" class=\"stylepicker\"><select name=\"config\" onchange=\"XLR_configPicker('parent',this,0)\">";
    foreach ($configlist as $value)
    {
      if ($value == $currentconfignumber)
        echo "<option value=\"$value\" selected=\"selected\">".$serverlist[$value-1]."</option>";
      else
        echo "<option value=\"$value\">".$serverlist[$value-1]."</option>";
    }

  echo "</select></form>";
  }
}

function stylepicker()
{
  global $template;
  
  $dir = 'templates';
  $templatelist = scandir($dir);
  sort($templatelist);
  foreach ($templatelist as $key=>$value) 
  {
    // remove hidden directories
    if (preg_match('/^[.]/', $value)) unset($templatelist[$key]);
  }
 
  $key = array_search('site.png', $templatelist);
  unset($templatelist[$key]);
  $key = array_search('loader.css', $templatelist);
  unset($templatelist[$key]);
  $key = array_search('holidaypack', $templatelist);
  unset($templatelist[$key]);

  echo "<form name=\"stylepicker\" id=\"stylepicker\" class=\"stylepicker\"><select name=\"style\" onchange=\"XLR_stylePicker('parent',this,0)\">";
  foreach ($templatelist as $value)
    if ($value == $template)
      echo "<option selected=\"selected\">$value</option>";
    else
      echo "<option value=\"$value\">$value</option>";

echo "</select></form>";

}

function saveme()
{
  global $template;
  global $myplayerid;
  global $currentconfignumber;

  //setcookie("XLR_template", $template, time()+60*60*24*365*10); // expires in 10 years
  $cookiename = "XLR_playerid[".$currentconfignumber."]";
  setcookie($cookiename, $myplayerid, time()+60*60*24*365*10); // expires in 10 years
}

function savelanguage()
{
  global $lang_file;

  $cookiename = "XLR_origlangfile";
  setcookie($cookiename, $lang_file, time()+60*60*24*365*10); // expires in 10 years
  $cookiename = "XLR_langfile";
  setcookie($cookiename, "en.php", time()+60*60*24*365*10); // expires in 10 years
}

function displaysimpleheader($pop=0)
{
  $link = pathlink($pop);
  global $showclansearch;
  global $statstitle;
  global $logoheight;
  global $template;
  global $stylepicker;

  global $hide_menu_header;
  global $main_width;

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
  
  // Do we have template specific settings?
  $templateconfig = "templates/" . $template . "/config.php";
  if (file_exists($templateconfig))
    include($templateconfig);
  $main_width = $main_width ? $main_width : 800; 

  // Generate required pagecode (header)
  echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">";
  echo "<html>\n";
  echo "<head>\n";
  echo "<title>XLRstats for B3 (www.xlr8or.com)</title>\n";
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
  echo "<link rel=\"shortcut icon\" href=\"".$xlrpath."favicon.ico\">\n";
  echo "<style type=\"text/css\">\n";
  echo "<!--\n";
  echo "@import url(\"$csspath\");\n";
  echo "-->\n";
  echo "</style>\n";
  
  echo  "<script type=\"text/JavaScript\">\n";
  echo  "<!--\n";
  echo  "function XLR_reloadPage(init) {  //reloads the window if Nav4 resized\n";
  echo  "  if (init==true) with (navigator) {if ((appName==\"Netscape\")&&(parseInt(appVersion)==4)) {\n";
  echo  "    document.XLR_pgW=innerWidth; document.XLR_pgH=innerHeight; onresize=XLR_reloadPage; }}\n";
  echo  "  else if (innerWidth!=document.XLR_pgW || innerHeight!=document.XLR_pgH) location.reload();\n";
  echo  "}\n";
  echo  "XLR_reloadPage(true);\n";
  echo  "//-->\n";
  echo  "</script>\n";

  echo "</head>\n";
  echo "<body bgcolor=\"#333333\">\n";
  // Start opening the MAIN table defining general look

  echo "<div id=\"page-body\"><div class=\"page-body-img\">";
  echo "<div id=\"page-footer\"><div class=\"page-footer-img\">";

  echo "<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"main\">\n";
  echo "  <tr>\n";
  echo "    <td>\n";
  // Start Logo
  
  echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
  echo "  <tr valign=\"top\">\n";
  echo "  <td width=\"150\"><a href=\"$link\" title=\"XLRstats HomePage\"><img src=\"".$xlrpath."templates/".$template."/logo1.png\" border=\"0\"></a></td>";
  echo "  <td width=\"100%\" colspan=\"2\" align=\"left\"><img src=\"".$xlrpath."templates/".$template."/logo2.png\" border=\"0\"></td>";

  //echo "    <td align=\"right\" valign=\"bottom\" class=\"header\"><span class=\"title\">$statstitle</span></td>\n";
  echo "  </tr>\n";
	   
  echo "<tr>";
  echo "<td height=\"40\" align=\"left\" style=\"background-image:url(".$xlrpath."templates/".$template."/logob1.png);\" width=\"150\">&nbsp;</td>";

  echo "<td height=\"40\" align=\"left\" style=\"background-image:url(".$xlrpath."templates/".$template."/menubg.png);\" colspan=2>
			<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>
      <font class=\"fontNormal\" size=\"2\">
			<font style=\"font-size: 12px; font-weight: bold;\" color=\"#ffffff\">&nbsp;&nbsp;&nbsp;
    ";
  displayhomelink($pop);
  echo "</font></font></td><td align=\"right\" valign=\"baseline\">";
    echo "&nbsp;";
  echo "</td></tr></table>
  		</td>
  		
  		</td>
  	</tr>
  	<tr>
  		<td colspan=3 style=\"background-image:url(".$xlrpath."templates/".$template."/menubar.png);\"><img src=\"".$xlrpath."templates/".$template."/menubar.png\" height=\"3px\" border=0></td>
  	</tr>
  	<tr>
  	<td colspan=3>
	</td>
	</tr>


  ";

  echo "</table>\n";
}

function displayheader($pop=0)
{
  $link = pathlink($pop);
  global $showclansearch;
  global $statstitle;
  global $logoheight;
  global $template;
  global $stylepicker;
  global $currentconfignumber;
  global $coddb;
  global $t;

  global $hide_menu_header;
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
  global $text;  

  if (isset($_SESSION['template']))
    $template = $_SESSION['template'];

  $xlrpath = pathlink($pop);
  $csspath = $xlrpath . "templates/" . $template . "/style.css";
  $loadercsspath = $xlrpath . "templates/loader.css";
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

  // Do we have template specific settings?
  $templateconfig = "templates/" . $template . "/config.php";
  if (file_exists($templateconfig))
    include($templateconfig);
  $main_width = $main_width ? $main_width : 800; 

  // Tabcontrol variables for playerstats tabs
  $ptab_Color = $ptab_Color ? $ptab_Color : "#000000";
  $ptab_backgroundColor = $ptab_backgroundColor ? $ptab_backgroundColor : "#999999";
  $ptab_selectedBgColor = $ptab_selectedBgColor ? $ptab_selectedBgColor : "#CCCCCC";
  $ptab_mouseOverColor = $ptab_mouseOverColor ? $ptab_mouseOverColor : "#CCCCCC";
  $ptab_borderColor = $ptab_borderColor ? $ptab_borderColor : "black";
  $ptab_borderSize = $ptab_borderSize ? $ptab_borderSize : "1px";
  $ptab_borderStyle = $ptab_borderStyle ? $ptab_borderStyle : "solid";
  $ptab_font = $ptab_font ? $ptab_font : "Geneva, Arial, Helvetica, sans-serif";
  $ptab_textAlign = $ptab_textAlign ? $ptab_textAlign : "center";
  $ptab_fontSize = $ptab_fontSize ? $ptab_fontSize : "14px";
  $ptab_fontWeight = $ptab_fontWeight ? $ptab_fontWeight : "normal";    

  // set up visitor counter
  counter();

  // Generate required pagecode (header)
  echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">";
  echo "<html>\n";
  echo "<head>\n";
  echo "<title>XLRstats for B3 (www.xlr8or.com)</title>\n";
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$text["charset"]."\">\n";
  echo "<link rel=\"shortcut icon\" href=\"".$xlrpath."favicon.ico\">\n";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$xlrpath."lib/autocomplete/jquery.autocomplete.css\" />\n";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$xlrpath."lib/jquery-boxy/boxy.css\" media=\"screen\" />\n";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$xlrpath."lib/tooltip/boxover.css\" media=\"screen\" />\n";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$csspath."\" media=\"screen\" />\n";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$loadercsspath."\" media=\"screen\" />\n";
  // include the php dynamic css
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$template_dyn_css."\" media=\"screen\" />\n";

  // echo "<script type=\"text/JavaScript\" src=\"".$xlrpath."lib/sorttable/sorttable.js\"></script>\n";
  echo "<script type=\"text/JavaScript\" src=\"".$xlrpath."lib/jquery-1.2.6.min.js\"></script>\n";
  echo "<script type=\"text/JavaScript\" src=\"".$xlrpath."lib/jquery-boxy/jquery.boxy.js\"></script>\n";
  echo "<script type=\"text/javascript\" src=\"".$xlrpath."lib/autocomplete/jquery.autocomplete.js\"></script>\n";
  echo "<script type=\"text/JavaScript\" src=\"".$xlrpath."lib/tooltip/boxover.js\"></script>\n";

  echo "<style type=\"text/css\">\n";
  echo "<!--\n";
	/* IE6+7 hacks for the border. IE7 should support this natively but fails in conjuction with modal blackout bg. */
	/* NB: these must be absolute paths or URLs to your images */
	echo ".boxy-wrapper .top-left { #background: none; #filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$xlrpath."lib/jquery-boxy/images/boxy-nw.png'); }\n";
	echo ".boxy-wrapper .top-right { #background: none; #filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$xlrpath."lib/jquery-boxy/images/boxy-ne.png'); }\n";
	echo ".boxy-wrapper .bottom-right { #background: none; #filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$xlrpath."lib/jquery-boxy/images/boxy-se.png'); }\n";
	echo ".boxy-wrapper .bottom-left { #background: none; #filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$xlrpath."lib/jquery-boxy/images/boxy-sw.png'); }\n";
  echo "-->\n";
  echo "</style>\n";

?>
<?php
  // Freelanders Autocomplete script insertion
  echo  "<script type=\"text/JavaScript\">\n";
  echo  "<!--\n";
  include("lib/autocomplete/localdata.php");
?>

$().ready(function() {  
  $("#searchplayer").autocomplete(players, {
    minChars: 3,
    width: 195,
    scrollHeight: 200,
    selectFirst: false,
    matchContains: true,
    autoFill: false,
    formatItem: function(row, i, max) {
      return row.name;
    },
  });
});
<?php

  echo  "//-->\n";
  echo  "</script>\n";
  
  // Courgette's web2 worldmap script insertion
  echo  "<script type=\"text/JavaScript\">\n";
  echo  "<!--\n";
?>
$(document).ready(function(){
  $("<div id=\"web2worldmap\">"
  +"<iframe src=\"lib/worldmap/?config=<?php echo $currentconfignumber; ?>\"  scrolling=\"no\" frameborder=\"0\" width=\"550\" height=\"300\"></iframe></div>").appendTo('body').hide();
  
   $("a[@href='worldmap/']")
    .attr('href','#web2worldmap')
    .removeAttr('onclick')
    .boxy({title: 'World map'});});
<?php

  echo  "//-->\n";
  echo  "</script>\n";

  
  // We need this to be in the header for our stylepicker
  if ($stylepicker != "0")
  {
    echo  "<script type=\"text/JavaScript\">\n";
    echo  "<!--\n";
    echo  "function XLR_stylePicker(targ,selObj,restore){ //v3.0\n";
    echo  "  eval(targ+\".location='\"+\"?style=\"+selObj.options[selObj.selectedIndex].value+\"'\");\n";
    echo  "  if (restore) selObj.selectedIndex=0;\n";
    echo  "}\n";
    echo  "//-->\n";
    echo  "</script>\n";
  }

  // We need this to be in the header for our configpicker
  echo  "<script type=\"text/JavaScript\">\n";
  echo  "<!--\n";
  echo  "function XLR_configPicker(targ,selObj,restore){ //v3.0\n";
  echo  "  eval(targ+\".location='\"+\"?config=\"+selObj.options[selObj.selectedIndex].value+\"'\");\n";
  echo  "  if (restore) selObj.selectedIndex=0;\n";
  echo  "}\n";
  echo  "function XLR_reloadPage(init) {  //reloads the window if Nav4 resized\n";
  echo  "  if (init==true) with (navigator) {if ((appName==\"Netscape\")&&(parseInt(appVersion)==4)) {\n";
  echo  "    document.XLR_pgW=innerWidth; document.XLR_pgH=innerHeight; onresize=XLR_reloadPage; }}\n";
  echo  "  else if (innerWidth!=document.XLR_pgW || innerHeight!=document.XLR_pgH) location.reload();\n";
  echo  "}\n";
  echo  "XLR_reloadPage(true);\n";
  echo  "//-->\n";
  echo  "</script>\n";

  echo "</head>\n";
  echo "<body bgcolor=\"#333333\">\n";

  // Here is the loader div and script
  echo "<div id=\"loading\" class=\"loading-invisible\">\n";
  echo "  <p><img src=\"./images/loader.gif\"></p>\n";
  echo "</div>\n";
?>
<script type="text/javascript">
  document.getElementById("loading").className = "loading-visible";
  var hideDiv = function(){document.getElementById("loading").className = "loading-invisible";};
  var oldLoad = window.onload;
  var newLoad = oldLoad ? function(){hideDiv.call(this);oldLoad.call(this);} : hideDiv;
  window.onload = newLoad;
</script>
<?php

  // Start opening the MAIN table defining general look
  echo "<div id=\"page-body\"><div class=\"page-body-img\">";
  echo "<div id=\"page-footer\"><div class=\"page-footer-img\">";

  echo "<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"main\" width=\"".$main_width."px\">\n";
  echo "  <tr>\n";
  echo "    <td>\n";
  // Start Logo
  
  echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
  echo "  <tr valign=\"top\">\n";
  echo "  <td width=\"150\"><a href=\"$link\" title=\"XLRstats HomePage\"><img src=\"".$xlrpath."templates/".$template."/logo1.png\" border=\"0\"></a></td>";
  echo "  <td width=\"100%\" colspan=\"2\"><img src=\"".$xlrpath."templates/".$template."/logo2.png\" border=\"0\"></td>";

  //echo "    <td align=\"right\" valign=\"bottom\" class=\"header\"><span class=\"title\">$statstitle</span></td>\n";
  echo "  </tr>\n";
	   
  echo "<tr height=\"40\">";
	if ($stylepicker == "left" && $template != "holidaypack")
	{
  	echo "<td valign=\"middle\" align=left style=\"background-image:url(".$xlrpath."templates/".$template."/logob1.png);\" width=\"150\">";
    stylepicker();
    echo "</td>"; 
	}
  elseif ($stylepicker == "right" && $template != "holidaypack")
  {
  	echo "<td valign=\"middle\" align=left style=\"background-image:url(".$xlrpath."templates/".$template."/logob1.png);\" width=\"150\">";
    configpicker();
    echo "</td>"; 
  }
  else
    echo "<td align=left style=\"background-image:url(".$xlrpath."templates/".$template."/logob1.png);\" width=\"150\">&nbsp;</td>";

  echo "<td align=left style=\"background-image:url(".$xlrpath."templates/".$template."/menubg.png);\" colspan=2>
			<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>
      <font class=\"fontNormal\" size=\"2\">
			<font style=\"font-size: 12px; font-weight: bold;\" color=\"#ffffff\">&nbsp;&nbsp;&nbsp;
    ";
  displayhomelink();
  echo "</font></font></td><td align=\"right\" valign=\"baseline\">";
  if ($stylepicker == "right" && $template != "holidaypack")
    stylepicker();
  else
    configpicker();
    //echo "&nbsp;";
  echo "</td></tr></table>
  		</td>
  		
  		</td>
  	</tr>
  	<tr>
  		<td colspan=3 style=\"background-image:url(".$xlrpath."templates/".$template."/menubar.png);\"><img src=\"".$xlrpath."templates/".$template."/menubar.png\" height=\"3px\" border=0></td>
  	</tr>
  	<tr>
  	<td colspan=3>
  		<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
  		<tr>
  			<td width=550 align=\"left\">
    				<form action=\"$link?func=search\" method=\"post\" class=\"aliassearch\">
  	  			<input type=\"text\" id=\"searchplayer\" name=\"input_name\" size=\"30\" />&nbsp; <input type=\"submit\" value=\"".$text["search"]."\"></input>
    				<input type=\"checkbox\" name=\"aliases\" value=\"true\">".$text["incalias"]."</input>
      ";

	if ($showclansearch == "1")
      echo "<input type=\"checkbox\" name=\"clansearch\" value=\"true\">".$text["clantag"]."</input>";
  echo "  				</form>
			</td>
			<td><a href=\"http://www.bigbrotherbot.com\" target=\"_blank\" title=\"www.bigbrotherbot.com\"><div id=\"inea\"><div class=\"opis\">".$text["poweredby"]." </div></div></a>
			</td>
		</tr>
		</table>
	</td>
	</tr>


  ";

  echo "</table>\n";
  flush();
}

function displaysimplefooter($pop=0)
{
  global $stylepicker;
  global $template;

  echo "  	<br/>
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"footer\">
  	<tr class=\"footer\">
  ";
  $now = date('Y');

	echo "<td class=\"tiny\" width=\"85px\"><span class=\"footer\"><a href=\"http://www.xlr8or.com\" class=\"footer\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/xlr8or.png\" border=\"0\" align=\"absbottom\" title=\"".$text["visitxlr"]."\"></a></span></td>\n";
	echo "<td class=\"tiny\" width=\"85px\"><span class=\"footer\"><a href=\"http://www.bigbrotherbot.com\" class=\"footer\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/b3.png\" border=\"0\" align=\"absbottom\" title=\"".$text["b3automated"]."\"></a></span></td>\n";
	echo "<td class=\"tiny\" width=\"20px\"><span class=\"footer\"><a href=\"".pathlink($pop)."reset.php\" class=\"footer\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/error_delete.png\" border=\"0\" align=\"absbottom\" title=\"".$text["gettingerros"]."\"></a></span></td>\n";
	echo "<td align=\"right\" class=\"tiny\"><span class=\"footer\">&copy; 2005-$now XLRstats by </span><a href=\"http://www.xlr8or.com/\" target=\"_blank\" class=\"footer\">www.xlr8or.com</a></td>\n";
	echo "</tr></table>\n";
	// Close the MAIN table
  echo "</td>\n";
  echo "</tr>\n";
  echo "</table>\n";
  echo "</div></div>";
  echo "</div></div>";
  echo "</body>";
  echo "</html>";
}

function displayfooter($pop=0)
{
  global $currentconfignumber;
  global $stylepicker;
  global $template;
  global $pageviews;
  global $total_uniques;
  global $clan_name;
  global $rss_sortby;
  global $text;
  
  $versionfile = abs_pathlink($pop) . "version.txt";
  if ( file_exists($versionfile) )
    $version = "XLRstats " . file_get_contents($versionfile);
  else
    $version = "Unknown Version";

  
  echo "  	<br/>
    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"footer\">
  	<tr class=\"footer\">
  ";
	if ($stylepicker == "footer" && $template != "holidaypack")
    echo "<td class=\"tiny\">".stylepicker()."</td>";
  else
    echo "<td class=\"tiny\">&nbsp;</td>";
  $now = date('Y');

	echo "<td class=\"tiny\" width=\"85px\"><span class=\"footer\"><a href=\"http://www.xlr8or.com\" class=\"footer\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/xlr8or.png\" border=\"0\" align=\"absbottom\" title=\"".$text["visitxlr"]."\"></a></span></td>\n";
	echo "<td class=\"tiny\" width=\"85px\"><span class=\"footer\"><a href=\"http://www.bigbrotherbot.com\" class=\"footer\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/b3.png\" border=\"0\" align=\"absbottom\" title=\"".$text["b3automated"]."\"></a></span></td>\n";
	echo "<td class=\"tiny\" width=\"85px\"><span class=\"footer\"><a href=\"http://www.cback.de\" class=\"footer\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/ctracker.png\" border=\"0\" align=\"absbottom\" title=\"".$text["cracktrack"]."\"></a></span></td>\n";
	echo "<td class=\"tiny\" width=\"20px\"><span class=\"footer\"><a href=\"".pathlink($pop)."reset.php?config=".$currentconfignumber."\" class=\"footer\" target=\"_blank\"><img src=\"".pathlink($pop)."images/ico/error_delete.png\" border=\"0\" align=\"absbottom\" title=\"".$text["gettingerros"]."\"></a></span></td>\n";
	echo "<td align=\"center\" class=\"tiny\"><span class=\"footer\">&nbsp;[".$text["visitors"]." $total_uniques, ".$text["pageview"]." $pageviews]&nbsp;</span></td>\n";
	echo "<td align=\"center\" class=\"tiny\"><span class=\"footer\">&nbsp;[".$text["pageloaded"]." ".pageloader_end()." ".$text["seconds"]."]&nbsp;</span></td>\n";
	echo "<td align=\"right\" class=\"tiny\" title=\"".$version."\"><span class=\"footer\">&nbsp;&copy; 2005-$now&nbsp;</span><a href=\"http://www.xlr8or.com/\" target=\"_blank\" class=\"footer\">www.xlr8or.com</a> </td>\n";
	echo "</tr></table>\n";
	// Close the MAIN table
  echo "</td>\n";
  echo "</tr>\n";
  echo "</table>\n";
  echo "</div></div>";
  echo "</div></div>";
  echo "</body>";
  echo "</html>";
}

// This function displays a back home link.
function displayhomelink($pop=0)
{
  global $func;
  global $mysiteurl;
  global $mysitelinkname;
  global $statstitle;
  global $disable_configpicker;
  global $xlrstats_url;
  global $myplayerid;

  //$link = baselink();
  $link = pathlink($pop);
  include("inc_navigation.php");
}

// This function shows the player-signature in the function player_short()
function showsig($playerid)
{
  global $sig;
  global $text;
  $phpver = phpversion();
  // imagecolorallocatealpha requires 4.3.2
  if (( version_compare($phpver, "4.3.2", ">=") ) && ( function_exists('imagecreate') ) && ($sig == 1) && (file_exists("./sig/")) )
  {
    echo "<form method='post' name=\"form-sig\" action='sig/build.php'>";
    echo "  <p>";
    echo "    <input name='id' type='hidden' id='id' value='$playerid'>";
    echo "  </p>";
    echo "  <p>";
    echo "    <input type='submit' name='submit' value='".$text["generatesig"]."'>";
    echo "</p>";
    echo "</form>";
    
    echo  "<script type=\"text/JavaScript\">\n";
    echo  "<!--\n";
    ?>
    $(document).ready(function(){
      $("form[@name=form-sig]").submit(function(){
        var html = "<div>Error building sig</div>";
                
        $.ajax({
          type: "POST",
          url: $(this).attr('action'),
          data: {
            submit:'true',
            id: $('#id',this).val()
          },
          dataType: "html",
          cache: false,
          success: function(data, status){
            $content = $('<div>').append($("td.innertable",data).contents());
            $("h1:eq(0)", $content).remove();
            $("form", $content).attr('action','sig/build.php'); // correct form action as in that case we are not in the sig folder
            new Boxy($content, {
              title: 'XLRstats - Signature Builder'
            });
          }
        });
        
        return false; // prevent default submit action
      });
    });
    <?php
    echo  "//-->\n";
    echo  "</script>\n";
  }
}

// This function displays the search box
function searchbox()
{
  $link = baselink();

  echo "<table width=\"100%\" height=\"60\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["playersearch"]."</td></tr><tr><td>";
  echo "<table width=\"100%\" height=\"60\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">";
  echo "	<tr><td align=\"center\">";
  echo "		<form action=\"$link?func=search\" method=\"post\">";
  echo "			<input type=\"text\" name=\"input_name\" size=\"20\" />&nbsp;";
  echo "			<input type=\"submit\" value=\"".$text["search"]."\" />";
  echo "			<br /><input type=\"checkbox\" name=\"aliases\" value=\"true\" />".$text["incalias"]."";
  echo "		</form>";
  echo "	</td></tr></table>";
  echo "</td></tr></table>";
}

function counter()
{
  global $pageviews;
  global $total_uniques;

	$visits_file = "dynamic/pageviews.txt";
	$uniques_file = "dynamic/visits.txt";
	
	if (!file_exists($visits_file))
  {
    touch($visits_file);
    $temp = fopen($visits_file, "w");
  	fwrite($temp, 0);
  	fclose($temp);    
  }
	if (!file_exists($uniques_file))
  {
    touch($uniques_file);
    $temp = fopen($uniques_file, "w");
  	fwrite($temp, 0);
  	fclose($temp);    
  }
  $counter = fopen($visits_file, "r");
	$pageviews = fread($counter, filesize($visits_file));
	fclose($counter);
	$pageviews++;
	$counter = fopen($visits_file, "w");
	fwrite($counter, $pageviews);
	fclose($counter);

	$unique_hits = fopen($uniques_file, "r");
	$total_uniques = fread($unique_hits, filesize($uniques_file));
	//if($_COOKIE["plus_unique"] != "set") {
	if(!isset($_COOKIE["plus_unique"])) {
	setcookie("plus_unique", "set", time()+2419200);
	$total_uniques++;
	}
	$uniques_hits = fopen($uniques_file, "w");
	fwrite($uniques_hits, $total_uniques);
	fclose($uniques_hits);
}

function counter_online()
{
  $dataFile = "visitors_online/visitors.txt";
  $sessionTime = 30; //this is the time in **minutes** to consider someone online before removing them from our file
  
  //Please do not edit bellow this line
  
  error_reporting(E_ERROR | E_PARSE);
  
  if(!file_exists($dataFile)) {
  	$fp = fopen($dataFile, "w+");
  	fclose($fp);
  }
  
  $ip = $_SERVER['REMOTE_ADDR'];
  $users = array();
  $onusers = array();
  
  //getting
  $fp = fopen($dataFile, "r");
  flock($fp, LOCK_SH);
  while(!feof($fp)) {
  	$users[] = rtrim(fgets($fp, 32));
  }
  flock($fp, LOCK_UN);
  fclose($fp);
  
  
  //cleaning
  $x = 0;
  $alreadyIn = FALSE;
  foreach($users as $key => $data) {
  	list( , $lastvisit) = explode("|", $data);
  	if(time() - $lastvisit >= $sessionTime * 60) {
  		$users[$x] = "";
  	} else {
  		if(strpos($data, $ip) !== FALSE) {
  			$alreadyIn = TRUE;
  			$users[$x] = "$ip|" . time(); //updating
  		}
  	}
  	$x++;
  }
  
  if($alreadyIn == FALSE) {
  	$users[] = "$ip|" . time();
  }
  
  //writing
  $fp = fopen($dataFile, "w+");
  flock($fp, LOCK_EX);
  $i = 0;
  foreach($users as $single) {
  	if($single != "") {
  		fwrite($fp, $single . "\r\n");
  		$i++;
  	}
  }
  flock($fp, LOCK_UN);
  fclose($fp);
  
  if($uo_keepquiet != TRUE) {
  	echo '<div style="padding:5px; margin:auto; background-color:#fff"><b>' . $i . ' visitors online</b></div>';
  }

}

function pageloader_start()
{
  global $page_start;
  $load_time = microtime();
  $load_time = explode(' ',$load_time);
  $load_time = $load_time[1] + $load_time[0];
  $page_start = $load_time; 
}

function pageloader_end()
{
  global $page_start;
  $load_time = microtime();
  $load_time = explode(' ',$load_time);
  $load_time = $load_time[1] + $load_time[0];
  $page_end = $load_time;
  $final_time = ($page_end - $page_start);
  $page_load_time = number_format($final_time, 4, '.', '');
  return $page_load_time;
  //echo("Page generated in " . $page_load_time . " seconds"); 
}


function menubox($menuselected, $clan_name = "")
{
  global $clan_name;
  global $weaplist_max;
  global $toplist_max;
  global $maplist_max;
  global $hide_menu_header;
  global $text;

  $link = baselink();
  $func = "show";
  if ($clan_name != "") $func = "clan";
  $url_clan_name = escape_hash($clan_name);

  if ($hide_menu_header == 1)
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"outertable\"><tr><td>";
  else
    echo "<table width=\"100%\" height=\"20\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["menu"]."</td></tr><tr><td>";
  echo "<table width=\"100%\" height=\"40\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"innertable\">";
  echo "	<tr>";//<td align=\"center\">

  if($menuselected == 1 || $menuselected < 0 || $menuselected > 5)
    echo "		<td width=\"20%\" align=\"center\" class=\"with_border\">".$text["top"]." ".$toplist_max." ".$text["skill"]."</td>";
  else 
    if (isset($clan_name))
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=1&filter=$url_clan_name\">".$text["top"]." ".$toplist_max." ".$text["skill"]."</a></td>";
    else
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=1\">".$text["top"]." ".$toplist_max." ".$text["skill"]."</a></td>";

  if($menuselected == 2)	
    echo "		<td width=\"20%\" align=\"center\" class=\"with_border\">".$text["top"]." ".$toplist_max." ".$text["kills"]."</td>";
  else
    if (isset($clan_name))
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=2&filter=$url_clan_name\">".$text["top"]." ".$toplist_max." ".$text["kills"]."</a></td>";
    else
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=2\">".$text["top"]." ".$toplist_max." ".$text["kills"]."</a></td>";

  if($menuselected == 3)
    echo "		<td width=\"20%\" align=\"center\" class=\"with_border\">".$text["top"]." ".$toplist_max." ".$text["ratio"]."</td>";
  else 
    if (isset($clan_name))
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=3&filter=$url_clan_name\">".$text["top"]." ".$toplist_max." ".$text["ratio"]."</a></td>";
    else
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=3\">".$text["top"]." ".$toplist_max." ".$text["ratio"]."</a></td>";

  if($menuselected == 4)
    echo "		<td width=\"20%\" align=\"center\" class=\"with_border\">".$text["top"]." ".$weaplist_max." ".$text["weapons"]."</td>";
  else 
    if (isset($clan_name))
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=4&filter=$url_clan_name\">".$text["top"]." ".$weaplist_max." ".$text["weapons"]."</a></td>";
    else
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=4\">".$text["top"]." ".$weaplist_max." ".$text["weapons"]."</a></td>";

  if($menuselected == 5)
    echo "		<td width=\"20%\" align=\"center\" class=\"with_border\">".$text["top"]." ".$maplist_max." ".$text["maps"]."</td>";
  else 
    if (isset($clan_name))
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=5&filter=$url_clan_name\">".$text["top"]." ".$maplist_max." ".$text["maps"]."</a></td>";
    else
      echo "		<td width=\"20%\" align=\"center\" class=\"with_border_alternate\"><a href=\"$link?func=$func&page=5\">".$text["top"]." ".$maplist_max." ".$text["maps"]."</a></td>";

  echo "</tr></table>";
  echo "</td></tr></table>";
}


function player_activity_s($plid, $dbID = false)       
{
  global $currentconfig;
  global $currentconfignumber;
  global $coddb;
  global $t;
  $count = 0;
  $link = baselink();
  $Output = "";

  if($dbID == false)
    $Output = "<img src=\"inc_activitygraph.php?id=".$plid."&config=".$currentconfignumber."\" alt=\"\"><br>";
  else 
      $Output = "<img src=\"inc_activitygraph.php?dbid=".$plid."&config=".$currentconfignumber."\" alt=\"\"><br>";         
  
  return $Output;
}


function formatTD($td)
{
  $days = intval($td / 86400);
  $hours = intval(($td % 86400) / 3600);
  $minutes = intval(($td % 3600) / 60);
  $seconds = intval($td % 60);
  return $days."d:".$hours."h:".$minutes."m:".$seconds."s";
}


// Function that performs the actual search and prints a clickable list of players from the results
function do_search($name, $search_aliases=false)
{
  global $currentconfig;
  global $currentconfignumber;
  global $coddb;
  global $t;
  global $text;
  $count = 0;
  $link = baselink();

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['players']}.fixed_name,
              ${t['players']}.hide 
              FROM ${t['b3_clients']}, ${t['players']}
              WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
              AND ( 
                      (${t['b3_clients']}.name LIKE \"%$name%\")
                  OR
                      (${t['players']}.fixed_name LIKE \"%$name%\")
                  )
              AND ${t['players']}.hide = 0";

  $result = $coddb->sql_query($query);

  opentablerow('100');
  echo "<td>".$text["currentplnames"]."<td></tr><tr>";
  while ($row = $coddb->sql_fetchrow($result))
  {
    opentablecell('100');
    if ( $row['fixed_name'] == "")
    {
        echo "<a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">". htmlspecialchars(utf2iso($row['name'])) ."</a><br/>";
        $count ++;
    }
    else if (stristr( $row['fixed_name'], $name))
    {
        echo "<a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">". htmlspecialchars(utf2iso($row['fixed_name'])) ."</a><br/>";
        $count ++;
    }
    closetablecell();
    echo "</tr><tr>";
  }
  closetablerow();

  if ($search_aliases == "true")
  {
    $query = "SELECT ${t['b3_aliases']}.alias, ${t['b3_clients']}.name, ${t['players']}.id
        FROM ${t['b3_aliases']}, ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_aliases']}.alias LIKE \"%$name%\")
        AND ${t['b3_aliases']}.client_id = ${t['b3_clients']}.id
        AND ${t['b3_clients']}.id = ${t['players']}.client_id
        AND ${t['players']}.hide = 0
        AND ${t['players']}.fixed_name = '' ";


    $result = $coddb->sql_query($query);
    if ($coddb->sql_numrows($result) > 0)
      echo "Alias results:<br/>";

    opentablerow('100');
    echo "<td>Search results (aliase -> current playername)<td></tr><tr>";
    while ($row = $coddb->sql_fetchrow($result))
    {
      opentablecell('100');
      echo "${row['alias']} -> <a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">${row['name']}</a><br/>";
      $count ++;
      closetablecell();
      echo "</tr><tr>";
    }
    closetablerow();
  }

  return $count;
}
?>
