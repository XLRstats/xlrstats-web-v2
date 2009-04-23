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

require ('func-installer.php');
include('../inc_mysql.php');

display_header();

$start_install = $_POST['start_install'];
$step1 = $_POST['step1'];
$step2 = $_POST['step2'];
$step3 = $_POST['step3'];
$step4 = $_POST['step4'];
$step5 = $_POST['step5'];

$db_host = $_POST['hostname'];
$db_user = $_POST['username'];
$db_pass = $_POST['password'];
$db_db = $_POST['databasename'];

$game = $_POST['game'];
$public_ip = $_POST['publicip'];
$b3_status_url = $_POST['statusurl'];
$mysiteurl = $_POST['websiteurl'];
$mysitelinkname = $_POST['websitename'];
$template = $_POST['template'];
$sig = $_POST['sigmodule'];
$statstitle = $_POST['pagetitle'];
$teambased = $_POST['teambased'];
$use_geoip = $_POST['use_geoip'];
$geoip_path = $_POST['geoip_path'];

$toplist_max = $_POST['toplist_max'];
$maplist_max = $_POST['maplist_max'];
$weaplist_max = $_POST['weaplist_max'];
$separatorline = $_POST['separatorline'];
$toplist_block = $_POST['toplist_block'];
$user_length = $_POST['user_length'];
$minkills = $_POST['minkills'];
$minrounds = $_POST['minrounds'];
$exclude_ban = $_POST['exclude_ban'];
$ShowRatioGraph = $_POST['ShowRatioGraph'];
$MaxKillRatio = $_POST['MaxKillRatio'];
$maxdays = $_POST['maxdays'];
$map_minkills = $_POST['map_minkills'];
$map_minrounds = $_POST['map_minrounds'];
$weap_minkills = $_POST['weap_minkills'];
$aliashide_level = $_POST['aliashide_level'];
$limitplayerstats = $_POST['limitplayerstats'];
$enemies_max = $_POST['enemies_max'];
$showclansearch = $_POST['showclansearch'];
$use_localtime = $_POST['use_localtime'];
$useppllist = $_POST['useppllist'];
$pll_noteams = $_POST['pll_noteams'];
$stylepicker = $_POST['stylepicker'];
$disable_configpicker = $_POST['disable_configpicker'];
$debug = $_POST['debug'];

install_steps();

if (isset($start_install))
{
  //Check stage page (Requirements)
  echo "<td width=\"100%\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">";
  echo "<tr>";
  echo "<td><p><span class=\"fontTitle\">Requirements:</span><br />";
  echo "<br />";
  echo "<span class=\"fontNormal\"><strong>1- Big Brother Bot</strong><br />";
  echo "In order to install and run XLRstats Webfront";
  echo " you must have a working version of Big Brother Bot B3 with XLRstats plugin functioning correctly and your website must have access to your B3 database.<br />";
  echo "<br />";
  echo "Also your B3 installation should include: <br />";
  echo "- B3 plugin status.py version 1.2.5 or higher! (included in this package) <br />";
  echo "- Installed B3 plugin ctime.py (included in this package)</span><br />";
  echo "<br />";
  echo "<span class=\"attention\">To install B3 and XLRstats plugin, please visit <a href=\"http://www.bigbrotherbot.com\" target=\"_blank\">www.bigbrotherbot.com</a></span></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td align=\"left\" valign=\"top\"><strong>2- PHP, MySQL Support and Various Settings Check!</strong></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td align=\"left\" valign=\"top\" class=\"attention\">If any of the following items are highlighted in red, fix the problems before you continue. If all is green then click next to continue.</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td align=\"left\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
  echo "<tr>";
  echo "<td class=\"status-spectators\"><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">";
  echo "<tr>";
  echo "<td class=\"highlight\"><strong>ITEM</strong></td>";
  echo "<td class=\"highlight\"><strong>CHECK</strong></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td width=\"50%\" class=\"prechecktable\">PHP Version &gt;= 5.0.0</td>";

  if( phpversion() < '5.0.0' )
    echo "<td width=\"50%\" class=\"precheckERROR\">You need to upgrade your PHP</td>";
  else
    echo "<td width=\"50%\" class=\"precheckOK\">PASS</td>";
    
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"prechecktable\">- XML Support</td>";

  if (function_exists(xml_parser_create))
    echo "<td class=\"precheckOK\">PASS</td>";
  else
    echo "<td class=\"precheckERROR\">You need to enable XML support</td>";

  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"prechecktable\">- MySQL Support</td>";

  if (function_exists(mysql_query))
    echo "<td class=\"precheckOK\">PASS</td>";
  else
    echo "<td class=\"precheckERROR\">You need to enable MySQL support</td>";

  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"prechecktable\">- Register Globals OFF</td>";

  if (ini_get('register_globals') == 0)
    echo "<td class=\"precheckOK\">PASS</td>";
  else
    echo "<td class=\"precheckERROR\">Your php.ini setting Register Globals is set to ON.You can continue installation, but this setting makes XLRstats not function properly. Please ask your hosting provider to set the php_flag register_globals off!</td>";

  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"prechecktable\">./dynamic/</td>";

  if(is_writable('../dynamic/'))
    echo "<td class=\"precheckOK\">Writable</td>";
  else
    echo "<td class=\"precheckERROR\">Not Writable</td>";

  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"prechecktable\">./config/</td>";

  if(is_writable('../config/'))
    echo "<td class=\"precheckOK\">Writable</td>";
  else
    echo "<td class=\"precheckERROR\">Not Writable</td>";

  echo "</tr>";
  echo "</table></td>";
  echo "</tr>";
  echo "</table>";
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
  echo "<tr>";
  echo "<form action=\"index.php\" method=\"POST\">";
  echo "<td>&nbsp;</td>";
  echo "<td width=\"80\" align=\"center\" valign=\"middle\">";
  echo "<label>";
  echo "<input name=\"check\" type=\"button\" class=\"line1\" id=\"check\" onClick=\"window.location.reload()\" value=\"Check Again\" />";
  echo "</label>";
  echo "</a></td>";
  echo "<td width=\"80\" align=\"center\" valign=\"middle\">";
  echo "<label>";
  echo "<input name=\"step1\" type=\"submit\" class=\"line1\" id=\"step1\" value=\"Next\" />";
  echo "</label>";
  echo "</a></td>";
  echo "</tr>";
  echo "</table></td>";
  echo "</tr>";
}

elseif (isset($step1))
{
  //MySQL Connection Settings Page
  echo "<td width=\"100%\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">";
  echo "<tr>";
  echo "<td align=\"left\" valign=\"top\"><p><span class=\"fontTitle\">MySQL Connection Settings:</span><br />";
  echo "<br />";
  echo "Please enter your MySQL server login information.</p></td>";
  echo "</tr><form action=\"index.php\" method=\"POST\">";
  echo "<tr>";
  echo "<td valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
  echo "<tr>";
  echo "<td class=\"status-spectators\"><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">";
  echo "<tr>";
  echo "<td><strong class=\"fontNormal\">Host Name:</strong></td>";
  echo "<td><label>";
  echo "<input type=\"text\" name=\"hostname\" id=\"hostname\" />";
  echo "</label></td>";
  echo "<td width=\"50%\" class=\"fontSmall\">Enter host name here. It's generally 'localhost'.</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td><strong class=\"fontNormal\">MySQL Username:</strong></td>";
  echo "<td><label>";
  echo "<input type=\"text\" name=\"username\" id=\"username\" />";
  echo "</label></td>";
  echo "<td><span class=\"fontSmall\">Enter your MySQL username. It maybe 'b3' or another username given by your service provider.</span></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td><strong class=\"fontNormal\">MySQL Password:</strong></td>";
  echo "<td><label>";
  echo "<input type=\"text\" name=\"password\" id=\"password\" />";
  echo "</label></td>";
  echo "<td><span class=\"fontSmall\">Enter your password here.</span></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td><strong class=\"fontNormal\">MySQL Database Name:</strong></td>";
  echo "<td><label>";
  echo "<input type=\"text\" name=\"databasename\" id=\"databasename\" />";
  echo "</label></td>";
  echo "<td><span class=\"fontSmall\">Enter your database name here. It is probably 'b3'.</span></td>";
  echo "</tr>";
  echo "</table></td>";
  echo "</tr>";
  echo "</table>";
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
  echo "<tr>";
  echo "<td>&nbsp;</td>";
  echo "<td width=\"80\" align=\"center\" valign=\"middle\">";
  echo "<label>";
  echo "<input name=\"back\" type=\"button\" class=\"line1\" id=\"back\" onClick=\"history.go(-1)\" value=\"Back\" />";
  echo "</label>";
  echo "</a></td>";
  echo "<td width=\"80\" align=\"center\" valign=\"middle\"><label>";
  echo "<input name=\"step2\" type=\"submit\" class=\"line1\" id=\"step2\" value=\"Next\" />";
  echo "</label></td>";
  echo "</tr>";
  echo "</table>";
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
  echo "<tr> </tr>";
  echo "</table></td>";
  echo "</tr></form>";
}

elseif (isset($step2))
{
  $coddb = new sql_db($db_host, $db_user, $db_pass, $db_db, false);
  if(!$coddb->db_connect_id || empty($db_host))
    {
    echo "<td width=\100%\" height=\"200px\"class=\"attention\" valign=\"middle\"><center><font size=\"+1\">Cannot Connect to Database! <br />Plese check your login information and try again!</font><br /><br />";
    echo "<input name=\"back\" type=\"button\" class=\"line1\" id=\"back\" onClick=\"history.go(-1)\" value=\"Go Back\" /></center></td></tr>";
    }

  else
  {
    //Basic game & server settings page starts here----------------
    echo "<td width=\"100%\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">";
    echo "<tr>";
    echo "<td align=\"left\" valign=\"top\"><p><span class=\"fontTitle\">Basic Game &amp; Server Settings:</span><br />";
    echo "<br />";
    echo "Following information is your basic server information needed to get XLRstats function properly.</p></td>";
    echo "</tr><form action=\"index.php\" method=\"POST\">";
    echo "<tr>";
    echo "<td valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
    echo "<tr>";
    echo "<td class=\"status-spectators\"><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">";
    echo "<tr>";
    echo "<td width=\"30%\"><strong class=\"fontNormal\">Game Name:</strong></td>";
    echo "<td><label>";
    echo "<select name=\"game\" id=\"game\">";
    echo "<option value=\"urt\">Urban Terror</option>";
    echo "<option value=\"cod1\">Call of Duty</option>";
    echo "<option value=\"coduo\">Call of Duty UO</option>";
    echo "<option value=\"cod2\">Call of Duty 2</option>";
    echo "<option value=\"cod4\">Call of Duty 4: MW</option>";
    echo "<option value=\"codwaw\">Call of Duty: WaW</option>";
    echo "<option value=\"wop\">World of Padman</option>";
    echo "</select>";
    echo "</label></td>";
    echo "<td class=\"fontSmall\">What game? (urt, cod1, coduo, cod2, cod4, codwaw, wop)</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><strong class=\"fontNormal\">Public IP:</strong></td>";
    echo "<td><label>";
    echo "<input type=\"text\" size=\"30\" name=\"publicip\" id=\"publicip\" value=\"0.0.0.0:28960\"/>";
    echo "</label></td>";
    echo "<td><span class=\"fontSmall\">Enter the public IP of the server.</span></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><strong class=\"fontNormal\">B3 Status URL:</strong></td>";
    echo "<td><label>";
    echo "<input type=\"text\" size=\"30\" name=\"statusurl\" id=\"statusurl\" value=\"/var/www/status/status.xml\"/>";
    echo "</label></td>";
    echo "<td class=\"fontSmall\">This is the path where B3 stores the status.xml file. May be an absolute path or an URL. (Use forward slashes / only!) ie.: /var/www/status/status.xml or http://www.yourwebsite.com/status/urt1.xml</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><strong class=\"fontNormal\">URL to Your Website:</strong></td>";
    echo "<td><label>";
    echo "<input type=\"text\" size=\"30\" name=\"websiteurl\" value=\"www.xlr8or.com\" id=\"websiteurl\"/>";
    echo "</label></td>";
    echo "<td class=\"fontSmall\">URL <span class=\"attention\">(without the http:// part!)</span> . Leave blank if you dont want a link to a homepage included.</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><strong class=\"fontNormal\">Link Name to Your Website:</strong></td>";
    echo "<td><label>";
    echo "<input type=\"text\" size=\"30\" name=\"websitename\" id=\"websitename\" value=\"Home\"/>";
    echo "</label></td>";
    echo "<td class=\"fontSmall\">Short name that appears in navigation to describe the link back to your site</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><strong class=\"fontNormal\">Template:</strong></td>";
    echo "<td><label>";
    echo "<select name=\"template\" id=\"template\">";

    list_templates();

    echo "</select>";
    echo "</label></td>";
    echo "<td class=\"fontSmall\">Which template do you want to use?</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td><strong class=\"fontNormal\">Do you want to use Signature Module?:</strong></td>";
    echo "<td><p>";
    echo "<label>";
    echo "<input type=\"radio\" name=\"sigmodule\" value=\"1\" id=\"sigmodule_0\" />";
    echo "Yes</label>";
    echo "<label>";
    echo "<input name=\"sigmodule\" type=\"radio\" id=\"sigmodule_1\" value=\"0\" checked=\"checked\" />";
    echo "No</label>";
    echo "<br />";
    echo "</p></td>";
    echo "<td class=\"fontSmall\">You must have php version 4.3.2 or newer with php4-gd extension installed!</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=\"fontNormal\"><strong>Title of the statistics pages:</strong></td>";
    echo "<td><label>";
    echo "<input type=\"text\" size=\"30\"name=\"pagetitle\" id=\"pagetitle\" value=\"XLRstats, real time gamestats!\"/>";
    echo "</label></td>";
    echo "<td class=\"fontSmall\">Enter title of the statistics pages.</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=\"fontNormal\"><strong>Teambased games?</strong></td>";
    echo "<td><p>";
    echo "<label>";
    echo "<input name=\"teambased\" type=\"radio\" id=\"teambased_0\" value=\"1\" checked=\"checked\" />";
    echo "Yes</label>";
    echo "<label>";
    echo "<input type=\"radio\" name=\"teambased\" value=\"0\" id=\"teambased_1\" />";
    echo "No</label>";
    echo "<br />";
    echo "</p></td>";
    echo "<td class=\"fontSmall\">Does this server run teambased games? (For teamkill and teamdeath awards)</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=\"fontNormal\"><strong>Use GeoIP?</strong></td>";
    echo "<td><p>";
    echo "<label>";
    echo "<input name=\"use_geoip\" type=\"radio\" id=\"use_geoip_0\" value=\"1\" />";
    echo "Yes</label>";
    echo "<label>";
    echo "<input type=\"radio\" name=\"use_geoip\" value=\"0\" id=\"use_geoip_1\" checked=\"checked\" />";
    echo "No</label>";
    echo "<br />";
    echo "</p></td>";
    echo "<td class=\"fontSmall\">Do you want to use GeoIP information in playerpages?</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=\"fontNormal\"><strong>GeoIP Path</strong></td>";
    echo "<td><label>";
    echo "<input type=\"text\" size=\"30\" name=\"geoip_path\" value=\"/path/to/your/geoIP/\" id=\"geoip_path\" />";
    echo "</label></td>";
    echo "<td class=\"fontSmall\">Enter GeoIP path here if you want to use GeoIP.</td>";
    echo "</tr>";
	echo "<input type=\"hidden\" name=\"hostname\" value=\"$db_host\"></input>";
	echo "<input type=\"hidden\" name=\"username\" value=\"$db_user\"></input>";
	echo "<input type=\"hidden\" name=\"password\" value=\"$db_pass\"></input>";
	echo "<input type=\"hidden\" name=\"databasename\" value=\"$db_db\"></input>";
    echo "</table></td>";
    echo "</tr>";
    echo "</table>";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
    echo "<tr>";
    echo "<td>&nbsp;</td>";
    echo "<td width=\"80\" align=\"center\" valign=\"middle\">";
    echo "<label>";
    echo "<input name=\"back\" type=\"button\" class=\"line1\" id=\"back\" onClick=\"history.go(-1)\" value=\"Back\" />";
    echo "</label>";
    echo "</a></td>";
    echo "<td width=\"80\" align=\"center\" valign=\"middle\">";
    echo "<label>";
    echo "<input name=\"step3\" type=\"submit\" class=\"line1\" id=\"step3\" value=\"Next\" />";
    echo "</label>";
    echo "</a></td>";
    echo "</tr>";
    echo "</table>";
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
    echo "<tr> </tr>";
    echo "</table></td>";
    echo "</tr></form>";
  }
}

elseif (isset($step3))
{
  //Check if status.xml exists. If we'll use GeoIP, check if GeoIP path is correct
  if(!file_exists($b3_status_url) || $use_geoip == 1 && !file_exists($geoip_path."GeoIP.dat"))
  {
    echo "<td width=\100%\" height=\"200px\"class=\"attention\" valign=\"middle\"><center><font size=\"+1\">";

    if(!file_exists($b3_status_url))
      echo "- Can't open status.xml!<br />";
    
    if($use_geoip == 1 && !file_exists($geoip_path."GeoIP.dat"))
      echo "- GeoIP path seems to be wrong!<br />";
    
    echo "Please check and try again!</font><br /><br />";
    echo "<input name=\"back\" type=\"button\" class=\"line1\" id=\"back\" onClick=\"history.go(-1)\" value=\"Go Back\" /></center></td></tr>";
  }

  else
  {
  echo "<td width=\"100%\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
                <tr>
                  <td align=\"left\" valign=\"top\"><p><span class=\"fontTitle\">Advanced XLRstats Settings:</span><br />
                    <br />
                  You can modify the following settings to your taste or simply go to the bottom of the page and click &quot;Next&quot; to use default settings. If you want to modify those settings later, you should manually change the statsconfig.php located in &quot;xlrstats/config&quot; folder.</p></td>
                </tr><form action=\"index.php\" method=\"POST\">
                <tr>
                  <td valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                    <tr>
                      <td class=\"status-spectators\"><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">
                        <tr>
                          <td class=\"fontNormal\"><strong>Number of Players to list in Top Lists</strong></td>
                          <td><label>
                            <input name=\"toplist_max\" type=\"text\" id=\"toplist_max\" value=\"25\" />
                            </label></td>
                          <td width=\"50%\" class=\"fontSmall\">Enter the number of players you want to list under &quot;Top Skill&quot;, &quot;Top Kills&quot; and &quot;Top Ratio&quot; sections.</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Number of Maps to list in Top Maps Lists</strong></td>
                          <td><label>
                            <input name=\"maplist_max\" type=\"text\" id=\"maplist_max\" value=\"13\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter the number of maps you want to list under &quot;Top Maps&quot; section.</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Number of Weapons to list in Top Weapons Lists</strong></td>
                          <td><label>
                            <input name=\"weaplist_max\" type=\"text\" id=\"weaplist_max\" value=\"13\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter the number of weapons you want to list under &quot;Top Weapons&quot; section.</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Seperator Line</strong></td>
                          <td><p>
                            <label>
                              <input name=\"separatorline\" type=\"radio\" id=\"seperatorline_0\" value=\"1\" checked=\"checked\" />
                              Yes</label>
                            <input type=\"radio\" name=\"separatorline\" value=\"0\" id=\"seperatorline_1\" />
                            No<br />
                          </p></td>
                          <td class=\"fontSmall\">Do you want to draw a 1 pixel separator line in the toplist between rows?</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Number of Players in block.php</strong></td>
                          <td><label>
                            <input name=\"toplist_block\" type=\"text\" id=\"toplist_block\" value=\"5\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter number of players in block.php an inclusion file for websites.</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Number of characters in username</strong></td>
                          <td><label>
                            <input name=\"user_length\" type=\"text\" id=\"user_length\" value=\"14\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter number of characters in username (block) before breaking off.</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Minimum Kills</strong></td>
                          <td><label>
                            <input name=\"minkills\" type=\"text\" id=\"minkills\" value=\"1000\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter minimum amount of kills before a player is included in the mainpage player statistics and awards</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Minimum Rounds</strong></td>
                          <td><label>
                            <input name=\"minrounds\" type=\"text\" id=\"minrounds\" value=\"50\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter minimum amount of rounds before a player is included in the mainpage player statistics and awards</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Exclude Banned Player?</strong></td>
                          <td><p>
                            <label>
                              <input name=\"exclude_ban\" type=\"radio\" id=\"exclude_ban_0\" value=\"1\" checked=\"checked\" />
                              Yes</label>
                            <label>
                              <input type=\"radio\" name=\"exclude_ban\" value=\"0\" id=\"exclude_ban_1\" />
                              No</label>
                            <br />
                          </p></td>
                          <td class=\"fontSmall\">Do you want to exclude currently banned player from top lists and ranking?</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Ratio Graph</strong></td>
                          <td><label>
                            <select name=\"ShowRatioGraph\" id=\"ShowRatioGraph\">
                              <option value=\"0\">Values Only</option>
                              <option value=\"1\" selected=\"selected\">Inline Bar</option>
                              <option value=\"2\">Double Bar</option>
                              <option value=\"3\">Simple Inline Bar</option>
                            </select>
                          </label></td>
                          <td class=\"fontSmall\">Select how you want to display the ratio bar.</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Maximum Kill Ratio</strong></td>
                          <td><label>
                            <input name=\"MaxKillRatio\" type=\"text\" id=\"MaxKillRatio\" value=\"0\" />
                          </label></td>
                          <td class=\"fontSmall\">For the ratio bar - leave at 0 for automatic detection of the maximum ratio</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Maximum Days</strong></td>
                          <td><label>
                            <input name=\"maxdays\" type=\"text\" id=\"maxdays\" value=\"14\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter number of days a player is still displayed if he/she hasn't played anymore.</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Minimum Map Kills</strong></td>
                          <td><label>
                            <input name=\"map_minkills\" type=\"text\" id=\"map_minkills\" value=\"100\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter minimum kills before a player is displayed on map-page</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Minimum Map Rounds</strong></td>
                          <td><label>
                            <input name=\"map_minrounds\" type=\"text\" id=\"map_minrounds\" value=\"20\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter minimum rounds before a player is displayed on map-page</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Minimum Weapon Kills</strong></td>
                          <td><label>
                            <input name=\"weap_minkills\" type=\"text\" id=\"weap_minkills\" value=\"25\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter minimum kills before a player is displayed on weapon-page</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Alias Hide Level</strong></td>
                          <td><label>
                            <input name=\"aliashide_level\" type=\"text\" id=\"aliashide_level\" value=\"2\" />
                          </label></td>
                          <td class=\"fontSmall\">Minimum grouplevel to hide aliases on playerpages, this will show aliases for players with a lower level. Disable aliases by setting it to 0</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Limit Player Stats</strong></td>
                          <td><p>
                            <label>
                              <input name=\"limitplayerstats\" type=\"radio\" id=\"limitplayerstats_0\" value=\"1\" checked=\"checked\" />
                              Yes</label>
                            <label>
                              <input type=\"radio\" name=\"limitplayerstats\" value=\"0\" id=\"limitplayerstats_1\" />
                              No</label>
                            <br />
                          </p></td>
                          <td class=\"fontSmall\">Do you want to limit playerspecific stats for unregistered players</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Enemies Maximum</strong></td>
                          <td><label>
                            <input name=\"enemies_max\" type=\"text\" id=\"enemies_max\" value=\"13\" />
                          </label></td>
                          <td class=\"fontSmall\">Enter number of worst enemies in personal playerpages</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Clan Search</strong></td>
                          <td><p>
                            <label>
                              <input name=\"showclansearch\" type=\"radio\" id=\"showclansearch_0\" value=\"1\" checked=\"checked\" />
                              Yes</label>
                            <label>
                              <input type=\"radio\" name=\"showclansearch\" value=\"0\" id=\"showclansearch_1\" />
                              No</label>
                            <br />
                          </p></td>
                          <td class=\"fontSmall\">Do you want a Clan search filter on the index page?</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Use Localtime</strong></td>
                          <td><p>
                            <label>
                              <input name=\"use_localtime\" type=\"radio\" id=\"use_localtime_0\" value=\"1\" checked=\"checked\" />
                              Yes</label>
                            <label>
                              <input type=\"radio\" name=\"use_localtime\" value=\"0\" id=\"use_localtime_1\" />
                              No</label>
                            <br />
                          </p></td>
                          <td class=\"fontSmall\">Do you want to display times for your local timezone?</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Show Current Player List?</strong></td>
                          <td><p>
                            <label>
                              <input name=\"useppllist\" type=\"radio\" id=\"useppllist_0\" value=\"1\" checked=\"checked\" />
                              Yes</label>
                            <label>
                              <input type=\"radio\" name=\"useppllist\" value=\"0\" id=\"useppllist_1\" />
                              No</label>
                            <br />
                          </p></td>
                          <td class=\"fontSmall\">Do you want to display current player list?</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Show Teams?</strong></td>
                          <td><p>
                            <label>
                              <input name=\"pll_noteams\" type=\"radio\" id=\"pll_noteams_0\" value=\"0\" checked=\"checked\" />
                              Yes</label>
                            <label>
                              <input name=\"pll_noteams\" type=\"radio\" id=\"pll_noteams_1\" value=\"1\" />
                              No</label>
                            <br />
                          </p></td>
                          <td class=\"fontSmall\">Do you want to display teams in current player list?</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Show Stylepicker?</strong></td>
                          <td><label>
                            <select name=\"stylepicker\" id=\"stylepicker\">
                              <option value=\"0\" selected=\"selected\">No</option>
                              <option value=\"left\">Left</option>
                              <option value=\"right\">Right</option>
                              <option value=\"footer\">Footer</option>
                            </select>
                          </label></td>
                          <td class=\"fontSmall\">Do you want to display stylepicker?</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Disable Config Selector?</strong></td>
                          <td><p>
                            <label>
                              <input type=\"radio\" name=\"disable_configpicker\" value=\"1\" id=\"disable_configpicker_0\" />
                              Yes</label>
                            <label>
                              <input name=\"disable_configpicker\" type=\"radio\" id=\"disable_configpicker_1\" value=\"0\" checked=\"checked\" />
                              No</label>
                            <br />
                          </p></td>
                          <td class=\"fontSmall\">Disable the config selector, even though we have set up multi configs (ie if we want to deeplink to each config/server from our homepage)</td>
                        </tr>
                        <tr>
                          <td class=\"fontNormal\"><strong>Show Debuggin Info?</strong></td>
                          <td><p>
                            <label>
                              <input name=\"debug\" type=\"radio\" id=\"debug_0\" value=\"1\" checked=\"checked\" />
                              Yes</label>
                            <input type=\"radio\" name=\"debug\" value=\"0\" id=\"debug_1\" />No</p></td>
                          <td class=\"fontSmall\">Selecting &quot;Yes&quot; will enable all php-error reporting and phpinfo to show for debugging purposes. If you find that your XLRstats is okay, set it to 0. If you need support make sure you set this to 1 before posting requests in the support forums.</td>
                        </tr>
						<input type=\"hidden\" name=\"hostname\" value=\"$db_host\"></input>
						<input type=\"hidden\" name=\"username\" value=\"$db_user\"></input>
						<input type=\"hidden\" name=\"password\" value=\"$db_pass\"></input>
						<input type=\"hidden\" name=\"databasename\" value=\"$db_db\"></input>
						<input type=\"hidden\" name=\"game\" value=\"$game\"></input>
						<input type=\"hidden\" name=\"publicip\" value=\"$public_ip\"></input>
						<input type=\"hidden\" name=\"statusurl\" value=\"$b3_status_url\"></input>
						<input type=\"hidden\" name=\"websiteurl\" value=\"$mysiteurl\"></input>
						<input type=\"hidden\" name=\"websitename\" value=\"$mysitelinkname\"></input>
						<input type=\"hidden\" name=\"template\" value=\"$template\"></input>
						<input type=\"hidden\" name=\"sigmodule\" value=\"$sig\"></input>
						<input type=\"hidden\" name=\"pagetitle\" value=\"$statstitle\"></input>
						<input type=\"hidden\" name=\"teambased\" value=\"$teambased\"></input>
						<input type=\"hidden\" name=\"use_geoip\" value=\"$use_geoip\"></input>
						<input type=\"hidden\" name=\"geoip_path\" value=\"$geoip_path\"></input>
                      </table></td>
                    </tr>
                  </table>
                    <table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">
                      <tr>
                        <td>&nbsp;</td>
                        <td width=\"80\" align=\"center\" valign=\"middle\">
                          <label>
                            <input name=\"back\" type=\"button\" class=\"line1\" id=\"back\" onClick=\"history.go(-1)\" value=\"Back\" />
                          </label>
                        </a></td>
                        <td width=\"80\" align=\"center\" valign=\"middle\">
                          <label>
                            <input name=\"step4\" type=\"submit\" class=\"line1\" id=\"step4\" value=\"Save Config\" />
                          </label>
                        </a></td>
                      </tr>
                    </table>
                    <table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">
                      <tr> </tr>
                    </table></td>
                  </tr></form>
  ";
  }
}

elseif (isset($step4))
{
  create_statsconfig();

  echo "<p class=\"fontNormal\">If you have another game server and want to configure it now, please click &quot;New Server&quot; button
                    or click \"Finish\" to generate awards file and finish installation</p></td>
                </tr><form action=\"index.php\" method=\"POST\">
                <tr>
                  <td valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">
                    <tr>
                        <td>&nbsp;</td>
                        <td width=\"80\" align=\"center\" valign=\"middle\">
                          <label>
                            <input name=\"newserver\" type=\"button\" class=\"line1\" id=\"newserver\" onClick=\"history.go(-2)\" value=\"New Server\" />
                          </label>
                        </a></td>
                        <td width=\"80\" align=\"center\" valign=\"middle\">
                          <label>
                            <input name=\"step5\" type=\"submit\" class=\"line1\" id=\"step5\" value=\"Finish\" />
                          </label>
                        </a></td>
                      </tr>
                    </table>
                    <table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">
                      <tr> </tr>
                    </table></td>
                  </tr></form>
";
}

elseif (isset($step5))
{
  require ('../config/install_award_idents.php');
}

else
{
  //Licence and Readme Page
  echo "<td width=\"100%\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">";
  echo "<tr>";
  echo "<td align=\"center\" valign=\"top\"><strong class=\"fontTitle\">Thank you for choosing XLRstats<br />";
  echo "the only REAL TIME stats keeping program!</strong></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td align=\"center\" valign=\"top\"><span class=\"fontNormal\">You can install XLRstats in 4 easy steps!</span></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td align=\"center\" valign=\"top\" class=\"fontNormal\"><strong>Licence and Read Me:</strong></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td align=\"center\" valign=\"top\"><p class=\"fontNormal\">";
  echo "<label>";
  echo "<textarea name=\"licence\" cols=\"75\" rows=\"20\" readonly=\"readonly\" class=\"fontNormal\" id=\"licence\">";

  display_readme();

  echo "</textarea>";
  echo "</label>";
  echo "</p></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">";
  echo "<tr>";
  echo "<form action=\"index.php\" method=\"POST\">";
  echo "<td>&nbsp;</td>";
  echo "<td width=\"80\" align=\"center\" valign=\"middle\">";
  echo "<label>";
  echo "<input name=\"start_install\" type=\"submit\" class=\"line1\" id=\"start_install\" value=\"Start Install\" />";
  echo "</label>";
  echo "</a></td>";
  echo "</tr>";
  echo "</form>";
  echo "</table>";
}

display_footer();

?>
