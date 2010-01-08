<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2010 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
 * The Clanpage and its functions are ported by PerkBrian.
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

// This function displays the clan search box
function clansearchbox()
{
  $link = baselink();

  echo "<table width=\"100%\" height=\"60\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Clan Search</td></tr><tr><td>";
  echo "	<table width=\"100%\" height=\"60\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">";
  echo "		<tr><td align=\"center\">";
  echo "			<form action=\"$link?func=clan\" method=\"post\">";
  echo "			<input type=\"text\" name=\"input_name\" size=\"20\" />&nbsp;";
  echo "			<input type=\"submit\" value=\"Search\" />";
  echo "			<br />&nbsp;";
  echo "		</form>";
  echo "	</td></tr></table>";
  echo "</td></tr></table>";
}
//**************************************************************************************
//
//  Functions for the clan statistics (i.e. not player, weapon or map specific)
//  These are generally used on the "clan" page
//
//**************************************************************************************

// Function that prints a table of the best players. The criterium (e.g. skill or kills) can be
// specified.
function topclanplayers($sortby = "skill", $direction = "DESC", $offset = 0, $clan_name = "")
{

  $link = baselink();
  
  global $coddb;
  global $minkills;
  global $minrounds;
  global $toplist_max;
  global $t;
  global $maxdays;
  global $separatorline;
  global $currentconfignumber;
  $current_time = time();

  $sortfields = array("kills", "deaths", "ratio", "skill", "rounds", "winstreak", "losestreak");
  $sortby = strtolower($sortby);
  if (! in_array($sortby, $sortfields))
    $sortby = $sortfields[0];
  if ( $direction != "ASC")
    $direction = "DESC";

  echo "
  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Top $toplist_max - $sortby</span></td></tr><tr><td>
  <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
  <tr class=\"outertable\">
  <td>Rank</td>
  <td>Name</td>
  <td align=\"center\">Kills</td>
  <td align=\"center\">Deaths</td>
  <td align=\"center\">Ratio</td>
  <td align=\"center\">Skill</td>
  <td align=\"center\">Rounds</td>
  <td align=\"center\">Win streak</td>
  <td align=\"center\">Loss streak</td>
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
				AND (${t['b3_clients']}.name like '%%$clan_name%%')
        AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
            ORDER BY $sortby $direction";
  if ($toplist_max > 0)
    $query .= " LIMIT $toplist_max";

  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result))
  {
  if ($separatorline == 1)
    echo "<tr><td colspan=\"9\" class=\"outertable\"><img src=\"/images/spacer.gif\" width=\"1\" height=\"1\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr>";
    echo "<td>$rank</td>";
    echo "<td><a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">", $row['fixed_name'] ? $row['fixed_name'] : $row['name'], "</a></td>";
    echo "<td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
    echo "<td align=\"center\">${row['deaths']}</td>";
    $temp = sprintf("%.2f",$row['ratio']);
    echo "<td align=\"center\">$temp</td>";
    $temp = sprintf("%.1f",$row['skill']);
    echo "<td align=\"center\">$temp</td>";
    echo "<td align=\"center\">${row['rounds']}</td>";
    echo "<td align=\"center\">${row['winstreak']}</td>";
    echo "<td align=\"center\">",-$row['losestreak'],"</td>";
    echo "</tr>";
    $rank += $rank_step;
  }
  echo "</table>";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">You need at least $minrounds rounds or $minkills kills to appear on this list!";
  echo "</td></tr></table>";    // Closing extra border-table

}


// Function that prints some generic awards
function globalclan_awards($clan_name = "")
{

  $link = baselink();
  global $coddb;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
     
  global $minkills;
  global $minrounds;
  global $currentconfignumber;

  echo "
  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Our award winners</span></td></tr><tr><td>
  <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
    <tr class=\"outertable\">
      <td>Award</td>
      <td>Player</td>
      <td>Description</td>
      <td align=\"center\">Amount</td>
    </tr>
  ";

  // winning streak award (as the top lists this award is limited to minkills or minrounds)
  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, winstreak, kills, rounds, fixed_name
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
                AND ((${t['players']}.kills > $minkills)
                     OR (${t['players']}.rounds > $minrounds))
                AND (${t['players']}.hide = 0)
				AND (${t['b3_clients']}.name like '%%$clan_name%%')
            ORDER BY winstreak DESC, rounds ASC
            LIMIT 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  echo "<tr><td>${a_name['winstreak']}</td>
        <td><a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">", $row['fixed_name'] ? $row['fixed_name'] : $row['name'], "</a></td>
        <td>${a_desc['winstreak']}</td>  
        <td align=\"center\">${row['winstreak']}</td>
        </tr>";
  
  // loss streak award
  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, losestreak, fixed_name
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
                AND (${t['players']}.hide = 0)
				AND (${t['b3_clients']}.name like '%%$clan_name%%')
            ORDER BY losestreak ASC, rounds ASC  
            LIMIT 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  echo "<tr><td>${a_name['losestreak']}</td>
        <td><a href=\"$link?func=player&playerid=${row['id']}\">", $row['fixed_name'] ? $row['fixed_name'] : $row['name'], "</a></td>
        <td>${a_desc['losestreak']}</td>  
        <td align=\"center\">". -1 * $row['losestreak'] ."</td>
        </tr>";
            
  // rounds played award
  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, rounds, fixed_name
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
                AND (${t['players']}.hide = 0)
				AND (${t['b3_clients']}.name like '%%$clan_name%%')
            ORDER BY rounds DESC
            LIMIT 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  echo "<tr><td>${a_name['rounds']}</td>
        <td><a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">", $row['fixed_name'] ? $row['fixed_name'] : $row['name'], "</a></td>
        <td>${a_desc['rounds']}</td>  
        <td align=\"center\">${row['rounds']}</td>
        </tr>";

  // teamkills award
  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, teamkills, fixed_name
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
                AND (${t['players']}.hide = 0)
				AND (${t['b3_clients']}.name like '%%$clan_name%%')
            ORDER BY teamkills DESC, rounds ASC
            LIMIT 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  echo "<tr><td>${a_name['teamkills']}</td>
        <td><a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">", $row['fixed_name'] ? $row['fixed_name'] : $row['name'], "</a></td>
        <td>${a_desc['teamkills']}</td>  
        <td align=\"center\">${row['teamkills']}</td>
        </tr>";

  // teamdeaths award
  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, teamdeaths, fixed_name
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
                AND (${t['players']}.hide = 0)
				AND (${t['b3_clients']}.name like '%%$clan_name%%')
            ORDER BY teamdeaths DESC, rounds ASC
            LIMIT 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  echo "<tr><td>${a_name['teamdeaths']}</td>
        <td><a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">", $row['fixed_name'] ? $row['fixed_name'] : $row['name'], "</a></td>
        <td>${a_desc['teamdeaths']}</td>  
        <td align=\"center\">${row['teamdeaths']}</td>
        </tr>";

  // suicides award
  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, suicides, fixed_name
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
                AND (${t['players']}.hide = 0)
				AND (${t['b3_clients']}.name like '%%$clan_name%%')
            ORDER BY suicides DESC, rounds ASC
            LIMIT 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  echo "<tr><td>${a_name['suicides']}</td>
        <td><a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">", $row['fixed_name'] ? $row['fixed_name'] : $row['name'], "</a></td>
        <td>${a_desc['suicides']}</td>  
        <td align=\"center\">${row['suicides']}</td>
        </tr>";


echo "</table>";
echo "</td></tr><tr><td class=\"tiny\" align =\"right\">Top these players to win an award!";
echo "</td></tr></table>";                                                                // Closing extra border-table
}
?>
