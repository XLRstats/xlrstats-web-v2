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

include("lib/ctracker.php");
include("func-globallogic.php");
include("lib/geoip.inc");

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
include("languages/languages.php");

// reset session
session_start();
session_unset();
unset($_SESSION['currentconfignumber']);
unset($currentconfignumber);
unset($_SESSION['template']);
unset($template);
// cookie[]
$cookiename = "XLR_langfile";
setcookie($cookiename, "", time()-3600);
$cookiename = "XLR_origlangfile";
setcookie($cookiename, "", time()-3600);

$cookiename = "XLR_playerid";
setcookie($cookiename, "", time()-3600);

$c = true;
$cnt = 0;
//$configlist[]= "";
while ($c == true)
{
  // cookie[0]
  $cookiename = "XLR_playerid[".$cnt."]";
  setcookie($cookiename, "", time()-3600);
  $cnt++;
  $filename = "config/statsconfig".$cnt.".php";
  if (file_exists($filename))
  {
    // cookie[1+]
    $cookiename = "XLR_playerid[".$cnt."]";
    setcookie($cookiename, "", time()-3600);
    $configlist[] = $cnt;
  }
  else $c = false;
}

echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<title>XLRstats reset data.</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$text["charset"]."\">
<style type=\"text/css\">
<!--
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
table {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
strong {
	font-size: large;
	color: #FF0000;
}
a {
	color: #FF0000;
}
-->
</style>
</head>

<body>
<table width=\"800\" border=\"0\" align=\"center\">
  <tr align=\"center\"> 
    <td colspan=\"2\"><strong>".$text["removedata"]."</strong></td>
  </tr>
  <tr align=\"center\">
    <td colspan=\"2\">&nbsp;</td>
  </tr>
  <tr align=\"center\"> 
    <td colspan=\"2\">".$text["resettingsession"]."</td>
  </tr>
  <tr align=\"center\"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align=\"center\"> 
    <!-- <td><a href=\"reset.php\">".$text["reloadpage"]."</a></td> -->
    <td><a href=\"index.php\">".$text["gotohome"]."</a> </td>
  </tr>
</table>
</body>
</html>
";

?>
