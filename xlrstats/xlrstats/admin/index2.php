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

include("../inc_mysql.php");
include ('../func-globallogic.php');
include ('inc_functions.php');
include('versionchecker.php');

session_start();
cleanglobals();

// If statsconfig.php exists, we won't enable multiconfig functionality
if (file_exists("../config/statsconfig.php"))
{
  $currentconfig = "../config/statsconfig.php";
  $currentconfignumber = false;
}
elseif (file_exists("../config/statsconfig1.php"))
{
  $currentconfig = "../config/statsconfig1.php";
  $currentconfignumber = 1;

  if (isset($_POST['config'])) 
  {
    $currentconfignumber = escape_string($_POST['config']);
    $currentconfig = "../config/statsconfig".$currentconfignumber.".php";
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  // Was a config set in the url?
  elseif (isset($_GET['config'])) 
  {
    $currentconfignumber = escape_string($_GET['config']);
    $currentconfig = "../config/statsconfig".$currentconfignumber.".php";
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  elseif (isset($_SESSION['currentconfignumber']))
  {
    $currentconfignumber = $_SESSION['currentconfignumber'];
    $currentconfig = "../config/statsconfig".$currentconfignumber.".php";
  }
  // double check config number found point to an existing config file or fallback to config 1
  if (!file_exists($currentconfig)) 
  {
    $currentconfig = "../config/statsconfig1.php";
    $currentconfignumber = 1;
  }
}

displayadminheader();

if(!isset($currentconfig))
  die
  (
    "<table align=\"center\" class=\"alert\">
      <tr>
        <td><img src=\"../templates/admin/admin-warning.png\" width=\"48\" height=\"48\" /></td>
        <td>&nbsp;</td>
        <td align=\"left\">Looks like you haven't setup XLRstats Webfront correctly! Run installer first to setup. <br />Visit us at <span class=\"link1\"><a href=\"http://www.xlrstats.com\">www.xlrstats.com</a></span> for more information and help.
        </td>
      </tr>
    </table>"
  );

include($currentconfig);
if ($currentconfignumber == 0)
  include("../dynamic/award_idents.php");
else
  include("../dynamic/award_idents_".$currentconfignumber.".php");

// Debug mode?
if (!isset($debug))
  $debug = 1;
if ($debug == 1)
  error_reporting(E_ALL);
else
  error_reporting(0);

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

//if we have multiple servers, display servername
if(isset($servernames))
{
  getservername();
  echo "<br />";
}

if ($func == "")
  $func = "index";

if ($func == "index")
{
  xlrstatsversion();
  echo "<br />";
  short_serverstats();
  echo "<br />";
  tasks_menu();
}

if ($func == "settings")
  server_settings();

if ($func == "save")
  save_server_settings();

if ($func == "players")
  list_players();

if ($func == "showhidestats")
  show_hide_playerstats();

if ($func == "resetskill")
  reset_player_skill();

if ($func == "deleteserver")
  delete_server();

if ($func == "awards")
{
  echo "<table class=\"statstable\"><tr><td>";
  require ('../config/install_award_idents.php');
  echo "</tr></td>";
  echo "<tr><td align=\"right\"><input name=\"adminhome\" type=\"submit\" id=\"adminhome\" value=\"Admin Home\" onclick=\"window.location.href='index2.php'\"/>";
  echo "</td></tr></table>";
}

if ($func == "resetdb")
  resetDatabase();

displayadminfooter();
?>