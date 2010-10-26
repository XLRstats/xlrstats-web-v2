<?php
// no direct access
defined( '_XLREXEC' ) or die( 'Restricted access' );

require_once("../func-globallogic.php");
// If statsconfig.php exists, we won't enable multiconfig functionality
if (file_exists("../config/statsconfig.php"))
{
  $currentconfig = "../config/statsconfig.php";
  $currentconfignumber = 0;
}
elseif (file_exists("../config/statsconfig1.php"))
{
  $currentconfig = "../config/statsconfig1.php";
  $currentconfignumber = 1;
  // Was a config set in the url?
  if (isset($_GET['config'])) 
  {
    $currentconfignumber = escape_string($_GET['config']);
    $currentconfig = "../config/statsconfig".$currentconfignumber.".php";
    $_SESSION['../currentconfignumber'] = $currentconfignumber;
  }
  if (isset($_SESSION['currentconfignumber']))
  {
    $currentconfignumber = $_SESSION['currentconfignumber'];
    $currentconfig = "../config/statsconfig".$currentconfignumber.".php";
  }
}
require_once($currentconfig);

// This folder MUST be writable.
define( "CACHE_PATH", "./user_store/" );

define( "DB_HOST", $db_host );
define( "DB_NAME", $db_db ); 
define( "DB_USER", $db_user ); 
define( "DB_PASS", $db_pass );

define( "SITE_NAME", $mysiteurl );

// Stuff you probably arnt interested in.
$backdr = "./backdrops/".$game."/";
$game_icon = "./icons/".$game."_icon.jpg";
define( "BACKDROP_FOLDER", $backdr );
define( "GAME_ICON", $game_icon );
define( "CACHE_LIFE", 120 ); // 120 mins
define( "IMAGE_MAX_WIDTH", 600 );
define( "IMAGE_MIN_WIDTH", 400 );
define( "IMAGE_DEF_WIDTH", 400 );
define( "IMAGE_MAX_HEIGHT", 400 );
define( "IMAGE_MIN_HEIGHT", 100 );
define( "IMAGE_DEF_HEIGHT", 100 );
define( "IMAGE_MAX_SIZE", 400000 );
?>
