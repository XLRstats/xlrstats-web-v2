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

if (!isset($pop))
  $pop = 0;

if (file_exists("config/inc_constants.php")) require_once("config/inc_constants.php");
if (file_exists("../config/inc_constants.php")) require_once("../config/inc_constants.php");

$lang_path = abs_pathlink($pop)."languages";
$default_lang = "en.php";

include ($lang_path."/".$default_lang);


if (isset($_COOKIE['XLR_langfile']))
{
  $lang_file = $_COOKIE['XLR_langfile'];
  if(file_exists($lang_path."/".$lang_file)) {
    //include ($lang_path."/".$lang_file);
  }
  // reset the $lang_file back to $default_lang for effective caching of awards
  else $lang_file = $default_lang;
}

//if GeoIP is installed the language file is set according to client's IP location
elseif (file_exists($geoip_path."GeoIP.dat")) 
{
  require_once("lib/geoip.inc");
  $client_ip = getvisitorip();
  $gi = geoip_open($geoip_path."GeoIP.dat", GEOIP_STANDARD);
  $lang_file = geoip_country_code_by_addr($gi, $client_ip).".php"; 
  $lang_file = strtolower($lang_file);
  $lang_file = checklangreplacement($lang_file);
  geoip_close($gi);

  if(file_exists($lang_path."/".$lang_file)) {
    include ($lang_path."/".$lang_file);
    }
  // reset the $lang_file back to $default_lang for effective caching of awards
  else $lang_file = $default_lang;
}

//if GeoIP is not installed the language file is set according to client's browser language
else
{
  $lang_file = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".php"; 
  $lang_file = checklangreplacement($lang_file);

    if(file_exists($lang_path."/".$lang_file)) {
      //include ($lang_path."/".$lang_file);
      }
    // reset the $lang_file back to $default_lang for effective caching of awards
    else $lang_file = $default_lang;
}

// -----------------------------------------------------------------------------
function checklangreplacement($lang_file)
{
  // array holding countryfiles which should default to a common language file
  $lang_es = array('mx.php',  'co.php',  'ar.php',  'pe.php',  've.php',  'cl.php',  'ec.php',  'gt.php',  'cu.php',  'bo.php',  'do.php',  'hn.php',  'sv.php',  'py.php',  'ni.php',  'cr.php',  'uy.php',  'pa.php',  'gq.php');
  $lang_nl = array('be.php');

  if (in_array($lang_file, $lang_es)) $lang_file = "es.php";
  elseif (in_array($lang_file, $lang_nl)) $lang_file = "nl.php";

  return $lang_file;
}
?>
