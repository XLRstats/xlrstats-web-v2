<?php 

$ch = new cache('version.cache');
if ($ch->cval == 0) checkupdate();
//else echo " (cached)";
$ch->close();

function checkupdate()
{
  try 
  {
    $lines = file('version.txt');
    $c = explode(":", $lines[0]);
    $current = trim($c[1]);
    $latest = file('http://www.bigbrotherbot.com/xlrstats-version.txt');
    $dif = version_compare($current, $latest[0]);
    if ($dif == -1) echo 'A new version of XLRstats is available!';
    elseif ($dif == 0) echo 'You\'re running the current version of XLRstats';
    else echo 'You\'re using a development version of XLRstats';
  }
  catch (Exception $e)
  {
    continue;
  }
}

class cache
{
  var $cache_dir = './dynamic/cache/';//This is the directory where the cache files will be stored;
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