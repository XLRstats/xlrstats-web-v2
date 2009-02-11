<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2008 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
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
error_reporting(0);
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
echo "<head>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
echo "<title>XLRstats installation</title>";
echo "<style type=\"text/css\">";
echo "<!--";
echo "body,td,th {";
echo "	font-family: Calibri, Arial, Helvetica, sans-serif;";
echo "	color: #FFFFFF;";
echo "}";
echo "body {";
echo "	background-color: #000000;";
echo "	margin-left: 15px;";
echo "	margin-top: 15px;";
echo "}";
echo "a:link {";
echo "	color: #CCCCCC;";
echo "}";
echo "a:visited {";
echo "	color: #CCCCCC;";
echo "}";
echo "a:hover {";
echo "	color: #FF9900;";
echo "}";
echo "a:active {";
echo "	color: #CCCCCC;";
echo "}";
echo ".green {";
echo "	color: #00FF00;";
echo "}";
echo ".red {";
echo "	color: #FF4F4F;";
echo "}";
echo "-->";
echo "</style></head>";
echo " ";
echo "<body>";
echo "<h1>XLRstats Installation Stage 2 (of 3)</h1>";
echo "<i>(checking permissions, files and folders)</i>";
echo "<p>&nbsp;</p>";

$ver = phpversion();
if( version_compare($ver, "5.0.0", "<") )
  die( '<p class="red">This script requires a newer version of PHP than is installed on this server. Please upgrade to PHP5 or use a version of XLRstats prior to version 2.</p>' );

if (ini_get('register_globals') == 1)
  echo '<p class="red">You\'re php.ini setting Register Globals is set to ON. You can continue installation, but this setting makes XLRstats not function properly. Please ask your hosting provider to set the php_flag register_globals off!</p>';

check_file('../config/statsconfig.php', 1, 0);
echo '<p class="green">1.) Statsconfig exists, that\'s good!</p>';
include('../config/statsconfig.php');

if ($game == 'none')
    die('<p class="red">2.) Cannot continue, setup statsconfig.php first!<p/></body></html>');
echo '<p class="green">2.) Statsconfig is modified, that\'s good!</p>';

check_file('../dynamic/', 0, 1);
echo '<p class="green">3.) The ./dynamic folder is writable, that\'s good!</p>';

echo'<p><i>(If you want to setup multiple gameservers for this install and you have done all this before (or feel confident enough), you may now rename statsconfig.php to statsconfig1.php and copy the file to statsconfig2.php and so on. ';
echo 'If you have only one server at the time you can continue without any modifications. You can add other servers later. ';
echo 'You can read all about installing multiple servers in the README.TXT!)</i></p>';

$filename = '../config/install_award_idents.php';
check_file($filename, 1, 0);
echo '<p class="green">3.) Finally, we need to generate the award file. <a href="../config/install_award_idents.php">Click here to continue</a></p>';

echo "</body></html>";

//----------------------------------------------------------------------------------------------------------------------------------------------
function check_file($filename, $cexists, $cwritable)
{
    $errmsg1 = '<p class="red">'.$filename.' does not exist, cannot continue.<br />Please install XLRstats properly by uploading all files!<p/></body></html>';
    $errmsg2 = '<p class="red">'.$filename.' exists, but is not writeable.<br />Pls make sure I have write access for the file. (chmod 777 '.$filename.')<p/></body></html>';

    if (($cexists == 1) && (!file_exists($filename)))
        die($errmsg1);
    
    if (($cwritable == 1) && (!is_writable($filename)))
        die($errmsg2);
}

function wait_3()
{
    for ($i = 1; $i <= 3; $i++) 
    {
        sleep(1);
        echo " .";
    }
}
?>
