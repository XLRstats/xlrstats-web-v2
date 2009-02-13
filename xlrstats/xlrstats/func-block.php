<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2009 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
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

//**************************************************************************************
//
//  Functions for the general statistics (i.e. not player, weapon or map specific)
//  These are specifically used on for inclusion as socalled "blocks".
//
//**************************************************************************************


// Function that prints a table of the best skilled players. 
function topplayersblock($sortby = "skill", $direction = "DESC", $offset = 0)
{

  global $coddb;
  global $minkills;
  global $minrounds;
  global $toplist_block;
  global $user_length;
  global $t;
  global $maxdays;
  global $currentconfignumber;
  $current_time = time();

  $sortfields = array("skill");
  $sortby = strtolower($sortby);
  if (! in_array($sortby, $sortfields))
    $sortby = $sortfields[0];
  if ( $direction != "ASC")
    $direction = "DESC";

  echo "
  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Top $toplist_block - $sortby</span></td></tr><tr><td>
  <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
  <tr class=\"outertable\">
  <td>Rank</td>
  <td>Name</td>
  </tr>
  ";

  $rank = $offset + 1;
  $rank_step = ($direction == "ASC" ? -1 : 1);
  
  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills, deaths, ratio, skill, winstreak, losestreak, rounds, fixed_name
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
                AND ((${t['players']}.kills > $minkills)
                     OR (${t['players']}.rounds > $minrounds))
                AND (${t['players']}.hide = 0)
        AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
            ORDER BY $sortby $direction";
  if ($toplist_block > 0)
    $query .= " LIMIT $offset, $toplist_block";
            
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result))
  {
    echo "<tr>";
    echo "<td>$rank</td>";
    
    $name = ($row['fixed_name'] ? $row['fixed_name'] : $row['name']);
    if (strlen($name) > $user_length)
      $name = (substr($name, 0, $user_length) . '...');
    
    echo "<td><a href=\"".httplink()."index.php?func=player&playerid=${row['id']}&config=${currentconfignumber}\" target=\"_blank\">", $name , "</a></td>";
    echo "</tr>";
    $rank += $rank_step;
  }

  echo "</table>";
  echo "</td></tr></table>";    // Closing extra border-table
}
?>
