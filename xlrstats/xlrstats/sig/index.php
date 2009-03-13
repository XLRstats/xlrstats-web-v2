<?php
error_reporting( E_ERROR ^ E_WARNING );

include("../func-globallogic.php");
include("../func-siglogic.php");

session_start();
cleanglobals();

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
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  if (isset($_SESSION['currentconfignumber']))
  {
    $currentconfignumber = $_SESSION['currentconfignumber'];
    $currentconfig = "../config/statsconfig".$currentconfignumber.".php";
  }
  // double check config number found point to an existing config file or fallback to config 1
  if (!file_exists($currentconfig)) 
  {
    $currentconfig = "config/statsconfig1.php";
    $currentconfignumber = 1;
  }
}
require_once($currentconfig);

// pop should hold the subdir depth of this file in relation to the xlrstats root.
$pop = 1;
include("../languages/languages.php");

include( "settings.php" );
include( "sanity.php" );
include("../inc_mysql.php");

// VARS
$player_id = 0;
$width = 0;
$height = 0;
$backdrop_url = "";
$color_scheme_id = 0;
$current_time = time();
$timelimit = $maxdays*60*60*24;

// REQUIRED INPUT
if( !isset($_GET['id']) )	die( "ID not specified." );
$player_id  = $_GET['id'];

// OPTIONAL INPUT
$backdrop_url = $_GET['b'];

$style_options = split("-", $_GET['s'] );
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

/*$query = "SELECT * 
          FROM ${t['players']}, ${t['b3_clients']} 
          WHERE ${t['b3_clients']}.id = ${t['players']}.client_id 
              AND ${t['players']}.id = '" . addslashes_gpc($player_id) . "'
              AND ((${t['players']}.kills > $minkills)
                  OR (${t['players']}.rounds > $minrounds))
              AND (${t['players']}.hide = 0)
              AND ($current_time - ${t['b3_clients']}.time_edit  < $timelimit)";*/

$query = "SELECT * 
          FROM ${t['players']}, ${t['b3_clients']} 
          WHERE ${t['b3_clients']}.id = ${t['players']}.client_id 
              AND ${t['players']}.id = '" . addslashes_gpc($player_id) . "'";

$result = $coddb->sql_query($query);
$player = $coddb->sql_fetchrow($result);

$coddb->sql_query("START TRANSACTION");
$coddb->sql_query("BEGIN");
$coddb->sql_query("SET @place = 0");
$query2 = "select * from (
             SELECT @place := @place + 1 AS place, ${t['players']}.id
             FROM ${t['players']}, ${t['b3_clients']}
          WHERE ${t['b3_clients']}.id = ${t['players']}.client_id
              AND ((${t['players']}.kills > $minkills)
                  OR (${t['players']}.rounds > $minrounds))
              AND (${t['players']}.hide = 0)
              AND ($current_time - ${t['b3_clients']}.time_edit  < $timelimit)";
                
   
   if ($exclude_ban) {
      $query2 .= "AND ${t['b3_clients']}.id NOT IN (
        SELECT distinct(target.id)
        FROM ${t['b3_penalties']} as penalties, ${t['b3_clients']} as target
        WHERE (penalties.type = 'Ban' OR penalties.type = 'TempBan')
        AND inactive = 0
        AND penalties.client_id = target.id
        AND ( penalties.time_expire = -1 OR penalties.time_expire > UNIX_TIMESTAMP(NOW()) )
      )";
    }     
    $query2 .= "     ORDER BY ${t['players']}.skill DESC
            ) derivated_table
            where id = $player_id";

$result2 = $coddb->sql_query($query2);
$row2 = $coddb->sql_fetchrow($result2);
$coddb->sql_query("ROLLBACK");

$player['name'] = $player['fixed_name'] ? $player['fixed_name'] : $player['name'];

if ($player['kills'] <= $minkills)
  $player['skill'] = "Need more kills";
elseif ($player['rounds'] <= $minrounds )
  $player['skill'] = "Need more rounds";
elseif ($player['hide'] == 1 )
  {
  $player['name'] = "Signature not available";
  $player['skill'] = "n.a.";
  $player['kills'] = "n.a."; 
  $player['deaths'] = "n.a."; 
  $player['ratio'] = "n.a."; 
  $player['winstreak'] = "n.a.";
  $player['losestreak'] = "n.a.";
  }
elseif ($current_time - $player['time_edit'] >= $timelimit )
  {
  $player['name'] .= " stats expired";
  $player['skill'] = "n.a.";
  $player['kills'] = "n.a."; 
  $player['deaths'] = "n.a."; 
  $player['ratio'] = "n.a."; 
  $player['winstreak'] = "n.a.";
  $player['losestreak'] = "n.a.";
  }


if ($row2['place'] != "")
  $player['rank'] = "#".$row2['place']." - ";
else
  $player['rank'] = "";

// TEMPLATE
include( "render.php" );

// OUTPUT
ob_start();
header( "Cache-Control: no-cache, must-revalidate" );
header( "Content-Type: image/jpeg" );
imagejpeg( $image, "", 100 );
imagedestroy( $image );
ob_end_flush();

?>
