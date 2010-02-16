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

$ch = new cache('version.cache');
if ($ch->cval == 0) checkupdate();
//else echo " (cached)";
$ch->close();

function checkupdate()
{
  try 
  {
    $lines = file('../version.txt');
    $c = explode(":", $lines[0]);
    $current = trim($c[1]);
    $latest = file('http://www.bigbrotherbot.com/xlrstats-version.txt');
    $dif = version_compare($current, $latest[0]);
    if ($dif == -1) $version_check = '<img src="../templates/admin/admin-exc.png" alt="" style="vertical-align: bottom;" />&nbsp;<font style="color:red;">A new version of XLRstats is available! Click <a href="http://www.xlrstats.com" target="_blank">here</a> to update!</font>';
    elseif ($dif == 0) $version_check = '<img src="../templates/admin/admin-accept.png" alt="" style="vertical-align: bottom;" />&nbsp;<font style="color:green;">You\'re running the current version of XLRstats</font>';
    else $version_check = '<img src="../templates/admin/admin-light.png" alt="" style="vertical-align: bottom;" />&nbsp;<font style="color:blue;">You\'re using a development version of XLRstats</font>';
  }
  catch (Exception $e)
  {
    continue;
  }
  return $version_check;
}

class cache
{
  var $cache_dir = '../dynamic/cache/';//This is the directory where the cache files will be stored;
  var $cache_time = 3600;//How much time will keep the cache files in seconds.
  
  var $caching = false;
  var $file = '';
  var $cval = 0;

  function cache($fname)
  {
    //Constructor of the class
    $this->file = $this->cache_dir . $fname;
    if ( file_exists ( $this->file ) && ( filemtime($this->file) + $this->cache_time ) > time() )
    {
      //Grab the cache:
      $handle = fopen( $this->file , "r");
      do {
        $data = fread($handle, 8192);
        if (strlen($data) == 0) {
          break;
        }
        $this->cval = 1;
        echo $data;
      } while (true);
      fclose($handle);
    }
    else
    {
      //create cache :
      $this->caching = true;
      ob_start();
    }
  }
  
  function close()
  {
    //You should have this at the end of each page
    if ( $this->caching )
    {
      //You were caching the contents so display them, and write the cache file
      $data = ob_get_clean();
      echo $data;
      $fp = fopen( $this->file , 'w' );
      fwrite ( $fp , $data );
      fclose ( $fp );
    }
  }
}

?>