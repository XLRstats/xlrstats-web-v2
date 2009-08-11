var players = [
<?php

include ("../../inc_mysql.php");

// If statsconfig.php exists, we won't enable multiconfig functionality
if (file_exists("../../config/statsconfig.php"))
{
  $currentconfig = "../../config/statsconfig.php";
  $currentconfignumber = 0;
}
elseif (file_exists("../../config/statsconfig1.php"))
{
  $currentconfig = "../../config/statsconfig1.php";
  $currentconfignumber = 1;
  // Was a config set in the url?
  if (isset($_GET['config'])) 
  {
    $currentconfignumber = escape_string($_GET['config']);
    $currentconfig = "../../config/statsconfig".$currentconfignumber.".php";
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  if (isset($_SESSION['currentconfignumber']))
  {
    $currentconfignumber = $_SESSION['currentconfignumber'];
    $currentconfig = "../../config/statsconfig".$currentconfignumber.".php";
  }
  // double check config number found point to an existing config file or fallback to config 1
  if (!file_exists($currentconfig)) 
  {
    $currentconfig = "../../config/statsconfig1.php";
    $currentconfignumber = 1;
  }
}
include($currentconfig);

$coddb = new sql_db($db_host, $db_user, $db_pass, $db_db, false);
if(!$coddb->db_connect_id) {
    die($text["cantconnectdb"]);
}

//list players
$query = "SELECT 
            ${t['b3_clients']}.name, ${t['players']}.client_id
          FROM 
		    ${t['b3_clients']}, ${t['players']}
          WHERE 
		    (${t['players']}.client_id = ${t['b3_clients']}.id) AND (${t['players']}.client_id <> 1)
          ORDER BY name ASC
          ";

$result = $coddb->sql_query($query);
while($row = $coddb->sql_fetchrow($result))
{
  $players[] = htmlspecialchars($row['name']);
}

$last_element = end($players);

foreach ($players as $player)
{
  echo "{ name: \"$player\" }";
  if($player != $last_element)
    echo ",";
}
?>
];