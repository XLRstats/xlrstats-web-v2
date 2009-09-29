<?php
//list playernames, but only once!
$query = "SELECT DISTINCT
            ${t['b3_clients']}.name
          FROM 
		    ${t['b3_clients']}, ${t['players']}
          WHERE 
		    (${t['players']}.client_id = ${t['b3_clients']}.id) AND (${t['b3_clients']}.name <> 'world')
          ORDER BY name ASC
          ";

$result = $coddb->sql_query($query);
while($row = $coddb->sql_fetchrow($result))
  $players[] = htmlspecialchars($row['name']);

$last_element = end($players);

echo "var players = [";
foreach ($players as $player)
{
  echo "{ name: \"$player\" }";
  if($player != $last_element)
    echo ",";
}
echo "];";
?>