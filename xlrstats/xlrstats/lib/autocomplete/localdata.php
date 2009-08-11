var players = [
<?php

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