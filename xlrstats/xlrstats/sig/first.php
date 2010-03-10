<?php
error_reporting( E_ERROR ^ E_WARNING );

include("../func-globallogic.php");
include("../func-siglogic.php");

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

include( "settings.php" );
include( "sanity.php" );
include("../inc_mysql.php");

// VARS
//$player_id = 0;
$width = 0;
$height = 0;
$backdrop_url = "";
$color_scheme_id = 0;
$current_time = time();

// REQUIRED INPUT
$player_rank  = 1;
if( isset($_GET['rank']) )	$player_rank  = addslashes_gpc($_GET['rank']);
if ( $player_rank > 100 ) die ( "You kidding me?" );

// OPTIONAL INPUT
$backdrop_url = $_GET['b'];

$style_options = explode("-", $_GET['s'] );
foreach( $style_options as $opt )
{
	if( $opt{0} == "c" ) $color_scheme_id = substr($opt,1);
	if( $opt{0} == "w" ) $width = substr($opt,1);
	if( $opt{0} == "h" ) $height = substr($opt,1);
}


// DATABASE
$coddb = new sql_db($db_host, $db_user, $db_pass, $db_db, false);
if(!$coddb->db_connect_id) 
  die("Could not connect to the database");

$query = "SELECT * 
          FROM ${t['players']}, ${t['b3_clients']} 
          WHERE ${t['b3_clients']}.id = ${t['players']}.client_id 
              AND ((${t['players']}.kills > $minkills)
                  OR (${t['players']}.rounds > $minrounds))
              AND (${t['players']}.hide = 0)
              AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER by skill DESC";

$result = $coddb->sql_query($query);
$numrows = $coddb->sql_numrows($result);

if ( $numrows < $player_rank ) die( "Rank out of reach!" );

$count = 1;
while ($count <= $player_rank)
{
  $player = $coddb->sql_fetchrow($result);
  $count += 1;  
}

$c = $count-1;
$player['rank'] = "#".$c." - ";

// TEMPLATE
include( "render.php" );

// OUTPUT
ob_start();
header( "Cache-Control: no-cache, must-revalidate" );
header( "Content-Type: image/png" );
imagepng( $image );
imagedestroy( $image );
ob_end_flush();
?>
