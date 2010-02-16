<?php
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

$db_host = "";
$db_user = "";
$db_pass = "";
$db_db = "";

// What game? (urt, cod1, coduo, cod2, cod4, codwaw, wop)
$game = "none";
$public_ip = "0.0.0.0:27960";
// This is the path where B3 stores the status.xml file. May be an absolute path or an URL. (Use forward slashes / only!)
// ie.: /var/www/status/status.xml or http://www.yourwebsite.com/status/urt1.xml
$b3_status_url = "http://";

// URL to my website, make empty if XLRstats is standalone.
$mysiteurl = "www.xlr8or.com";        // URL (without the http:// part!) -> "" if you dont want a link to a homepage included
$mysitelinkname = "Home";      // Short name that appears in navigation to describe the link back to your site
$template = "xlrstats";

// Use signature module? --> You must have php version 4.3.2 or newer with php4-gd extension installed!
$sig = 0;

// Title of the statistics pages (max. 36 characters)
$statstitle = "XLRstats, real time gamestats!";

// Does this server run teambased games? (For teamkill and teamdeath awards)
$teambased = 1;

//Does this server run action based games like Search and Destroy, Capture the Flag etc? (For Action Stats)
$actionbased = 0;

// Number of players/maps/weapons in mainpage top lists
$toplist_max = 25;
$maplist_max = 13;
$weaplist_max = 13;
$separatorline = 1; //Draw a 1 pixel separator line in the toplist between rows? 0 = nope, 1 = yep.

// Number of players in block.php an inclusion file for websites.
$toplist_block = 5;
// Number of characters in username (block) before breaking off.
$user_length = 14;

// minimum amount of kills or rounds (which ever comes first) before a player is included in the mainpage player statistics and awards...
$minkills = 1000; //10 //250;
$minrounds = 50; //14 //15;

// exclude currently banned player from top lists and ranking
$exclude_ban = 1;

// Options: 0 = values only; 1 = Freelanders inline bar; 2 = Freelanders double bars; 3 = simple inline bar with values below
$ShowRatioGraph = 1;
// For the ratio bar - leave at 0 for automatic detection of the maximum ratio
$MaxKillRatio = 0;
//number of days a player is still displayed if he hasn't played anymore.
$maxdays = 14;

// Minimum kills or rounds (which ever comes first) before a player is displayed on map-page
$map_minkills = 100;
$map_minrounds = 20;

// Minimum kills before a player is displayed on weapon-page
$weap_minkills = 25;

// Minimum grouplevel to hide aliases on playerpages, this will show aliases for players with a lower level. Disable aliases by setting it to 0
$aliashide_level = 2;

// Limit playerspecific stats for unregistered players
$limitplayerstats = 1;

// Number of worst enemies in personal playerpages
$enemies_max = 13;

// Do you want a Clan search filter on the index page? (0 = nope, 1 = yep)
$showclansearch = 1;

// Do you want to display times for your local timezone? (0 = no, just use GMT; 1 = yes)
$use_localtime = 1;

// Do you want to have current player list (0 no, 1 yes) //Anubis
$useppllist = 1;
$pll_noteams = 0;

// Show the stylepicker (0 disables, options are: "left", "right", "footer")
$stylepicker = "0";
// Disable the config selector, even though we have set up multi configs (ie if we want to deeplink to each config/server from our homepage)
$disable_configpicker = 0;

// Use GeoIP information in playerpages?
$use_geoip = 1;
$geoip_path = "/path/to/your/geoIP/";

// setting to 1 will enable all php-error reporting and phpinfo to show for debugging purposes.
// If you find that your XLRstats is okay, set it to 0. If you need support make sure you set this to 1 before posting requests in the support forums.
$debug = 1;

//********************
// Table names
//********************

// B3 tables
$t['b3_clients'] = "clients";
$t['b3_groups'] = "groups";
$t['b3_aliases'] = "aliases";
$t['b3_penalties'] = "penalties";
$t['b3_ctime'] = "ctime";

//stats tables
$t['players'] = "xlr_playerstats";
$t['weapons'] = "xlr_weaponstats";
$t['maps'] = "xlr_mapstats";
$t['bodyparts'] = "xlr_bodyparts";
$t['opponents'] = "xlr_opponents";
$t['weaponusage'] = "xlr_weaponusage";
$t['playerbody'] = "xlr_playerbody";
$t['playermaps'] = "xlr_playermaps";
$t['actions'] = "xlr_actionstats";
$t['playeractions'] = "xlr_playeractions";

//history tables - needs the xlrstatshistory plugin installed!
$t['history_monthly'] = "xlr_history_monthly";
$t['history_weekly'] = "xlr_history_weekly";

//********************
// Advanced Settings
//********************

// How long (in seconds) to cache awards, lower = slower. 
$award_cache_time = 3600; // 3600=1hr, 7200=2hrs, 10800=3hrs, 14400=4hrs etc.



?>
