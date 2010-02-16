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

function display_header()
{
  echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
  echo "<head>";
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
  echo "<title>XLRstats Installer</title>";
  echo "<link href=\"../templates/xlrstats/installer.css\" rel=\"stylesheet\" type=\"text/css\" />";
  echo "</head>";
  echo "<body>";
  echo "<table width=\"800\" border=\"0\" align=\"center\" cellpadding=\"5\" cellspacing=\"1\">";
  echo "<tr>";
  echo "<td align=\"center\" valign=\"top\" class=\"outertable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">";
  echo "<tr>";
  echo "<td align=\"center\" valign=\"middle\" class=\"top\"><font size=\"+2\">XLRstats Installer</font></td>";
  echo "</tr>";
  echo "</table>";
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">";
  echo "<tr>";
  echo "<td align=\"right\" class=\"version\">".xlrstats_version()."</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td align=\"center\" class=\"header\">Welcome to the XLRstats Webfront installation. Good choice to pick the only Real Time Stats solution for games!</td>";
  echo "</tr>";
  echo "</table>";
  echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"outertable\">";
  echo "<tr><td><img src=\"../images/spacer.gif\" width=\"1\" height=\"5\"></td></tr>";
  echo "<tr>";
  echo "<td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
  echo "<tr class=\"innertable\">";
}

//Find XLRstats version
function xlrstats_version()
{
  if(!(@$fp = fopen("../version.txt", "r"))) {
    $version="Cannot detect version!";
    } else { 
      $version = fgets($fp);
      }
  return $version;
  fclose($fp);
}

//show installations steps
function install_steps()
{
  global $start_install;
  global $step1;
  global $step2;
  global $step3;
  global $step4;
  global $step5;

  echo "<td class=\"outertable\" width=\"150px\" valign=\"top\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
  echo "<tr>";
  echo "<td valign=\"top\"><table width=\"150px\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">";
  echo "<tr>";
  
  if (!($start_install || $step1 || $step2 || $step3 || $step4 || $step5))
    echo "<td align=\"center\" class=\"menuhighlighted\">Licence &amp; Read Me</td>";
  else
    echo "<td align=\"center\" class=\"innertable\">Licence &amp; Read Me</td>";
  
  echo "</tr>";
  echo "<tr>";
  
  if ($start_install)
    echo "<td align=\"center\" class=\"menuhighlighted\">Requirements</td>";
  else
    echo "<td align=\"center\" class=\"innertable\">Requirements</td>";

  echo "</tr>";
  echo "<tr>";
  
  if ($step1)
    echo "<td align=\"center\" class=\"menuhighlighted\">Step 1</td>";
  else
    echo "<td align=\"center\" class=\"innertable\">Step 1</td>";

  echo "</tr>";
  echo "<tr>";
  
  if($step2)
    echo "<td align=\"center\" class=\"menuhighlighted\">Step 2</td>";
  else
    echo "<td align=\"center\" class=\"innertable\">Step 2</td>";

  echo "</tr>";
  echo "<tr>";
  
  if($step3)
    echo "<td align=\"center\" class=\"menuhighlighted\">Step 3</td>";
  else
    echo "<td align=\"center\" class=\"innertable\">Step 3</td>";

  echo "</tr>";
  echo "<tr>";
  
  if($step4)
    echo "<td align=\"center\" class=\"menuhighlighted\">Step 4</td>";
  else
    echo "<td align=\"center\" class=\"innertable\">Step 4</td>";

  echo "</tr>";
  echo "<tr>";

  if($step5)
    echo "<td align=\"center\" class=\"menuhighlighted\">Identify Awards</td>";
  else
    echo "<td align=\"center\" class=\"innertable\">Identify Awards</td>";

  echo "</tr>";
  echo "</table></td>";
  echo "</tr>";
  echo "</table></td>";
  echo "<td class=\"outertable\"><img src=\"../images/spacer.gif\" width=\"5\" height=\"5\"></td>";
}

//Open and display readme file
function display_readme()
{
  if(!(@$fp = fopen("../README.TXT", "r"))) {
  $readme = "Cannot find README.TXT!";
  } else { 
    $readme = fpassthru($fp);
    }
  return $readme;
  fclose($fp);
}

//function to create statsconfig.php files
function create_statsconfig()
{
  global $db_host;
  global $db_user;
  global $db_pass;
  global $db_db;

  global $game;
  global $public_ip;
  global $b3_status_url;
  global $mysiteurl;
  global $mysitelinkname;
  global $template;
  global $sig;
  global $statstitle;
  global $teambased;
  global $actionbased;
  global $use_geoip;
  global $geoip_path;

  global $toplist_max;
  global $maplist_max;
  global $weaplist_max;
  global $separatorline;
  global $toplist_block;
  global $user_length;
  global $minkills;
  global $minrounds;
  global $exclude_ban;
  global $ShowRatioGraph;
  global $MaxKillRatio;
  global $maxdays;
  global $map_minkills;
  global $map_minrounds;
  global $weap_minkills;
  global $aliashide_level;
  global $limitplayerstats;
  global $enemies_max;
  global $showclansearch;
  global $use_localtime;
  global $useppllist;
  global $pll_noteams;
  global $stylepicker;
  global $disable_configpicker;
  global $debug;

  $config_dir = "../config";
  if(@!($dp = opendir($config_dir))) 
    die("Cannot open $config_dir.");
    
  while($file = readdir($dp)) //list files that contains "statsconfig"
  if(ereg("statsconfig", $file))
    $config_files[] = $file;
  closedir($dp);
  
  @natsort($config_files);
  $last_config_file = @array_pop($config_files);

  if (!isset($last_config_file)) //If we have no statsconfig.php, we create one
  {
    if(@!$fp = fopen($config_dir."/statsconfig.php", "w"))
      die("Cannot create file statsconfig.php! Make sure \"config\" directory is writable!");
   }

  else
  { 
  	if(file_exists($config_dir."/statsconfig.php"))  //If we have statsconfig.php, we rename it to statsconfig1.php
  	{
      if(@!rename ($config_dir."/statsconfig.php", $config_dir."/statsconfig1.php"))
        die("Cannot rename file statsconfig.php to statsconfig1.php!");
    }
    
    if($last_config_file == "statsconfig.php")
      $confignumber = 1;
    else
      $confignumber = trim($last_config_file, "statsconfig.php"); //take out the number of statsconfig file
    
    $confignumber++;
  
    if(@!$fp = fopen($config_dir."/statsconfig$confignumber.php", "w"))
      die("Cannot create file statsconfig.php! Make sure \"config\" directory is writable!");
  }
  
fwrite($fp, 
"<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webrfront for XLRstats for B3 (www.bigbrotherbot.com)
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

//*******************
// Global config
//*******************

// Database login info

\$db_host = \"$db_host\";
\$db_user = \"$db_user\";
\$db_pass = \"$db_pass\";
\$db_db = \"$db_db\";

// What game? (urt, cod1, coduo, cod2, cod4, codwaw, wop)
\$game = \"$game\";
\$public_ip = \"$public_ip\";
// This is the path where B3 stores the status.xml file. May be an absolute path or an URL. (Use forward slashes / only!)
// ie.: /var/www/status/status.xml or http://www.yourwebsite.com/status/urt1.xml
\$b3_status_url = \"$b3_status_url\";

// URL to my website, make empty if XLRstats is standalone.
\$mysiteurl = \"$mysiteurl\";        // URL (without the http:// part!) -> \"\" if you dont want a link to a homepage included
\$mysitelinkname = \"$mysitelinkname\";      // Short name that appears in navigation to describe the link back to your site
\$template = \"$template\";

// Use signature module? --> You must have php version 4.3.2 or newer with php4-gd extension installed!
\$sig = $sig;

// Title of the statistics pages
\$statstitle = \"$statstitle\";

// Does this server run teambased games? (For teamkill and teamdeath awards)
\$teambased = $teambased;

//Does this server run action based games like Search and Destroy, Capture the Flag etc? (For Action Stats)
\$actionbased = $actionbased;

// Number of players/maps/weapons in mainpage top lists
\$toplist_max = $toplist_max;
\$maplist_max = $maplist_max;
\$weaplist_max = $weaplist_max;
\$separatorline = $separatorline; //Draw a 1 pixel separator line in the toplist between rows? 0 = nope, 1 = yep.

// Number of players in block.php an inclusion file for websites.
\$toplist_block = $toplist_block;
// Number of characters in username (block) before breaking off.
\$user_length = $user_length;

// minimum amount of kills or rounds (which ever comes first) before a player is included in the mainpage player statistics and awards...
\$minkills = $minkills; //10 //250;
\$minrounds = $minrounds; //14 //15;

// exclude currently banned player from top lists and ranking
\$exclude_ban = $exclude_ban;

// Options: 0 = values only; 1 = Freelanders inline bar; 2 = Freelanders double bars; 3 = simple inline bar with values below
\$ShowRatioGraph = $ShowRatioGraph;
// For the ratio bar - leave at 0 for automatic detection of the maximum ratio
\$MaxKillRatio = $MaxKillRatio;
//number of days a player is still displayed if he hasn't played anymore.
\$maxdays = $maxdays;

// Minimum kills or rounds (which ever comes first) before a player is displayed on map-page
\$map_minkills = $map_minkills;
\$map_minrounds = $map_minrounds;

// Minimum kills before a player is displayed on weapon-page
\$weap_minkills = $weap_minkills;

// Minimum grouplevel to hide aliases on playerpages, this will show aliases for players with a lower level. Disable aliases by setting it to 0
\$aliashide_level = $aliashide_level;

// Limit playerspecific stats for unregistered players
\$limitplayerstats = $limitplayerstats;

// Number of worst enemies in personal playerpages
\$enemies_max = $enemies_max;

// Do you want a Clan search filter on the index page? (0 = nope, 1 = yep)
\$showclansearch = $showclansearch;

// Do you want to display times for your local timezone? (0 = no, just use GMT; 1 = yes)
\$use_localtime = $use_localtime;

// Do you want to have current player list (0 no, 1 yes) //Anubis
\$useppllist = $useppllist;
\$pll_noteams = $pll_noteams;

// Show the stylepicker (0 disables, options are: \"left\", \"right\", \"footer\")
\$stylepicker = \"$stylepicker\";
// Disable the config selector, even though we have set up multi configs (ie if we want to deeplink to each config/server from our homepage)
\$disable_configpicker = $disable_configpicker;

// Use GeoIP information in playerpages?
\$use_geoip = $use_geoip;
\$geoip_path = \"$geoip_path\";

// setting to 1 will enable all php-error reporting and phpinfo to show for debugging purposes.
// If you find that your XLRstats is okay, set it to 0. If you need support make sure you set this to 1 before posting requests in the support forums.
\$debug = $debug;

//********************
// Table names
//********************

// B3 tables
\$t['b3_clients'] = \"clients\";
\$t['b3_groups'] = \"groups\";
\$t['b3_aliases'] = \"aliases\";
\$t['b3_penalties'] = \"penalties\";
\$t['b3_ctime'] = \"ctime\";

//stats tables
\$t['players'] = \"xlr_playerstats\";
\$t['weapons'] = \"xlr_weaponstats\";
\$t['maps'] = \"xlr_mapstats\";
\$t['bodyparts'] = \"xlr_bodyparts\";
\$t['opponents'] = \"xlr_opponents\";
\$t['weaponusage'] = \"xlr_weaponusage\";
\$t['playerbody'] = \"xlr_playerbody\";
\$t['playermaps'] = \"xlr_playermaps\";
\$t['actions'] = \"xlr_actionstats\";
\$t['playeractions'] = \"xlr_playeractions\";

//history tables - needs the xlrstatshistory plugin installed!
\$t['history_monthly'] = \"xlr_history_monthly\";
\$t['history_weekly'] = \"xlr_history_weekly\";


?>
");

fclose($fp);

  echo "<td width=\"100%\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
                <tr>
                  <td align=\"left\" valign=\"top\"><p><span class=\"precheckOK\"><strong><font size=\"2\">\"statsconfig$confignumber.php\" Created Succesfully!</font></strong></span>
                      <br />
  ";

}

function list_templates()
{
  $dir = '../templates';
  $templatelist = scandir($dir);
  sort($templatelist);
  foreach ($templatelist as $key=>$value) 
  {
    if (preg_match('/^[.]/', $value)) unset($templatelist[$key]);
  }
 
  $key = array_search('site.png', $templatelist);
  unset($templatelist[$key]);
  $key = array_search('loader.css', $templatelist);
  unset($templatelist[$key]);
  $key = array_search('holidaypack', $templatelist);
  unset($templatelist[$key]);

  foreach ($templatelist as $value)
    echo "<option value=\"$value\">$value</option>";
}

function display_footer()
{
echo "</tr>";
echo "</table></td>";
echo "</tr>";
echo "</table></td>";
echo "</tr>";
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br />";
echo "</body>";
echo "</html>";
}

?>
