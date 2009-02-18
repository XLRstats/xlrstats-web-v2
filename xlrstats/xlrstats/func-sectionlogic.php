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
//  These are generally used on the "index" page
//
//**************************************************************************************


// Function that prints a table of the best players. The criterium (e.g. skill or kills) can be
// specified.
function topplayers($sortby = "skill", $direction = "DESC", $offset = 0, $clan_name = "")
{
  $link = baselink();

  global $coddb;
  global $minkills;
  global $minrounds;
  global $toplist_max;
  global $t;
  global $maxdays;
  global $separatorline;
  global $MaxKillRatio;
  global $ShowRatioGraph;
  global $geoip_path;
  global $exclude_ban;
  global $rss_sortby;
  global $currentconfignumber;
  global $text;

  $current_time = gmdate("U");

  $sortfields = array("kills", "deaths", "ratio", "skill", "rounds", "winstreak", "losestreak");
  $sortby = strtolower($sortby);
  if (!in_array($sortby, $sortfields))
    $sortby = $sortfields[0];
  if ( $direction != "ASC")
    $direction = "DESC";
  $rss_sortby = $sortby;

  if ($clan_name != "")
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["top"]." $toplist_max - ".$text["$sortby"]." (".$text["filteredby"]." ". htmlspecialchars(utf2iso($clan_name)) .") ".feedlink()."</td></tr><tr><td>";
  else
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["top"]." $toplist_max - ".$text["$sortby"]." ".feedlink()."</td></tr><tr><td>";

  echo "
        <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
        <tr class=\"outertable\">
        <td align=\"center\" width=\"40\">".$text["place"]."</td>
        <td align=\"center\" width=\"30\">".$text["rank"]."</td> 
        <td>".$text["name"]."</td>";

  if (file_exists($geoip_path."GeoIP.dat"))
    echo "<td width=\"20\">".$text["cntry"]."</td>";

    $KillRatioTableWidth = 100;

  if ($sortby == "skill")
    echo "        <td align=\"center\">[ ".$text["skill"]." ]</td>";
  else
    echo "        <td align=\"center\">".$text["skill"]."</td>";
  if ($sortby == "kills")
    echo "        <td align=\"center\">[ ".$text["kills"]." ]</td>";
  else
    echo "        <td align=\"center\">".$text["kills"]."</td>";
  echo "        <td align=\"center\">".$text["deaths"]."</td>";
  if ($sortby == "ratio")
    echo "        <td width=\"$KillRatioTableWidth\" align=\"center\">[ ".$text["ratio"]." ]</td>";
  else
    echo "        <td width=\"$KillRatioTableWidth\" align=\"center\">".$text["ratio"]."</td>";
  echo "        <td align=\"center\">".$text["rounds"]."</td>";
  echo "        <td align=\"center\">".$text["winstrk"]."</td>";
  echo "        <td align=\"center\">".$text["losstrk"]."</td>";
  echo "        </tr>";
  
  if ($MaxKillRatio == 0)
  {
    // Determine the maximum ratio
    $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ratio, ip
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
        AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
        AND (${t['players']}.hide = 0)
        AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)";

    if ($clan_name != "")
    {
      $query .= " AND (${t['b3_clients']}.name like '%%$clan_name%%')";
    }
    
    if ($exclude_ban) {
      $query .= " AND ${t['b3_clients']}.id NOT IN (
        SELECT distinct(target.id)
        FROM ${t['b3_penalties']} as penalties, ${t['b3_clients']} as target
        WHERE (penalties.type = 'Ban' OR penalties.type = 'TempBan')
        AND inactive = 0
        AND penalties.client_id = target.id
        AND ( penalties.time_expire = -1 OR penalties.time_expire > UNIX_TIMESTAMP(NOW()) )
      )";
    }
    
    $query .= "ORDER BY ratio DESC, rounds ASC
        LIMIT 1";
        
    $result = $coddb->sql_query($query);
    $row = $coddb->sql_fetchrow($result);
    $MaxKillRatio = sprintf("%.2f",$row['ratio']);
  }

  $rank = $offset + 1;
  $rank_step = ($direction == "ASC" ? -1 : 1);
  
  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills, deaths, ratio, skill, winstreak, losestreak, rounds, fixed_name, ip
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
        AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
        AND (${t['players']}.hide = 0)
        AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)";

  if ($clan_name != "")
    $query .= " AND (${t['b3_clients']}.name like '%%$clan_name%%')";

  if ($exclude_ban) {
    $query .= " AND ${t['b3_clients']}.id NOT IN (
      SELECT distinct(target.id)
      FROM ${t['b3_penalties']} as penalties, ${t['b3_clients']} as target
      WHERE (penalties.type = 'Ban' OR penalties.type = 'TempBan')
      AND inactive = 0
      AND penalties.client_id = target.id
      AND ( penalties.time_expire = -1 OR penalties.time_expire > UNIX_TIMESTAMP(NOW()) )
    )";
  }
  
    
    $query .= "ORDER BY $sortby $direction";

  if ($toplist_max > 0)
    $query .= " LIMIT $offset, $toplist_max";
            
  $result = $coddb->sql_query($query);
  
  while ($row = $coddb->sql_fetchrow($result))
  {
    global $rankname;
    global $killsneeded;
    global $rankimage;   
    

    $kills =  get_rank_badge($row['kills']); 

    if ($separatorline == 1 && file_exists($geoip_path."GeoIP.dat"))
      echo "<tr><td colspan=\"11\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    elseif ($separatorline == 1)
      echo "<tr><td colspan=\"10\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows

    echo "<tr>";
    echo "<td align=\"center\"><strong>$rank</strong></td>";
      echo "<td><img src=\"images/ranks/".$rankimage[$kills]."\" width=\"30\" height=\"30\" title=\"".$rankname[$kills]."\"></td>";

    echo "<td><a href=\"$link?func=player&playerid=${row['id']}&config=${currentconfignumber}\">", htmlspecialchars(utf2iso($row['fixed_name'] ? $row['fixed_name'] : $row['name'])), "</a></td>";

    if (file_exists($geoip_path."GeoIP.dat"))
    {
      $geocountry = $geoip_path."GeoIP.dat";
      $ip = $row['ip'];
      $gi = geoip_open($geocountry,GEOIP_STANDARD);
      $countryid = strtolower (geoip_country_code_by_addr($gi, $ip));
      $country = geoip_country_name_by_addr($gi, $ip);
      if ( !is_null($countryid) and $countryid != "") 
        $flag = "<img src=\"images/flags/".$countryid.".gif\" title=\"".$country."\" alt=\"".$country."\">";
      else 
        $flag = "<img width=\"16\" height=\"11\" src=\"images/spacer.gif\" title=\"".$country."\" alt=\"".$country."\">"; 

      geoip_close($gi);
      echo "<td width=\"20\" align=\"center\">".$flag."</td>";
    }

    $temp = sprintf("%.1f",$row['skill']);
    if ($sortby == "skill")
      echo "<td align=\"center\"><strong>$temp</strong></td>";
    else
      echo "<td align=\"center\">$temp</td>";

    if ($sortby == "kills")
      echo "<td align=\"center\"><strong>", $row['kills'] ? $row['kills'] : "", "</strong></td>";
    else
      echo "<td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
    echo "<td align=\"center\">${row['deaths']}</td>";
    $temp = sprintf("%.2f",$row['ratio']);

    if ( $temp >= 1 )
    {
      $KillRatioWidthMinus = 100;
      $KillRatioWidthMinusText = "Ratio " . $temp;
    }
    else
    {
      $KillRatioWidthMinus = intval($temp * 100);
      $KillRatioWidthMinusText = "Ratio " . $temp . " - " . $KillRatioWidthMinus . "% of 1:0 Ratio";
    }
    
    if ( $temp < 1 )
    {
      $KillRatioWidthPlus = "0";
      $KillRatioWidthPlusText = "";
    }
    else
    {
      $KillRatioWidthPlus = intval( ($temp / ($MaxKillRatio/100)) );
      if ( $KillRatioWidthPlus > 100 ) 
        $KillRatioWidthPlus = 100;
    
      $KillRatioWidthPlusText = "Ratio " . $temp . " - " . $KillRatioWidthPlus . "% of best Ratio (Which is " . $MaxKillRatio . ")";
    }

    if($ShowRatioGraph == 3) // Basic ratiobar
    {
      echo "<td align=\"center\">";
      echo "        <table width=\"$KillRatioTableWidth\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
          <tr>
          <td bgcolor=\"#770000\" width=\"50%\" align=\"left\"><!-- ratio with minus --> 
          <img align=\"middle\" src=\"images/bars/bar-small/red_middle_9.gif\" width=\"$KillRatioWidthMinus%\" height=\"9\" title=\"$KillRatioWidthMinusText\">";

          if ($temp >= $MaxKillRatio)
          {
            echo "</td><td bgcolor=\"#FFFF00\" width=\"50%\" align=\"left\"><!-- ratio with plus --> 
            <img align=\"left\" src=\"images/bars/bar-small/yellow_middle_9.gif\" width=\"$KillRatioWidthPlus%\" height=\"9\" title=\"$KillRatioWidthPlusText\">";
          }
          else
          {
            echo "</td><td bgcolor=\"#007700\" width=\"50%\"><!-- ratio with plus -->"; 
            if ($KillRatioWidthPlus == 0)
              echo "<img src=\"images/spacer.gif\" width=\"1\" height=\"9\" alt=\"\">";
            else
              echo "<img align=\"left\" src=\"images/bars/bar-small/green_middle_9.gif\" width=\"$KillRatioWidthPlus%\" height=\"9\" title=\"$KillRatioWidthPlusText\">";
          }
          echo "</td>         
          </tr>
          <tr><td class=\"tiny\"  align=\"right\">($temp)</td><td class=\"tiny\" align=\"right\">($KillRatioWidthPlus%)</td></tr>
        </table>
     </td>";
    }
    elseif($ShowRatioGraph == 2) // Freelanders double ratio bar
    {
	  echo "<td>";
      echo "        <table width=\"$KillRatioTableWidth\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
  		<td bgcolor=\"#000000\" width=\"100%\" align=\"left\"><!-- ratio with minus -->
  		<img align=\"middle\" src=\"images/bars/bar-small/red_middle_9.gif\" width=\"$KillRatioWidthMinus%\" height=\"13\" title=\"$KillRatioWidthMinusText\"><div style=\"margin-top:-13px\"><center><font size=\"1\" color=\"#FFFFFF\">$temp</font></center></div>";
  	  echo "<tr></td><td><img src=\"images/spacer.gif\" width=\"1\" height=\"2\" alt=\"\">";

          if ($temp >= $MaxKillRatio)
          {
            echo"</td><tr><td bgcolor=\"#51260B\" width=\"100%\" align=\"left\"><!-- ratio with plus -->
        		<img align=\"middle\" src=\"images/bars/bar-small/yellow_middle_9.gif\" width=\"$KillRatioWidthPlus%\" height=\"13\" title=\"$KillRatioWidthPlusText\"><div style=\"margin-top:-13px\"><center><font size=\"1\" color=\"#000000\">$KillRatioWidthPlus%</font></center></div>";
          }
          else
          {
            echo "</td><tr><td bgcolor=\"#323E32\" width=\"50%\"><!-- ratio with plus -->"; 
            if ($KillRatioWidthPlus == 0)
              echo "<img src=\"images/spacer.gif\" width=\"1\" height=\"9\" alt=\"\"><div style=\"margin-top:-9px\"><center><font size=\"1\" color=\"#FFFFFF\">$KillRatioWidthPlus%</font></center></div>";
            else
              echo "<img src=\"images/bars/bar-small/green_middle_9.gif\" width=\"$KillRatioWidthPlus%\" height=\"13\" title=\"$KillRatioWidthPlusText\"><div style=\"margin-top:-13px\"><center><font size=\"1\" color=\"#FFFFFF\">$KillRatioWidthPlus%</font></center></div>";
          }
          echo "</td>         
          </tr>

        </table>
      </td>";
    }
    elseif($ShowRatioGraph == 1) // Freelander inline ratiobar
    {
	  echo "<td>";
    echo "        <table width=\"$KillRatioTableWidth\" cellpadding=\"1\" cellspacing=\"0\" border=\"0\" align=\"center\">
          <tr>
      		<td bgcolor=\"#000000\" width=\"50%\" align=\"left\"><!-- ratio with minus -->
      		<img align=\"middle\" src=\"images/bars/bar-small/red_middle_9.gif\" width=\"$KillRatioWidthMinus%\" height=\"13\" title=\"$KillRatioWidthMinusText\"><div style=\"margin-top:-13px\"><center><font size=\"1\" color=\"#FFFFFF\">$temp</font></center></div>";
          if ($temp >= $MaxKillRatio)
          {
            echo"<td></td><td bgcolor=\"#51260B\" width=\"50%\" align=\"left\"><!-- ratio with plus -->
        		<img align=\"middle\" src=\"images/bars/bar-small/yellow_middle_9.gif\" width=\"$KillRatioWidthPlus%\" height=\"13\" title=\"$KillRatioWidthPlusText\"><div style=\"margin-top:-13px\"><center><font size=\"1\" color=\"#000000\">$KillRatioWidthPlus%</font></center></div>";
          }
          else
          {
            echo "</td><td><td bgcolor=\"#323E32\" width=\"50%\"><!-- ratio with plus -->"; 
            if ($KillRatioWidthPlus == 0)
              echo "<img src=\"images/spacer.gif\" width=\"1\" height=\"9\" alt=\"\"><div style=\"margin-top:-9px\"><center><font size=\"1\" color=\"#FFFFFF\">$KillRatioWidthPlus%</font></center></div>";
            else
              echo "<img src=\"images/bars/bar-small/green_middle_9.gif\" width=\"$KillRatioWidthPlus%\" height=\"13\" title=\"$KillRatioWidthPlusText\"><div style=\"margin-top:-13px\"><center><font size=\"1\" color=\"#FFFFFF\">$KillRatioWidthPlus%</font></center></div>";
          }
          echo "</td>         
          </tr>
        </table>
      </td>";
    }
    else // No ratiobar, just numbers
    {
      if ($sortby == "ratio")
        echo "<td align=\"center\"><strong>$temp</strong></td>";
      else
        echo "<td align=\"center\">$temp</td>";
    }
    echo "<td align=\"center\">${row['rounds']}</td>";
    echo "<td align=\"center\">${row['winstreak']}</td>";
    echo "<td align=\"center\">",-$row['losestreak'],"</td>";
    echo "</tr>";
    $rank += $rank_step;
    }
    echo "</table>";
    echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["youneedweap"]."";
    echo "</td></tr></table>";    // Closing extra border-table
}


// Function that prints a table of the best weapons. The criterium (e.g. skill or kills) can be
// specified.
function topweapons($showplayercount = false, $sortby = "kills", $direction = "DESC", $offset = 0)
{

  $link = baselink();

  global $coddb;
  global $game;
  global $separatorline;
  global $t;  //table names
  global $w;  //weapon aliases
  global $text;
  
  global $weaplist_max;

  $sortfields = array("kills", "teamkills", "suicides");
  $sortby = strtolower($sortby);
  if (! in_array($sortby, $sortfields))
    $sortby = $sortfields[0];
  if ( $direction != "ASC")
    $direction = "DESC";

echo "
  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["top"]." ".$weaplist_max." ".$text["weapmost"]." ".$text["$sortby"]."</span></td></tr><tr><td>
  <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
    <tr class=\"outertable\">
     <td align=\"center\" width=\"40\">".$text["place"]."</td>
      <td>Name</td>
     <td align=\"center\" width=\"60\">".$text["view"]."</td>
      <td align=\"center\">".$text["totkill"]."</td>
<!--      <td align=\"center\">Total Teamkills</td> -->
<!--      <td align=\"center\">Total Suicides</td> -->
      ";

  if ($showplayercount == true)
    echo "<td>Nr of players</td>";
  echo "</tr>";
  
  $rank = $offset + 1;
  $rank_step = ($direction == "ASC" ? -1 : 1);
  
  $query = "SELECT id, name, kills, teamkills, suicides
      FROM ${t['weapons']}
      ORDER BY $sortby $direction";
  if ($weaplist_max > 0)
    $query .= " LIMIT $offset, $weaplist_max";
  //  $query .= " OFFSET $offset";
  
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result))
  {
    if ($separatorline == 1)
      echo "<tr><td colspan=\"11\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr>";
    echo "<td align=\"center\"><strong>$rank</strong></td>";
    if (isset($w[$row['name']]))
      echo "<td><a href=\"$link?func=weapon&weaponid=${row['id']}\">".$w[ $row['name'] ]."</a></td>";
    else
      echo "<td><a href=\"$link?func=weapon&weaponid=${row['id']}\">${row['name']}</a></td>";
      
    //$weaponName = strtolower( $row['name']);
    
    echo "<td align=\"center\"><a href=\"$link?func=weapon&weaponid=${row['id']}\">";
    // catch cod1, coduo and cod2 in one imagefolder
    if ($game == "cod1" && !file_exists("images/weapons/cod1/"))
      $gamename = "cod2";
    elseif ($game == "coduo" && !file_exists("images/weapons/coduo/"))
      $gamename = "cod2";
    else
      $gamename = $game;
    get_pic("images/weapons/$gamename/small/${row['name']}");
    echo "</a></td>";
      
    echo "<td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
    
    if ($showplayercount == true)
      echo "<td>Unknown</td>";
    
    echo "</tr>";
    $rank += $rank_step;
  }
  echo "</table>";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["weaponstats"];
  echo "</td></tr></table>"; // Closing extra border-table
}


// Function that prints a table of the best maps. The criterium (e.g. skill or kills) can be
// specified.
function topmaps($showplayercount = false, $sortby = "kills", $direction = "DESC", $offset = 0)
{

  $link = baselink();
  global $coddb;
  global $game;
  global $separatorline;
  global $text;
  
  global $t;  //table names
  global $m;  //map aliases
  global $maplist_max;
  
  $sortfields = array("kills", "teamkills", "suicides", "rounds");
  $sortby = strtolower($sortby);
  if (! in_array($sortby, $sortfields))
    $sortby = $sortfields[0];
  if ( $direction != "ASC")
    $direction = "DESC";

echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["top"]." ".$maplist_max." ".$text["mapsmost"]." ".$text["$sortby"]."</td></tr><tr><td>
  <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
    <tr class=\"outertable\">
      <td align=\"center\" width=\"40\">".$text["rank"]."</td>
      <td align=\"center\">".$text["map"]."</td>
      <td align=\"center\" width=\"60\">".$text["view"]."</td>
      <td align=\"center\">".$text["totkill"]."</td>
      <td align=\"center\">".$text["rounds"]."</td>
    ";

  if ($showplayercount == true)
    echo "<td align=\"center\">Nr of players</td>";
  echo "</tr>";
  
  $rank = $offset + 1;
  $rank_step = ($direction == "ASC" ? -1 : 1);
  
  $query = "SELECT name, kills, teamkills, suicides, rounds, id 
      FROM ${t['maps']}
      ORDER BY $sortby $direction";
  if ($maplist_max > 0)
    $query .= " LIMIT $offset, $maplist_max";
  
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result))
  {
    if ($separatorline == 1)
      echo "<tr><td colspan=\"12\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr>";
    echo "<td align=\"center\"><strong>$rank</strong></td>";

    if (isset($m[$row['name']]))
      echo "<td align=\"center\">"."  <a href=\"$link?func=map&mapid=${row['id']}\">".$m[ $row['name'] ]."</a></td>";
    else
      echo "<td align=\"center\"><a href=\"$link?func=map&mapid=${row['id']}\">${row['name']}</a></td>";

    //$mapName = strtolower($row['name']);

    echo "<td align=\"center\"><a href=\"$link?func=map&mapid=${row['id']}\">";
    // catch cod1, coduo and cod2 in one imagefolder
    if ($game == "cod1" && !file_exists("images/maps/cod1/"))
      $gamename = "cod2";
    elseif ($game == "coduo" && !file_exists("images/maps/coduo/"))
      $gamename = "cod2";
    else
      $gamename = $game;
    get_pic("images/maps/$gamename/middle/${row['name']}");
    echo "</a></td>";

    echo "<td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
    //echo "<td align=\"center\">", $row['teamkills'] ? $row['teamkills'] : "", "</td>";
    //echo "<td align=\"center\">", $row['suicides'] ? $row['suicides'] : "", "</td>";
    echo "<td align=\"center\">", $row['rounds'] ? $row['rounds'] : "", "</td>";
    
    if ($showplayercount == true)
      echo "<td>Unknown</td>";
    
    echo "</tr>";
    $rank += $rank_step;
  }
  echo "</table>";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["mapstats"];
  echo "</td></tr></table>";                                                                // Closing extra border-table
}

//********************************************************************************
//
//  Functions for player specific data
//
//********************************************************************************

function player_badges($playerid, $dbID = false)
{
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $aliashide_level;
  global $use_localtime;

  if($dbID == false)
  {
    $query = "SELECT ${t['b3_clients']}.name as clientname, ${t['b3_clients']}.time_add,
        ${t['b3_clients']}.time_edit, ${t['b3_clients']}.connections,
        ${t['b3_clients']}.group_bits,
        ${t['players']}.*
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE ${t['players']}.id = $playerid
        AND (${t['b3_clients']}.id = ${t['players']}.client_id)
        AND hide = 0
        LIMIT 1";
  }
  else 
  {
    $query = "SELECT ${t['b3_clients']}.name as clientname, ${t['b3_clients']}.time_add,
            ${t['b3_clients']}.time_edit, ${t['b3_clients']}.connections,
            ${t['b3_clients']}.group_bits,
            ${t['players']}.*
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE ${t['players']}.client_id = $playerid
            AND (${t['b3_clients']}.id = ${t['players']}.client_id)
            AND hide = 0
            LIMIT 1";
  }


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $playerid = $row['id'];  
    
  global $rankname;
  global $killsneeded;
  global $rankimage;
  global $text;
  
  $kills =  get_rank_badge($row['kills']); 
  $next = 0;
  $percent = 100;
  $neexed = 0;
  $previmage = $kills -1;
  $nextimage = $kills + 1;
  
  if( $kills == count( $killsneeded)-1)
  {
    $next = $kills;        
    $percent = 100;
    $neexed =  "max";        
  }
  else if( $kills < count( $killsneeded)-1)
  {
    $next = $kills + 1;
    $neexed =  $killsneeded[$kills+1] - $row['kills'];
    $percent = intval((1-($neexed/($killsneeded[$kills+1]-$killsneeded[$kills])))*100);
  }
  else
  {
    $next = $kills;
    $percent = 100;
  }
  
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td>";
  echo "    <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"innertable\">";
  echo "        <tr class=\"outertable\">";
  echo "            <td colspan=\"3\" align=\"center\"><font class=\"fontNormal\" size=\"5\" face=\"Geneva, Arial, Helvetica, sans-serif\"><font color=\"#000000\">".$text["rank"]."</font></font></td>";
  echo "         </tr>";
  echo "         <tr bgcolor=\"#edf3f9\">";  
  echo "            <td colspan=\"3\">";  
  echo "              <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"innertable\">";   
  echo "                  <tr bgcolor=\"#edf3f9\">";                
  echo "                      <tr bgcolor=\"#dde3e9\">";  
  echo "                        <td align='center'>".$text["previous"]."</td><td align='center'>".$text["currank"]."<br><strong>".$rankname[$kills]."</strong></td><td align='center'>".$text["next"]."</td>";
  echo "                      </tr>";  
  echo "             <td width=\"25%\" class=\"outertable\" colspan=\"1\" align=\"center\"><font class=\"fontNormal\" size=\"2\" face=\"Geneva, Arial, Helvetica, sans-serif\">";
  if($previmage != -1)
    echo "             <img src=\"images/ranks/".$rankimage[$previmage]."\" width=\"60\" height=\"60\" border=\"1\">";

  else
    echo $text["none"];
  
  echo "             </font></td> ";
  echo "             <td class=\"highlight\" colspan=\"1\" align=\"center\"><font class=\"fontNormal\" size=\"2\" face=\"Geneva, Arial, Helvetica, sans-serif\"><img src=\"images/ranks/".$rankimage[$kills]."\" width=\"112\" height=\"112\" border=\"1\"></font></td> ";

  echo "             <td  width=\"25%\" class=\"outertable\"  colspan=\"1\" align=\"center\"><font class=\"fontNormal\" size=\"2\" face=\"Geneva, Arial, Helvetica, sans-serif\">";
  if($nextimage < count( $killsneeded))   
    echo "             <img src=\"images/ranks/".$rankimage[$nextimage]."\" width=\"60\" height=\"60\" border=\"1\">";
  else
    echo "None (max)";

  echo "             </font></td> "; 
  echo "                  </tr>";
  echo "              </table></td>";     
  echo "         </tr>";   
  echo "         <tr bgcolor=\"#e8e8e8\"> "; 
  echo "          <td colspan=\"2\" width=\"600\">  "; 
  echo "          <div style=\"padding: 0px; background-image: url('images/bars/bar-small/red_middle_9.gif'); background-repeat: repeat-x;\" height=\"9\"><img src=\"images/bars/bar-small/green_middle_9.gif\" alt=\"&nbsp;Progress till next rank\" width=\"".$percent."%\" height=\"9\"></div></td> "; 
  echo "          <td align=\"center\" width=\"200\"><font color=\"#000000\" size=\"2\">".$text["killsneed"]." <b>".$neexed." (".$percent."%)</b></font></td></tr>  "; 
  echo "     </table>";
  echo "</table>";
}

function get_rank_badge($kills)
{
  global $killsneeded; 
  $result = 0;
  for($counter = 0;$counter < count( $killsneeded);$counter+=1)
  {
    if($killsneeded[$counter] < $kills)
      $result = $counter;
    else
      return $result;  
  }   
  return $result;
}


function player_compare($myplayerid, $playerid)
{
  global $ccounter1;
  global $ccounter2;
  $ccounter1 = 0;
  $ccounter2 = 0;

  // load the two players in arrays
  $player1 = player_short_comparison($myplayerid);
  $player2 = player_short_comparison($playerid);

  opentablerow(100);
  echo "<td align=\"center\">Player Comparison Chart. Comparing ".htmlspecialchars(utf2iso($player1['name']))." to ".htmlspecialchars(utf2iso($player2['name']))."</td></tr><tr>";
  closetablecell();
  closetablerow();

  echo "<br>";

  echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"0\"><tr>";
  echo "<td width=\"25%\">";
  player_compare_item($player1, $player2, $citem="playerrank", $cbar=false, $switchwinner=true, $columns=4);
  echo "</td><td width=\"25%\">";
  player_compare_item($player1, $player2, $citem="country", $cbar=false, $switchwinner=true, $columns=4);
  echo "</td><td width=\"25%\">";
  player_compare_item($player1, $player2, $citem="connections", $cbar=false, $switchwinner=false, $columns=4);
  echo "</td><td width=\"25%\">";
  player_compare_item($player1, $player2, $citem="rounds", $cbar=false, $switchwinner=false, $columns=4);
  echo "</td></tr></table>";

  echo "<br>";

  echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"0\"><tr>";
  echo "<td width=\"50%\">";
  player_compare_item($player1, $player2, $citem="skill", $cbar=true, $switchwinner=false, $columns=2);
  echo "<br>";
  echo "</td><td width=\"50%\">";
  player_compare_item($player1, $player2, $citem="ratio", $cbar=true, $switchwinner=false, $columns=2);
  echo "<br>";
  echo "</td></tr><tr><td width=\"50%\">";
  player_compare_item($player1, $player2, $citem="kills", $cbar=true, $switchwinner=false, $columns=2);
  echo "<br>";
  echo "</td><td width=\"50%\">";
  player_compare_item($player1, $player2, $citem="deaths", $cbar=true, $switchwinner=true, $columns=2);
  echo "<br>";
  echo "</td></tr><tr><td width=\"50%\">";
  player_compare_item($player1, $player2, $citem="winstreak", $cbar=true, $switchwinner=false, $columns=2);
  echo "<br>";
  echo "</td><td width=\"50%\">";
  player_compare_item($player1, $player2, $citem="losestreak", $cbar=true, $switchwinner=true, $columns=2);
  echo "<br>";
  echo "</td></tr><tr><td width=\"50%\">";
  player_compare_item($player1, $player2, $citem="teamkills", $cbar=true, $switchwinner=true, $columns=2);
  echo "<br>";
  echo "</td><td width=\"50%\">";
  player_compare_item($player1, $player2, $citem="teamdeaths", $cbar=true, $switchwinner=true, $columns=2);
  echo "<br>";
  echo "</td></tr></table>";

  opentablerow(100);
  echo "<td align=\"center\">Comparison Count and Conclusion</td></tr><tr>";
  opentablecell(100);
  $ctotal = $ccounter1+$ccounter2;
  if ($ccounter2 > $ccounter1)
    echo "We can conclude that ".htmlspecialchars(utf2iso($player1['name']))." ownes ".htmlspecialchars(utf2iso($player2['name']))." in ".$ccounter2." of ".$ctotal." total comparison sections!";
  if ($ccounter1 > $ccounter2)
    echo "We can conclude that ".htmlspecialchars(utf2iso($player2['name']))." ownes ".htmlspecialchars(utf2iso($player1['name']))." in ".$ccounter1." of ".$ctotal." total comparison sections!";
  closetablecell();
  closetablerow();
}

function player_compare_item($player1, $player2, $citem="skill", $cbar=true, $switchwinner=false, $columns=1)
{
  global $separatorline;
  global $ccounter1;
  global $ccounter2;

  global $main_width;
  $cwidth = ($main_width / $columns) - 200;
  
  if (!is_numeric($player1[$citem]) || !is_numeric($player2[$citem]))
  {
    $cbar = false;
    $cclass1 = "innertable";
    $cclass2 = "innertable";
  }  
  else
  {
    if ($player1[$citem] >= $player2[$citem])
    {
      if (is_numeric($player1[$citem]))
      {
        $player1perc = 1;
        $player2perc = $player2[$citem]/$player1[$citem];
      }
      $cclass1 = "innertable";
      $cbarcolor1 = "green";
      $cclass2 = "attention";
      $cbarcolor2 = "red";
      $ccounter2++;
    }
    else
    {
      if (is_numeric($player1[$citem]))
      {
        $player1perc = $player1[$citem]/$player2[$citem];
        $player2perc = 1;
      }
      $cclass1 = "attention";
      $cbarcolor1 = "red";
      $cclass2 = "innertable";
      $cbarcolor2 = "green";
      $ccounter1++;
    }
  
    if ($switchwinner)
    {
      if ($cclass1 == "attention")
      {
        $cclass1 = "innertable";
        $cbarcolor1 = "green";
        $cclass2 = "attention";
        $cbarcolor2 = "red";
        $ccounter2++;
        $ccounter1--;
      }
      else
      {
        $cclass1 = "attention";
        $cbarcolor1 = "red";
        $cclass2 = "innertable";
        $cbarcolor2 = "green";
        $ccounter1++;
        $ccounter2--;
      }
    }
  }
  
  opentablerow(100);
  
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"innertable\">";
  if ($cbar)
  {
    $temp1 = sprintf("%.2f",$player1perc)*100;
    $temp2 = sprintf("%.2f",$player2perc)*100;
    echo "<tr height=\"10\" class=\"outertable\"><td align=\"center\" colspan=\"3\">".ucfirst($citem)."</td></tr>";
    echo "<tr height=\"10\"><td class=$cclass1 width=\"140\" align=\"left\">".htmlspecialchars(utf2iso($player1['name']))."</td><td class=$cclass1 width=\"60\" align=\"left\">".$player1[$citem]."</td><td width=\"$cwidth\" class=$cclass1 align=\"left\"><img src=\"images/bars/bar-small/".$cbarcolor1."_middle_9.gif\" height=\"9\" width=\"".$player1perc*$cwidth."\" title=\"".$temp1."%\"></td></tr>";
    if ($separatorline == 1)
      echo "<tr><td colspan=\"3\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr height=\"10\"><td class=$cclass2 width=\"140\" align=\"left\">".htmlspecialchars(utf2iso($player2['name']))."</td><td class=$cclass2 width=\"60\" align=\"left\">".$player2[$citem]."</td><td width=\"$cwidth\" class=$cclass2 align=\"left\"><img src=\"images/bars/bar-small/".$cbarcolor2."_middle_9.gif\" height=\"9\" width=\"".$player2perc*$cwidth."\" title=\"".$temp2."%\"></td></tr>";
  }
  elseif ($citem == "country")
  {
    echo "<tr height=\"10\" class=\"outertable\"><td align=\"center\" colspan=\"2\">".ucfirst($citem)."</td></tr>";
    echo "<tr height=\"10\"><td class=$cclass1 width=\"140\" align=\"left\">".htmlspecialchars(utf2iso($player1['name']))."</td><td class=$cclass1 width=\"60\" align=\"center\">".$player1['flag']."</td></tr>";
    if ($separatorline == 1)
      echo "<tr><td colspan=\"2\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr height=\"10\"><td class=$cclass2 width=\"140\" align=\"left\">".htmlspecialchars(utf2iso($player2['name']))."</td><td class=$cclass2 width=\"60\" align=\"center\">".$player2['flag']."</td></tr>";
  }
  else
  {
    echo "<tr height=\"10\" class=\"outertable\"><td align=\"center\" colspan=\"2\">".ucfirst($citem)."</td></tr>";
    echo "<tr height=\"10\"><td class=$cclass1 width=\"140\" align=\"left\">".htmlspecialchars(utf2iso($player1['name']))."</td><td class=$cclass1 width=\"60\" align=\"left\">".$player1[$citem]."</td></tr>";
    if ($separatorline == 1)
      echo "<tr><td colspan=\"2\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr height=\"10\"><td class=$cclass2 width=\"140\" align=\"left\">".htmlspecialchars(utf2iso($player2['name']))."</td><td class=$cclass2 width=\"60\" align=\"left\">".$player2[$citem]."</td></tr>";
  }
  closetablerow();
}

function player_short_comparison($playerid)
{
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $aliashide_level;
  global $use_localtime;
  global $geoip_path;
  global $groupbits;
  global $limitplayerstats;
  global $sig;
  global $maxdays;
  global $minkills;
  global $minrounds;
  global $exclude_ban;
  global $myplayerid;
  global $func;
  global $text;

  $current_time = time();
  $timelimit = $maxdays*60*60*24;
  $link = baselink();
  $cplayer = array();


  $query = "SELECT ${t['b3_clients']}.name as clientname, ${t['b3_clients']}.time_add, ${t['b3_clients']}.ip,
      ${t['b3_clients']}.id as databaseid, ${t['b3_clients']}.time_edit, ${t['b3_clients']}.connections,
      ${t['b3_clients']}.group_bits,
      ${t['players']}.*
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE ${t['players']}.id = $playerid
      AND (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND hide = 0
      LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  if ($row == false)
    return;
  
  $coddb->sql_query("START TRANSACTION");
  $coddb->sql_query("BEGIN");
  $coddb->sql_query("SET @place = 0");
  $query4 = "select * from (
               SELECT @place := @place + 1 AS place, ${t['players']}.id

               FROM ${t['players']}, ${t['b3_clients']}
            WHERE ${t['b3_clients']}.id = ${t['players']}.client_id
                AND ((${t['players']}.kills > $minkills)
                    OR (${t['players']}.rounds > $minrounds))
                AND (${t['players']}.hide = 0)
                AND ($current_time - ${t['b3_clients']}.time_edit  < $timelimit)";
                
   
   if ($exclude_ban) {
      $query4 .= " AND ${t['b3_clients']}.id NOT IN (
        SELECT distinct(target.id)
        FROM ${t['b3_penalties']} as penalties, ${t['b3_clients']} as target
        WHERE (penalties.type = 'Ban' OR penalties.type = 'TempBan')
        AND inactive = 0
        AND penalties.client_id = target.id
        AND ( penalties.time_expire = -1 OR penalties.time_expire > UNIX_TIMESTAMP(NOW()) )
      )";
    }     
    $query4 .= "     ORDER BY ${t['players']}.skill DESC
            ) derivated_table
            where id = $playerid";

  $result4 = $coddb->sql_query($query4);
  $row4 = $coddb->sql_fetchrow($result4);
  $coddb->sql_query("ROLLBACK");
 
  $playerrank = $row4['place'] ? $row4['place'] : "n.a.";

  if (($playerrank == "n.a.") && (($row['kills'] <= $minkills) || ($row['rounds'] <= $minrounds) || ($current_time - $row4['time_edit'] >= $timelimit)))
    {
    //$playerrankdef = $text["playerrankdefinactive"];
    $playerrankdef = $text["playerrankdef"];
    if ($row['kills'] <= $minkills)
      $playerrankdef .= $text["playerrankdefa"];
    if ($row['rounds'] <= $minrounds)
      $playerrankdef .= $text["playerrankdefb"];
    if ($current_time - $row4['time_edit'] < $timelimit)
      $playerrankdef .= $text["playerrankdefc"];
    }
  elseif ($playerrank == 1)
    $playerrankdef = $text["congrats"];
  else
    $playerrankdef = $text["trytobetop"];
  
  $cplayer['playerrank'] = $playerrank;
  $cplayer['playerrankdef'] = $playerrankdef;


  if (file_exists($geoip_path."GeoIP.dat"))
  {
    $geocountry = $geoip_path."GeoIP.dat";
    $ip = $row['ip'];
    $gi = geoip_open($geocountry,GEOIP_STANDARD);
    $countryid = strtolower (geoip_country_code_by_addr($gi, $ip));
    $country = geoip_country_name_by_addr($gi, $ip);
    if ( !is_null($countryid) and $countryid != "") 
      $flag = "<img src=\"images/flags/".$countryid.".gif\" title=\"".$country."\" alt=\"".$country."\">";
    else 
      $flag = "<img width=\"16\" height=\"11\" src=\"images/spacer.gif\" title=\"".$country."\" alt=\"".$country."\">"; 
    geoip_close($gi);
  }

  $cplayer['skill'] = $row['skill'];
  $cplayer['id'] = $row['id'];
  $cplayer['dbid'] = $row['databaseid'];
  $cplayer['name'] = $row['fixed_name'] ? $row['fixed_name'] : $row['clientname'];
  $cplayer['groupbits'] = $row['group_bits'];
  $cplayer['skill'] = sprintf("%.1f",$row['skill']);
  $cplayer['kills'] = $row['kills'];
  $cplayer['deaths'] = $row['deaths'];
  $cplayer['ratio'] = sprintf("%.2f",$row['ratio']);
  $cplayer['rounds'] = $row['rounds'];
  $cplayer['winstreak'] = $row['winstreak'];
  $cplayer['losestreak'] = -1*$row['losestreak'];
  $cplayer['teamkills'] = $row['teamkills'];
  $cplayer['teamdeaths'] = $row['teamdeaths'];
  $cplayer['suicides'] = $row['suicides'];
  $cplayer['ip'] = $ip;
  $cplayer['country'] = $country;
  $cplayer['flag'] = $flag;
  $cplayer['connections'] = $row['connections'];


  if ($use_localtime == 1)
  {
    $cplayer['time_add'] = date("j F Y, G:i T", $row['time_add']+date("Z"));
    $cplayer['time_edit'] = date("j F Y, G:i T", $row['time_edit']+date("Z"));
  }
  else
  {
    $cplayer['time_add'] = date("j F Y, G:i", $row['time_add'])." GMT";
    $cplayer['time_edit'] = date("j F Y, G:i", $row['time_edit'])." GMT";
  }
  // Getting the highest group a player is in. 
  if ($groupbits == 0)
    $cplayer['group'] = "unregistered";
  else
  {
    for ($group=0; $groupbits >= (1<<$group); $group++);
        $group = 1 << ($group-1);
  
    $query2 = "SELECT name FROM ${t['b3_groups']} WHERE id=$group";
    $result2 = $coddb->sql_query($query2);
    if ($coddb->sql_numrows($result2) > 0)
    {
        $row2 = $coddb->sql_fetchrow($result2);
        $cplayer['group'] = $row2['name'];
    }
    else
    {
        $cplayer['group'] = "unknown group";
    }
  }
  // Getting the aliases for the player. Could be more than one!
  $query3 = "SELECT ${t['b3_aliases']}.*,
                    ${t['players']}.id, ${t['players']}.client_id, ${t['players']}.hide
            FROM  ${t['players']}, ${t['b3_aliases']}
            WHERE ${t['players']}.id = $playerid
              AND ${t['b3_aliases']}.client_id = ${t['players']}.client_id
              AND hide = 0";
  
  $result3 = $coddb->sql_query($query3);
  if ($row['group_bits'] < $aliashide_level)
  {
    if ($row3 = $coddb->sql_fetchrow($result3))
    {
      $temp = $row3['alias'];
      while ($row3 = $coddb->sql_fetchrow($result3))
        $temp .= ", ".$row3['alias'];
      $cplayer['alias'] = $temp;
    }
  }
  else
    $cplayer['alias'] = "";

  return $cplayer;
}


// This function gives a short overview of the players stats, like skill, kills, rounds, etc
function player_short($playerid, $dbID = false)
{
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $aliashide_level;
  global $use_localtime;
  global $geoip_path;
  global $groupbits;
  global $limitplayerstats;
  global $sig;
  global $maxdays;
  global $minkills;
  global $minrounds;
  global $exclude_ban;
  global $myplayerid;
  global $func;
  global $currentconfignumber;
  global $text;

  if($dbID == false)
  {
      $query = "SELECT ${t['b3_clients']}.name as clientname, ${t['b3_clients']}.time_add, ${t['b3_clients']}.ip,
          ${t['b3_clients']}.id as databaseid, ${t['b3_clients']}.time_edit, ${t['b3_clients']}.connections,
          ${t['b3_clients']}.group_bits,
          ${t['players']}.*
          FROM ${t['b3_clients']}, ${t['players']}
          WHERE ${t['players']}.id = $playerid
          AND (${t['b3_clients']}.id = ${t['players']}.client_id)
          AND hide = 0
          LIMIT 1";
  }
  else 
  {
      $query = "SELECT ${t['b3_clients']}.name as clientname, ${t['b3_clients']}.time_add, ${t['b3_clients']}.ip,
              ${t['b3_clients']}.id as databaseid, ${t['b3_clients']}.time_edit, ${t['b3_clients']}.connections,
              ${t['b3_clients']}.group_bits,
              ${t['players']}.*
              FROM ${t['b3_clients']}, ${t['players']}
              WHERE ${t['players']}.client_id = $playerid
              AND (${t['b3_clients']}.id = ${t['players']}.client_id)
              AND hide = 0
              LIMIT 1";
  }


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  if ($row == false)
    return;

  
  $databaseid = $row['databaseid'];
  $playerskill = $row['skill'];
  $playerid = $row['id'];
  $link = baselink();

  $current_time = time();
  $timelimit = $maxdays*60*60*24;

 
  $coddb->sql_query("START TRANSACTION");
  $coddb->sql_query("BEGIN");
  $coddb->sql_query("SET @place = 0");
  $query4 = "select * from (
               SELECT @place := @place + 1 AS place, ${t['players']}.id

               FROM ${t['players']}, ${t['b3_clients']}
            WHERE ${t['b3_clients']}.id = ${t['players']}.client_id
                AND ((${t['players']}.kills > $minkills)
                    OR (${t['players']}.rounds > $minrounds))
                AND (${t['players']}.hide = 0)
                AND ($current_time - ${t['b3_clients']}.time_edit  < $timelimit)";
                
   
   if ($exclude_ban) {
      $query4 .= " AND ${t['b3_clients']}.id NOT IN (
        SELECT distinct(target.id)
        FROM ${t['b3_penalties']} as penalties, ${t['b3_clients']} as target
        WHERE (penalties.type = 'Ban' OR penalties.type = 'TempBan')
        AND inactive = 0
        AND penalties.client_id = target.id
        AND ( penalties.time_expire = -1 OR penalties.time_expire > UNIX_TIMESTAMP(NOW()) )
      )";
    }     
    $query4 .= "     ORDER BY ${t['players']}.skill DESC
            ) derivated_table
            where id = $playerid";

  $result4 = $coddb->sql_query($query4);
  $row4 = $coddb->sql_fetchrow($result4);
  $coddb->sql_query("ROLLBACK");
 
  $playerrank = $row4['place'] ? $row4['place'] : "n.a.";
  /*if ($row4['place'] == "")
    $playerrank = "n.a.";
  else 
    $playerrank = $row4['place'];*/

  if (($playerrank == "n.a.") && (($row['kills'] <= $minkills) || ($row['rounds'] <= $minrounds) || ($current_time - $row4['time_edit'] >= $timelimit)))
    {
    //$playerrankdef = $text["playerrankdefinactive"];
    $playerrankdef = $text["playerrankdef"];
    if ($row['kills'] <= $minkills)
      $playerrankdef .= $text["playerrankdefa"];
    if ($row['rounds'] <= $minrounds)
      $playerrankdef .= $text["playerrankdefb"];
    if ($current_time - $row4['time_edit'] < $timelimit)
      $playerrankdef .= $text["playerrankdefc"];
    }
  elseif ($playerrank == 1)
    $playerrankdef = $text["congrats"];
  else
    $playerrankdef = $text["trytobetop"];
  
 
  if (file_exists($geoip_path."GeoIP.dat"))
  {
    $geocountry = $geoip_path."GeoIP.dat";
    $ip = $row['ip'];
    $gi = geoip_open($geocountry,GEOIP_STANDARD);
    $countryid = strtolower (geoip_country_code_by_addr($gi, $ip));
    $country = geoip_country_name_by_addr($gi, $ip);
    if ( !is_null($countryid) and $countryid != "") 
      $flag = "<img src=\"images/flags/".$countryid.".gif\" title=\"".$country."\" alt=\"".$country."\">";
    else 
      $flag = "<img width=\"16\" height=\"11\" src=\"images/spacer.gif\" title=\"".$country."\" alt=\"".$country."\">"; 
    geoip_close($gi);
  }


  echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\">";
  echo "  <tr>";
  echo "    <td width=\"300\" valign=\"top\" class=\"innertable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"innertable\">";
  echo "      <tr>";
  echo "        <td class=\"attention\">".$text["topskillrank"]."</td>";
  echo "        <td class=\"attention\" title=\"$playerrankdef\">$playerrank</td>";
  echo "      </tr>";
  echo "      <tr>";
  $temp = sprintf("%.1f",$row['skill']);
  echo "        <td class=\"attention\">".$text["skill"]."</td>";
  echo "        <td class=\"attention\" title=\"".$text["descskill"]."\">$temp</td>";
  echo "      </tr>";
  echo  "     <tr><td colspan=\"2\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";
  echo "      <tr>";
  echo "        <td>".$text["kills"]."</td>";
  echo "        <td>${row['kills']}</td>";
  echo "      </tr>";
  echo "      <tr>";
  echo "        <td>".$text["deaths"]."</td>";
  echo "        <td>${row['deaths']}</td>";
  echo "      </tr>";
  echo "      <tr>";
  $temp = sprintf("%.2f",$row['ratio']);
  echo "        <td>".$text["ratio"]."</td>";
  if ($row['ratio'] <= 1)
    echo "        <td title=\"".$text["descratio"]."\">$temp</td>";
  else
    echo "        <td title=\"".$text["descratiook"]."\">$temp</td>";
  echo "      </tr>";
  echo  "     <tr><td colspan=\"2\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";
  echo "      <tr>";
  echo "        <td>".$text["rounds"]."</td>";
  echo "        <td>${row['rounds']}</td>";
  echo "      </tr>";
  echo "      <tr>";
  echo "        <td>".$text["longestwinstrk"]."</td>";
  echo "        <td title=\"".$text["descwinstrk"]."\">${row['winstreak']}</td>";
  echo "      </tr>";
  echo "      <tr>";
  echo "        <td>".$text["longestlosstrk"]."</td>";
  echo "        <td title=\"".$text["desclosstrk"]."\">".-1*$row['losestreak']."</td>";
  echo "      </tr>";
  echo  "     <tr><td colspan=\"2\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";
  echo "      <tr>";
  echo "        <td>".$text["teamkills"]."</td>";
  echo "        <td title=\"".$text["descteamkill"]."\">${row['teamkills']}</td>";
  echo "      </tr>";
  echo "      <tr>";
  echo "        <td>".$text["teamdeaths"]."</td>";
  echo "        <td title=\"".$text["descteamdeath"]."\">${row['teamdeaths']}</td>";
  echo "      </tr>";
  echo "      <tr>";
  echo "        <td>".$text["suicides"]."</td>";
  echo "        <td title=\"...\">${row['suicides']}</td>";
  echo "      </tr>";
  echo  "     <tr><td colspan=\"2\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";
  echo "      <tr>";
  echo "        <td><span class=\"tiny\">XLRstatsID: $playerid</span></td>";
  echo "        <td><span class=\"tiny\" title=\"".$text["adminpurp"]."\">B3-ID: @$databaseid</span></td>";
  echo "      </tr>";
  echo "    </table></td>";

// This is the right part of the table with extra playerinfo
  $playername = htmlspecialchars(utf2iso($row['fixed_name'] ? $row['fixed_name'] : $row['clientname']));
  $groupbits = $row['group_bits'];

  echo "<td valign=\"top\">";
  echo "".$text["statsof"]."<span class=\"highlight\">", $playername, "</span>";
  echo "<br/><br/><span class=\"highlight\">".$playername."</span>"." ".$text["wasfirstreg"]." "."<span class=\"highlight\">";
  if ($use_localtime == 1)
    echo date("j F Y, G:i T", $row['time_add']+date("Z")). ",</span><br/>";
  else
    echo date("j F Y, G:i", $row['time_add']). " GMT,</span><br/>";
  echo $text["connected"]." <span class=\"highlight\">${row['connections']}</span> ".$text["times"].",<br/>";
  echo $text["lastseen"]. " <span class=\"highlight\">"; 
  if ($use_localtime == 1)
    echo date("j F Y, G:i T", $row['time_edit']+date("Z")). ",</span><br/>";
  else
    echo date("j F Y, G:i", $row['time_edit']). " GMT,</span><br/>";

  // Getting the highest group a player is in. 
  if ($groupbits == 0)
  {
  echo $text["notregyet"];
  if ($limitplayerstats == 1)
    echo "<br/><span class=\"attention\">".$text["regwillenstats"]."";
    if ($sig == 1) echo " ".$text["andthesiggen"]."</span>";
  echo "<br/><br/>";
  }
  else
  {
    for ($group=0; $groupbits >= (1<<$group); $group++);
        $group = 1 << ($group-1);

    $query2 = "SELECT name FROM ${t['b3_groups']} WHERE id=$group";
    $result2 = $coddb->sql_query($query2);
    if ($coddb->sql_numrows($result2) > 0)
    {
        $row2 = $coddb->sql_fetchrow($result2);
        echo $text["nknownas"]." <span class=\"highlight\">${row2['name']}.</span><br/><br/>";
    }
    else
    {
        echo $text["memofunknown"]."<br/><br/>";
    }
  }
  if (file_exists($geoip_path."GeoIP.dat"))
  {
    echo "<span class=\"highlight\">$playername</span> ".$text["conctfrom"]." ";
    echo $flag." ";
    echo "<span class=\"highlight\">$country.</span><br/><br/>";
    
  }
// Getting the aliases for the player. Could be more than one!

$query3 = "SELECT ${t['b3_aliases']}.*,
                  ${t['players']}.id, ${t['players']}.client_id, ${t['players']}.hide
          FROM  ${t['players']}, ${t['b3_aliases']}
          WHERE ${t['players']}.id = $playerid
            AND ${t['b3_aliases']}.client_id = ${t['players']}.client_id
            AND hide = 0";



$result3 = $coddb->sql_query($query3);

  if ($row['group_bits'] < $aliashide_level)
  {
    if ($row3 = $coddb->sql_fetchrow($result3))
    {
      echo $text["knownaliases"]."<br/>";
      echo "<span class=\"highlight\">". htmlspecialchars(utf2iso($row3['alias'])) ."</span>";
      while ($row3 = $coddb->sql_fetchrow($result3))
        echo ", <span class=\"highlight\">". htmlspecialchars(utf2iso($row3['alias'])) ."</span>";
    }
  }

  if ($groupbits > 0 || $limitplayerstats == 0)
    showsig($playerid);

  //echo $playerrankdef;
  echo "</td>";

  echo "<td width=\"90\" valign=\"top\" align=\"center\" class=\"innertable\">";
  if (($groupbits > 0 || $limitplayerstats == 0) && ($playerid != $myplayerid))
    echo "<a href=\"", $link, "?func=saveme&playerid=", $playerid, "\"><img src=\"images/ico/remember.png\" border=\"0\" align=\"absbottom\" title=\"".$text["rememberme"]."\"  style=\"margin: 4px; margin-bottom: 0px\"></a><br>";
  elseif ($groupbits > 0 || $limitplayerstats == 0)
    echo "<img src=\"images/ico/mystats.png\" border=\"0\" align=\"absbottom\" title=\"".$text["thisisme"]."\" style=\"margin: 4px; margin-bottom: 0px\"><br>";
  if (($playerid != $myplayerid) && ($func != "comp") && isset($myplayerid) )
    echo "<a href=\"", $link, "?func=comp&conf=", $currentconfignumber ,"&playerid=", $playerid, "&playerid2=", $myplayerid ,"\"><img src=\"images/ico/compare.png\" border=\"0\" align=\"absbottom\" title=\"".$text["compareme"]."\" style=\"margin: 4px; margin-bottom: 0px\"></a>";

// Closing the tables
  echo "</td></tr></table>";
}

// This function prints a table showing a players achievements with the various weapons,
// both in hitting and being hit
function player_weapons_s($playerid, $dbID = false)
{
  $link = baselink();
  global $coddb;
  global $separatorline;
     
  global $t; // table names from config
  global $w; // weapon names from config
  global $text;
  $Output = "";
  //<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Weapon achievements</td></tr><tr><td>
  $Output = "
  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td>
    <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
        <tr class=\"outertable\">
            <td colspan=\"1\" align=\"left\">".$text["favweapons"]."</td>
            <td width=\"80\" align=\"center\">".$text["yourkill"]."</td>
            <td width=\"250\" align=\"center\">".$text["peroftotkil"]."</td>
            <td width=\"100\" colspan=\"2\" align=\"center\">".$text["yourdeath"]."</td>
            <td width=\"100\" colspan=\"2\" align=\"center\">".$text["yoursuicide"]."</td>
    ";
    
    if($dbID == false)
    {
      $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
                FROM ${t['players']}
                WHERE id = $playerid AND hide = 0
                LIMIT 1";
    }
    else 
    {
      $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
                FROM ${t['players']}
                WHERE ${t['players']}.client_id = $playerid
                AND hide = 0
                LIMIT 1";
    }
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  if ($row == false) 
      return;  // no result given: does not exist or is hidden. Anyway, return whence thou camest!
     
  $playerid = $row['id'];
  $kills = $row['kills'];
  $deaths = $row['deaths'];
  $suicides = $row['suicides'];
  $teamkills = $row['teamkills'];
  $teamdeaths = $row['teamdeaths'];
  
  $query = "SELECT ${t['weapons']}.name, ${t['weapons']}.id, ${t['weaponusage']}.kills, 
                ${t['weaponusage']}.deaths, ${t['weaponusage']}.suicides, 
                ${t['weaponusage']}.teamkills, ${t['weaponusage']}.teamdeaths
            FROM ${t['weapons']}, ${t['weaponusage']}
            WHERE ${t['weaponusage']}.player_id = $playerid
                AND ${t['weapons']}.id = ${t['weaponusage']}.weapon_id
            ORDER BY ${t['weaponusage']}.kills DESC";


  $result = $coddb->sql_query($query);
  
  while ($row = $coddb->sql_fetchrow($result))
  {      
    if ($separatorline == 1)
      $Output .= "<tr><td colspan=\"11\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>
      ";  // This draws a one pixel line between rows

    $Output .= "<tr>
    ";
           
    if (isset($w[$row['name']]))
      $Output .= "<td align=\"left\"><a href=\"$link?func=weapon&weaponid=${row['id']}\">".$w[ $row['name'] ]."</a></td>
      ";
    else
      $Output .= "<td align=\"left\"><a href=\"$link?func=weapon&weaponid=${row['id']}\">${row['name']}</a></td>
      ";
      // $outtmp ="  <td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
      $Output .= "  <td align=\"center\">";
  
      // echo "  <td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";     
 
    if($row['kills'] ==  "" || $row['kills'] ==  0)
    {
     $Output .= "</td>
     ";       
    }
    else
    {
     $Output .= $row['kills']."</td> 
     ";      
    }
    
    $ratiola = 0;
    
    if ( ($kills > 0) && ($row['kills'] > 0) )
    {
      $ratiola = $temp = sprintf("%.2f", $row['kills']/($kills/100));
      if(intval($ratiola) >= 99)
        $temp = "97.50";
    }
    else
      $Output .= "  </td>";                                                                 
     
    $Output .= "<td align=\"left\">
      <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
        <tr>
        <td  width=\"100%\">
        ";
        if($ratiola > 0.00 )
            $Output .= "<img align=\"middle\" src=\"images/bars/bar-small/green_left_9.gif\" width=\"4\" height=\"9\" title=\"$ratiola % of total kills\"><img align=\"middle\" src=\"images/bars/bar-small/green_middle_9.gif\" width=".$temp."%\" height=\"9\" alt=".$ratiola." title=\"$ratiola % of total kills\"><img align=\"middle\" src=\"images/bars/bar-small/green_right_9.gif\" width=\"4\" height=\"9\"  title=\"$ratiola %\" ></td>
            ";
              
    $Output .= "    </td>
      </tr>
    </table>
        </td>
    </td>
    ";      

    $Output .= "  <td align=\"center\">";

    if($row['deaths'] ==  "" || $row['deaths'] ==  0)
    {
     $Output .= "</td>
     ";       
    }
    else
    {
     $Output .= $row['deaths']."</td> 
     ";      
    }
    
    if ( ($deaths > 0) && ($row['deaths'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['deaths']/$deaths);
      $Output .= "  <td align=\"center\" class=\"tiny\">($temp%)</td>
      ";   
    }
    else
    {
      $Output .= "  <td></td>
      ";
    }                                      
    $Output .= "  <td align=\"center\">";

    if($row['suicides'] ==  "" || $row['suicides'] ==  0)
    {
     $Output .= "</td>
     ";       
    }
    else
    {
     $Output .= $row['suicides']."</td> 
     ";      
    }
    
    if ( ($suicides > 0) && ($row['suicides'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['suicides']/$suicides);
      $Output .= "  <td align=\"center\" class=\"tiny\">($temp%)</td>
      ";   
    }
    else
    {
      $Output .= "  <td></td>
      ";
    }                                      
    $Output .= "</tr>
    ";   
  }                              
  $Output .= "</table>
  ";
  $Output .= "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["extraskilpoint"]."
  ";
  $Output .= "</td></tr></table>
  ";     // Closing extra border-table
  return $Output;
}

// This function prints a table showing a players achievements with the various weapons,
// both in hitting and being hit
function player_weapons($playerid, $dbID = false)
{
  $link = baselink();
  global $coddb;
  global $separatorline;
     
  global $t; // table names from config
  global $w; // weapon names from config
  global $text;
  
echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["weapachieve"]."</td></tr><tr><td>
      <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
      <tr class=\"outertable\">
        <td width=250 colspan=\"1\" >".$text["weapon"]."</td>
        <td align=\"center\">".$text["kills"]."</td>
        <td width=320 align=\"center\">".$text["ratio"]."</td>
        <td colspan=\"2\" align=\"center\">".$text["deaths"]."</td>
      <!--    <td colspan=\"2\" align=\"center\">".$text["suicides"]."</td> -->
      <!--    <td colspan=\"2\" align=\"center\">".$text["teamkills"]."</td> -->
      <!--    <td colspan=\"2\" align=\"center\">".$text["teamdeaths"]."</td></tr> -->
     ";
  
  if($dbID == false)
  {
    $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
              FROM ${t['players']}
              WHERE id = $playerid AND hide = 0
              LIMIT 1";
  }
  else 
  {
    $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
              FROM ${t['players']}
              WHERE ${t['players']}.client_id = $playerid
              AND hide = 0
              LIMIT 1";
  }
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  if ($row == false) 
    return;  // no result given: does not exist or is hidden. Anyway, return whence thou camest!
  
  $playerid = $row['id'];
  $kills = $row['kills'];
  $deaths = $row['deaths'];
  $suicides = $row['suicides'];
  $teamkills = $row['teamkills'];
  $teamdeaths = $row['teamdeaths'];
  
  $query = "SELECT ${t['weapons']}.name, ${t['weapons']}.id, ${t['weaponusage']}.kills, 
                ${t['weaponusage']}.deaths, ${t['weaponusage']}.suicides, 
                ${t['weaponusage']}.teamkills, ${t['weaponusage']}.teamdeaths
            FROM ${t['weapons']}, ${t['weaponusage']}
            WHERE ${t['weaponusage']}.player_id = $playerid
                AND ${t['weapons']}.id = ${t['weaponusage']}.weapon_id
            ORDER BY ${t['weaponusage']}.kills DESC";


  $result = $coddb->sql_query($query);
  
  while ($row = $coddb->sql_fetchrow($result))
  {
    if ($separatorline == 1)
      echo "<tr><td colspan=\"11\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr>";
    
    if (isset($w[$row['name']]))
      echo "<td><a href=\"$link?func=weapon&weaponid=${row['id']}\">".$w[ $row['name'] ]."</a></td>";
    else
      echo "<td><a href=\"$link?func=weapon&weaponid=${row['id']}\">${row['name']}</a></td>";
      
    echo "  <td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
    
    $ratiola = 0;
    
    if ( ($kills > 0) && ($row['kills'] > 0) )
      $ratiola = $temp = sprintf("%.2f", $row['kills']/($kills/100));
    else
      echo "  </td>";
  
    echo "<td align=\"center\">
      <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
        <tr>
        <td  width=\"100%\">";
    if($ratiola > 0.00 )
      echo "<img align=\"middle\" src=\"images/bars/bar-small/green_left_9.gif\" width=\"\" height=\"9\" title=\"$ratiola %\"><img align=\"middle\" src=\"images/bars/bar-small/green_middle_9.gif\" width=".$ratiola."%\" height=\"9\" alt=".$ratiola." title=\"$ratiola %\"><img align=\"middle\" src=\"images/bars/bar-small/green_right_9.gif\" width=\"\" height=\"9\"  title=\"$ratiola %\" ></td>";
        
    echo "  </td>
            </tr>
          </table>
          </td>
        </td>";      
    echo "  <td align=\"center\">", $row['deaths'] ? $row['deaths'] : "", "</td>";
    if ( ($deaths > 0) && ($row['deaths'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['deaths']/$deaths);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";

    echo "</tr>";
  }
  echo "</table>";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["extraskilpoint"]."";
  echo "</td></tr></table>";     // Closing extra border-table
}
  
function player_bodyparts_s($playerid, $dbID = false)
{
  $Output = "";              
  $link = baselink();
    
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $b; // bodypart names from config
  global $game;
  global $groupbits;
  global $text;
  //<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Hitzones</td></tr><tr><td>   
  
  $Output = 
"  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr valign=\"top\"><td>  
    <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td>
        <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
            <tr class=\"outertable\">
                <td width=\"250\" align=\"left\">".$text["bodyparts"]."</td>
                <td width=\"140\"colspan=\"2\" align=\"center\">".$text["yourkill"]."</td>
                <td width=\"140\"colspan=\"2\" align=\"center\">".$text["yourdeath"]."</td>
    ";
    if($dbID == false)
    {
        $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths
                FROM ${t['players']}
                WHERE id = $playerid AND hide = 0
                LIMIT 1";
    }
    else 
    {
        $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths
                FROM ${t['players']}
                WHERE client_id = $playerid AND hide = 0
                LIMIT 1";
    }
    $result = $coddb->sql_query($query);
    $row = $coddb->sql_fetchrow($result);

    $playerid =  $row['id'];
    $kills = $row['kills'];
    $deaths = $row['deaths'];
    $suicides = $row['suicides'];
    $teamkills = $row['teamkills'];
    $teamdeaths = $row['teamdeaths'];
  
    $query = "SELECT ${t['bodyparts']}.name, ${t['bodyparts']}.id, ${t['playerbody']}.kills, 
            ${t['playerbody']}.deaths, ${t['playerbody']}.suicides, 
            ${t['playerbody']}.teamkills, ${t['playerbody']}.teamdeaths
            FROM ${t['bodyparts']}, ${t['playerbody']}
            WHERE ${t['playerbody']}.player_id = $playerid
            AND ${t['bodyparts']}.id = ${t['playerbody']}.bodypart_id
            ORDER BY ${t['playerbody']}.kills DESC";
  

    $result = $coddb->sql_query($query);

    $mybodypats = array();

    while ($row = $coddb->sql_fetchrow($result))
    {
      if ($separatorline == 1)
      {
        $Output .=  "<tr><td colspan=\"11\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>
        ";  // This draws a one pixel line between rows
      }
      $Output .= "<tr>";

      $bset = false;
      if (isset($b[$row['name']]))
      {
        $Output .= "  <td align=\"left\">".$b[ $row['name'] ]."</td>
        ";
        $bset = true;
      }
      else
        $Output .=  "  <td>${row['name']}</td>";                
      $Output .=  "  <td align=\"center\">";
      if($row['kills'] ==  "")
      {
        $Output .= "</td>
        ";       
      }
      else
      {
        $Output .= $row['kills']."</td>
        ";
      }
  
      if ( ($kills > 0) && ($row['kills'] > 0) )
      {
        $temp = sprintf("%.2f", 100*$row['kills']/$kills);
        $Output .= "  <td align=\"center\" class=\"tiny\">($temp%)</td>
        ";   
        $mybodypats[ $row['name'] ] = sprintf("%.0f", intval(round(($row['kills']/$kills), 1)*10) * 10);      
      }
      else
        $Output .= "  <td></td>";

      $Output .=    "  <td align=\"center\">";
      if($row['deaths'] ==  "")
      {
        $Output .= "</td>
        ";       
      }
      else
      {
        $Output .= $row['deaths']."</td>
        ";   
      }
      if ( ($deaths > 0) && ($row['deaths'] > 0) )
      {
        $temp = sprintf("%.2f", 100*$row['deaths']/$deaths);
        $Output .= "  <td align=\"center\" class=\"tiny\">($temp%)</td>
        ";   
      }
      else
      {
        $Output .= "  <td></td>
        ";
      }

      $Output .= "</tr>";
    }
    $Output .= "</table>
    ";
    $Output .= "</td>
    </tr>
    <tr>    
        <td class=\"tiny\" align =\"right\">".$text["watchcover"]."
    ";
    $Output .= "    </td>
            </tr>
        </table> 
    ";    
      //<td align=\"center\" width=\"1\" width=\"10\">&nbsp;</td>
      
  if($game == "urt") {
    if (isset($mybodypats['0'])) $hz_head = $mybodypats['0']+$mybodypats['1']; // Head + helmet
    else $hz_head = 0;
    if (isset($mybodypats['neck'])) $hz_neck = 0; // Neck doesn't exist
    else $hz_neck = 0;
    if (isset($mybodypats['2'])) $hz_torso_upper = $mybodypats['2']+$mybodypats['3']; // Torso + kevlar
    else $hz_torso_upper = 0;
    if (isset($mybodypats['2'])) $hz_torso_lower = $mybodypats['2']+$mybodypats['3']; // Torso + kevlar
    else $hz_torso_lower = 0;
    if (isset($mybodypats['4'])) $hz_left_arm_upper = $mybodypats['4']; // Arms
    else $hz_left_arm_upper = 0;
    if (isset($mybodypats['4'])) $hz_left_arm_lower = $mybodypats['4']; // Arms
    else $hz_left_arm_lower = 0;
    if (isset($mybodypats['4'])) $hz_left_hand = $mybodypats['4']; // Arms
    else $hz_left_hand = 0;
    if (isset($mybodypats['4'])) $hz_right_arm_upper = $mybodypats['4']; // Arms
    else $hz_right_arm_upper = 0;
    if (isset($mybodypats['4'])) $hz_right_arm_lower = $mybodypats['4']; // Arms
    else $hz_right_arm_lower = 0;
    if (isset($mybodypats['4'])) $hz_right_hand = $mybodypats['4']; // Arms
    else $hz_right_hand = 0;
    if (isset($mybodypats['5'])) $hz_left_leg_upper = $mybodypats['5']; // Legs
    else $hz_left_leg_upper = 0;
    if (isset($mybodypats['5'])) $hz_left_leg_lower = $mybodypats['5']; // Legs
    else $hz_left_leg_lower = 0;
    if (isset($mybodypats['5'])) $hz_left_foot = $mybodypats['5']; // Legs
    else $hz_left_foot = 0;
    if (isset($mybodypats['5'])) $hz_right_leg_upper = $mybodypats['5']; // Legs
    else $hz_right_leg_upper = 0;
    if (isset($mybodypats['5'])) $hz_right_leg_lower = $mybodypats['5']; // Legs
    else $hz_right_leg_lower = 0;
    if (isset($mybodypats['5'])) $hz_right_foot = $mybodypats['5']; // Legs
    else $hz_right_foot = 0;
    if (isset($mybodypats['none'])) $hz_none = 0;
    else $hz_none = 0;
  }
  else {
    if (isset($mybodypats['head'])) $hz_head = $mybodypats['head'];
    else $hz_head = 0;
    if (isset($mybodypats['neck'])) $hz_neck = $mybodypats['neck'];
    else $hz_neck = 0;
    if (isset($mybodypats['torso_upper'])) $hz_torso_upper = $mybodypats['torso_upper'];
    else $hz_torso_upper = 0;
    if (isset($mybodypats['torso_lower'])) $hz_torso_lower = $mybodypats['torso_lower'];
    else $hz_torso_lower = 0;
    if (isset($mybodypats['left_arm_upper'])) $hz_left_arm_upper = $mybodypats['left_arm_upper'];
    else $hz_left_arm_upper = 0;
    if (isset($mybodypats['left_arm_lower'])) $hz_left_arm_lower = $mybodypats['left_arm_lower'];
    else $hz_left_arm_lower = 0;
    if (isset($mybodypats['left_hand'])) $hz_left_hand = $mybodypats['left_hand'];
    else $hz_left_hand = 0;
    if (isset($mybodypats['right_arm_upper'])) $hz_right_arm_upper = $mybodypats['right_arm_upper'];
    else $hz_right_arm_upper = 0;
    if (isset($mybodypats['right_arm_lower'])) $hz_right_arm_lower = $mybodypats['right_arm_lower'];
    else $hz_right_arm_lower = 0;
    if (isset($mybodypats['right_hand'])) $hz_right_hand = $mybodypats['right_hand'];
    else $hz_right_hand = 0;
    if (isset($mybodypats['left_leg_upper'])) $hz_left_leg_upper = $mybodypats['left_leg_upper'];
    else $hz_left_leg_upper = 0;
    if (isset($mybodypats['left_leg_lower'])) $hz_left_leg_lower = $mybodypats['left_leg_lower'];
    else $hz_left_leg_lower = 0;
    if (isset($mybodypats['left_foot'])) $hz_left_foot = $mybodypats['left_foot'];
    else $hz_left_foot = 0;
    if (isset($mybodypats['right_leg_upper'])) $hz_right_leg_upper = $mybodypats['right_leg_upper'];
    else $hz_right_leg_upper = 0;
    if (isset($mybodypats['right_leg_lower'])) $hz_right_leg_lower = $mybodypats['right_leg_lower'];
    else $hz_right_leg_lower = 0;
    if (isset($mybodypats['right_foot'])) $hz_right_foot = $mybodypats['right_foot'];
    else $hz_right_foot = 0;
    if (isset($mybodypats['none'])) $hz_none = $mybodypats['none'];
    else $hz_none = 0;
  }

    $zero = "0";
    $Output .= "</td>
    <td> &nbsp; </td> 
    <td> 
      <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td>
        <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
            <tr class=\"outertable\">
                <td width=\"250\"><center>".$text["accuracy"]."</center></td> 
                <tr>
                    <td>   
                        <table id=\"Table_01\" width=\"370\" height=\"584\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                            <tr>
                                <td colspan=\"14\">
                                    <img src=\"images/model/common/0_01.png\" width=\"370\" height=\"31\" alt=\"\"></td>
                                <td height=\"31\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"6\">
                                    <img src=\"images/model/common/0_02.png\" width=\"140\" height=\"94\" alt=\"\"></td>
                                <td colspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_head, $kills))."/head.png\" width=\"90\" height=\"94\" alt=\"\"></td>
                                <td colspan=\"6\">
                                    <img src=\"images/model/common/0_04.png\" width=\"140\" height=\"94\" alt=\"\"></td>
                                <td height=\"94\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"4\">
                                    <img src=\"images/model/common/0_05.png\" width=\"102\" height=\"28\" alt=\"\"></td>
                                <td colspan=\"6\">
                                    <img src=\"images/model/".(getPercent($hz_neck, $kills))."/neck.png\" width=\"166\" height=\"28\" alt=\"\"></td>
                                <td colspan=\"4\">
                                    <img src=\"images/model/common/0_07.png\" width=\"102\" height=\"28\" alt=\"\"></td>
                                <td height=\"28\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\">
                                    <img src=\"images/model/common/0_08.png\" width=\"57\" height=\"62\" alt=\"\"></td>
                                <td colspan=\"3\">
                                    <img src=\"images/model/".(getPercent($hz_right_arm_upper, $kills))."/left_arm_upper.png\" width=\"68\" height=\"62\" alt=\"\"></td>
                                <td colspan=\"4\" rowspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_torso_upper, $kills))."/chest.png\" width=\"120\" height=\"97\" alt=\"\"></td>
                                <td colspan=\"3\">
                                    <img src=\"images/model/".(getPercent($hz_left_arm_upper, $kills))."/right_arm_upper.png\" width=\"61\" height=\"62\" alt=\"\"></td>
                                <td colspan=\"2\">
                                    <img src=\"images/model/common/0_12.png\" width=\"64\" height=\"62\" alt=\"\"></td>
                                <td height=\"62\" nowrap></td>
                            </tr>
                            <tr>
                                <td rowspan=\"2\">
                                    <img src=\"images/model/common/0_13.png\" width=\"27\" height=\"47\" alt=\"\"></td>
                                <td colspan=\"3\" rowspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_right_arm_lower, $kills))."/left_arm_lower.png\" width=\"75\" height=\"47\" alt=\"\"></td>
                                <td>
                                    <img src=\"images/model/common/0_15.png\" width=\"23\" height=\"35\" alt=\"\"></td>
                                <td>
                                    <img src=\"images/model/common/0_16.png\" width=\"23\" height=\"35\" alt=\"\"></td>
                                <td colspan=\"3\" rowspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_left_arm_lower, $kills))."/right_arm_lower.png\" width=\"71\" height=\"47\" alt=\"\"></td>
                                <td rowspan=\"2\">
                                    <img src=\"images/model/common/0_18.png\" width=\"31\" height=\"47\" alt=\"\"></td>
                                <td height=\"35\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"6\" rowspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_torso_lower, $kills))."/torso_lower.png\" width=\"166\" height=\"60\" alt=\"\"></td>
                                <td height=\"12\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"3\" rowspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_right_hand, $kills))."/left_hand.png\" width=\"69\" height=\"59\" alt=\"\"></td>
                                <td rowspan=\"6\">
                                    <img src=\"images/model/common/0_21.png\" width=\"33\" height=\"322\" alt=\"\"></td>
                                <td rowspan=\"6\">
                                    <img src=\"images/model/common/0_22.png\" width=\"27\" height=\"322\" alt=\"\"></td>
                                <td colspan=\"3\" rowspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_left_hand, $kills))."/right_hand.png\" width=\"75\" height=\"59\" alt=\"\"></td>
                                <td height=\"48\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"3\" rowspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_right_leg_upper, $kills))."/left_leg_upper.png\" width=\"83\" height=\"84\" alt=\"\"></td>
                                <td colspan=\"3\" rowspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_left_leg_upper, $kills))."/right_leg_upper.png\" width=\"83\" height=\"84\" alt=\"\"></td>
                                <td height=\"11\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"3\" rowspan=\"4\">
                                    <img src=\"images/model/common/0_26.png\" width=\"69\" height=\"263\" alt=\"\"></td>
                                <td colspan=\"3\" rowspan=\"4\">
                                    <img src=\"images/model/common/0_27.png\" width=\"75\" height=\"263\" alt=\"\"></td>
                                <td height=\"73\" nowrap></td>
                            </tr>
                            <tr>
                                <td rowspan=\"3\">
                                    <img src=\"images/model/common/0_28.png\" width=\"23\" height=\"190\" alt=\"\"></td>
                                <td colspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_right_leg_lower, $kills))."/left_leg_lower.png\" width=\"60\" height=\"98\" alt=\"\"></td>
                                <td colspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_left_leg_lower, $kills))."/right_leg_lower.png\" width=\"60\" height=\"98\" alt=\"\"></td>
                                <td rowspan=\"3\">
                                    <img src=\"images/model/common/0_31.png\" width=\"23\" height=\"190\" alt=\"\"></td>
                                <td height=\"98\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_right_foot, $kills))."/left_foot.png\" width=\"60\" height=\"63\" alt=\"\"></td>
                                <td colspan=\"2\">
                                    <img src=\"images/model/".(getPercent($hz_left_foot, $kills))."/right_foot.png\" width=\"60\" height=\"63\" alt=\"\"></td>
                                <td height=\"63\" nowrap></td>
                            </tr>
                            <tr>
                                <td colspan=\"4\">
                                    <img src=\"images/model/common/0_34.png\" width=\"120\" height=\"29\" alt=\"\"></td>
                                <td height=\"29\" nowrap></td>
                            </tr>
                            <tr>
                                <td width=\"27\" nowrap></td>
                                <td width=\"30\" nowrap></td>
                                <td width=\"12\" nowrap></td>
                                <td width=\"33\" nowrap></td>
                                <td width=\"23\" nowrap></td>
                                <td width=\"15\" nowrap></td>
                                <td width=\"45\" nowrap></td>
                                <td width=\"45\" nowrap></td>
                                <td width=\"15\" nowrap></td>
                                <td width=\"23\" nowrap></td>
                                <td width=\"27\" nowrap></td>
                                <td width=\"11\" nowrap></td>
                                <td width=\"33\" nowrap></td>
                                <td width=\"31\" nowrap></td>
                                <td></td>
                            </tr>
                        </table>
                      </td> 
               </tr>
               </td>
            </table>
            </td>
            </tr>
            </table>
         </td>
        </tr>
        </table> 
    ";
    
    
    return $Output;                                                            // Closing extra border-table
}  

function getPercent($killpercentage, $totalkills)
{
  if($totalkills == "")
    return "0";
  elseif($killpercentage == "")
    return "0";
  else
    return $killpercentage;
}

// This function prints a table showing a players achievements regarding all bodyparts,
// both in hitting and being hit
function player_bodyparts($playerid, $dbID = false)
{

  $link = baselink();
    
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $b; // bodypart names from config
  
echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Hitzones</td></tr><tr><td>
<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
  <tr class=\"outertable\">
    <td>Bodypart</td>
    <td colspan=\"2\" align=\"center\">".$text["kills"]."</td>
    <td colspan=\"2\" align=\"center\">".$text["deaths"]."</td>
<!--    <td colspan=\"2\" align=\"center\">".$text["suicides"]."</td> -->
<!--    <td colspan=\"2\" align=\"center\">".$text["teamkills"]."</td> -->
<!--    <td colspan=\"2\" align=\"center\">".$text["teamdeaths"]."</td> -->
  ";

  if($dbID == false)
  {
  $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
            FROM ${t['players']}
            WHERE id = $playerid AND hide = 0
            LIMIT 1";
  }
  else 
  {
  $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
            FROM ${t['players']}
            WHERE client_id = $playerid AND hide = 0
            LIMIT 1";
  }
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  
  $playerid =  $row['id'];
  $kills = $row['kills'];
  $deaths = $row['deaths'];
  $suicides = $row['suicides'];
  $teamkills = $row['teamkills'];
  $teamdeaths = $row['teamdeaths'];
  
  $query = "SELECT ${t['bodyparts']}.name, ${t['playerbody']}.kills, 
                ${t['playerbody']}.deaths, ${t['playerbody']}.suicides, 
                ${t['playerbody']}.teamkills, ${t['playerbody']}.teamdeaths
            FROM ${t['bodyparts']}, ${t['playerbody']}
            WHERE ${t['playerbody']}.player_id = $playerid
                AND ${t['bodyparts']}.id = ${t['playerbody']}.bodypart_id
            ORDER BY ${t['playerbody']}.kills DESC";
  

  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result))
  {
  if ($separatorline == 1)
    echo "<tr><td colspan=\"11\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr>";
    if (isset($b[$row['name']]))
      echo "  <td>".$b[ $row['name'] ]."</td>";
    else
      echo "  <td>${row['name']}</td>";
    echo "  <td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
    if ( ($kills > 0) && ($row['kills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['kills']/$kills);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "  <td align=\"center\">", $row['deaths'] ? $row['deaths'] : "", "</td>";
    if ( ($deaths > 0) && ($row['deaths'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['deaths']/$deaths);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "</tr>";
  }
  echo "</table>";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["watchcover"]."";
  echo "</td></tr></table>";                                                                // Closing extra border-table
}


// This function shows a players achievements in the maps he's played
function player_maps_s($playerid, $dbID = false)
{
  $Output = "";
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $text;
    
  global $t; // table names from config
  global $m; // map names from config
    //<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Map achievements</td></tr><tr><td>
  $Output = "
    <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td>
        <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
            <tr class=\"outertable\">
                <td align=\"left\">".$text["map"]."</td>
                <td align=\"center\">".$text["rounds"]."</td>
                <td colspan=\"2\" align=\"center\">".$text["kills"]."</td>
                <td colspan=\"2\" align=\"center\">".$text["deaths"]."</td>
                <td colspan=\"2\" align=\"center\">".$text["suicides"]."</td>
                <td colspan=\"2\" align=\"center\">".$text["teamkills"]."</td>
                <td colspan=\"2\" align=\"center\">".$text["teamdeaths"]."</td>
                ";

    if($dbID == false)
    {
  $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
            FROM ${t['players']}
            WHERE id = $playerid AND hide = 0
            LIMIT 1";
    }
    else 
    {
  $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
            FROM ${t['players']}
            WHERE client_id = $playerid AND hide = 0
            LIMIT 1";
}
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  if ($row == false) 
      return;  // no result given: does not exist or is hidden. Anyway, return whence thou camest!
  
  $playerid =  $row['id'];
  $kills = $row['kills'];
  $deaths = $row['deaths'];
  $suicides = $row['suicides'];
  $teamkills = $row['teamkills'];
  $teamdeaths = $row['teamdeaths'];
  
  $query = "SELECT ${t['maps']}.name, ${t['maps']}.id, ${t['playermaps']}.kills, 
                ${t['playermaps']}.deaths, ${t['playermaps']}.suicides, 
                ${t['playermaps']}.teamkills, ${t['playermaps']}.teamdeaths,
                ${t['playermaps']}.rounds
            FROM ${t['maps']}, ${t['playermaps']}
            WHERE ${t['playermaps']}.player_id = $playerid
                AND ${t['maps']}.id = ${t['playermaps']}.map_id
            ORDER BY ${t['playermaps']}.kills DESC";
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result))
  {
  if ($separatorline == 1)
    $Output .= "<tr><td colspan=\"12\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>
    ";  // This draws a one pixel line between rows
    $Output .= "<tr>
    ";

    if (isset($m[$row['name']]))
    {
      $Output .= "<td align=\"left\"><a href=\"$link?func=map&mapid=${row['id']}\">".$m[ $row['name'] ]."</a></td>
      ";
    }
    else
    {
      $Output .= "<td align=\"left\"><a href=\"$link?func=map&mapid=${row['id']}\">${row['name']}</a></td>
      ";
    }

    $Output .= "  <td align=\"center\">";
    if($row['rounds'] == "")
    {
      $Output .= "</td>
      ";    
    }
    else
    {
      $Output .= $row['rounds']."</td>
      "; 
    }
    
    $Output .= "  <td align=\"center\">";
    if($row['kills'] == "")
    {
      $Output .= "</td>
      ";    
    }
    else
    {
      $Output .= $row['kills']."</td>
      "; 
    }
        
    if ( ($kills > 0) && ($row['kills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['kills']/$kills);
      $Output .= "  <td align=\"center\" class=\"tiny\">($temp%)</td>
      ";   
    }
    else
    {
     $Output .= "  <td></td>
     ";
    }

    $Output .= "  <td align=\"center\">";
    if($row['deaths'] == "")
    {
      $Output .= "</td>
      ";    
    }
    else
    {
      $Output .= $row['deaths']."</td>
      "; 
    }
     
    if ( ($deaths > 0) && ($row['deaths'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['deaths']/$deaths);
      $Output .= "  <td align=\"center\" class=\"tiny\">($temp%)</td>
      ";   
    }
    else
    {
      $Output .= "  <td></td>
      ";
    }
    
    $Output .= "  <td align=\"center\">";
    if($row['suicides'] == "")
    {
      $Output .= "</td>
      ";    
    }
    else
    {
      $Output .= $row['suicides']."</td>
      "; 
    }
    
    if ( ($suicides > 0) && ( $row['suicides'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['suicides']/$suicides);
      $Output .=  "  <td align=\"center\" class=\"tiny\">($temp%)</td>
      ";   
    }
    else
    {
      $Output .= "  <td></td>
      ";
    }
    
    $Output .= "  <td align=\"center\">";
    if($row['teamkills'] == "")
    {
      $Output .= "</td>
      ";    
    }
    else
    {
      $Output .= $row['teamkills']."</td>
      "; 
    }
    
    if ( ($teamkills > 0) && ($row['teamkills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['teamkills']/$teamkills);
      $Output .= "  <td align=\"center\" class=\"tiny\">($temp%)</td>
      ";   
    }
    else
    {
      $Output .= "  <td></td>
      ";
    }
    $Output .= "  <td align=\"center\">";
    if($row['teamdeaths'] == "")
    {
      $Output .= "</td>
      ";    
    }
    else
    {
      $Output .= $row['teamdeaths']."</td>
      "; 
    }
    
    if ( ($teamdeaths > 0) && ( $row['teamdeaths'] > 0 ) )
    {
      $temp = sprintf("%.2f", 100*$row['teamdeaths']/$teamdeaths);
      $Output .=  "  <td align=\"center\" class=\"tiny\">($temp%)</td>
      ";   
    }
    else
    {
      $Output .=  "  <td></td>
      ";
    }
    $Output .=  "</tr>
    ";
  }
  $Output .=  "</table>";
  $Output .=  "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["clickmapname"]."";
  $Output .=  "</td></tr></table>";       
  return $Output;                                                         // Closing extra border-table
}

// This function shows a players achievements in the maps he's played
function player_maps($playerid, $dbID = false)
{

  $link = baselink();
  global $coddb;
  global $separatorline;
  global $text;
    
  global $t; // table names from config
  global $m; // bodypart names from config
  
echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">Map achievements</td></tr><tr><td>
      <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
        <tr class=\"outertable\">
          <td>Map</td>
          <td>Rounds</td>
          <td colspan=\"2\" align=\"center\">".$text["kills"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["deaths"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["suicides"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["teamkills"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["teamdeaths"]."</td>
    ";
  if($dbID == false)
  {
  $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
            FROM ${t['players']}
            WHERE id = $playerid AND hide = 0
            LIMIT 1";
  }
  else 
  {
  $query = "SELECT id, kills, deaths, suicides, teamkills, teamdeaths 
            FROM ${t['players']}
            WHERE client_id = $playerid AND hide = 0
            LIMIT 1";
}
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  if ($row == false) 
    return;  // no result given: does not exist or is hidden. Anyway, return whence thou camest!
  
  $playerid =  $row['id'];
  $kills = $row['kills'];
  $deaths = $row['deaths'];
  $suicides = $row['suicides'];
  $teamkills = $row['teamkills'];
  $teamdeaths = $row['teamdeaths'];
  
  $query = "SELECT ${t['maps']}.name, ${t['maps']}.id, ${t['playermaps']}.kills, 
                ${t['playermaps']}.deaths, ${t['playermaps']}.suicides, 
                ${t['playermaps']}.teamkills, ${t['playermaps']}.teamdeaths,
                ${t['playermaps']}.rounds
            FROM ${t['maps']}, ${t['playermaps']}
            WHERE ${t['playermaps']}.player_id = $playerid
                AND ${t['maps']}.id = ${t['playermaps']}.map_id
            ORDER BY ${t['playermaps']}.kills DESC";
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result))
  {
  if ($separatorline == 1)
    echo "<tr><td colspan=\"12\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr>";

    if (isset($m[$row['name']]))
      echo "<td><a href=\"$link?func=map&mapid=${row['id']}\">".$m[ $row['name'] ]."</a></td>";
    else
      echo "<td><a href=\"$link?func=map&mapid=${row['id']}\">${row['name']}</a></td>";

    echo "  <td align=\"center\">", $row['rounds'] ? $row['rounds'] : "", "</td>";
    echo "  <td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
    if ( ($kills > 0) && ($row['kills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['kills']/$kills);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "  <td align=\"center\">", $row['deaths'] ? $row['deaths'] : "", "</td>";
    if ( ($deaths > 0) && ($row['deaths'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['deaths']/$deaths);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "  <td align=\"center\">", $row['suicides'] ? $row['suicides'] : "", "</td>";
    if ( ($suicides > 0) && ( $row['suicides'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['suicides']/$suicides);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>    ";
    echo "  <td align=\"center\">", $row['teamkills'] ? $row['teamkills'] : "", "</td>";
    if ( ($teamkills > 0) && ($row['teamkills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['teamkills']/$teamkills);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "  <td align=\"center\">", $row['teamdeaths'] ? $row['teamdeaths'] : "", "</td>";
    if ( ($teamdeaths > 0) && ( $row['teamdeaths'] > 0 ) )
    {
      $temp = sprintf("%.2f", 100*$row['teamdeaths']/$teamdeaths);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "</tr>";
  }
  echo "</table>";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["clickmapname"]."";
  echo "</td></tr></table>";                                                                // Closing extra border-table
}

// This functions shows who a player has hit, and whom he was hit by
function player_opponents_s($playerid, $dbID = false)
{
  $Output = "";  
  $link = baselink();

  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $enemies_max;
  global $playername;
  global $currentconfignumber;
  global $text;

  $Output = "
  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td>
    <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
        <tr class=\"outertable\">
            <td align=\"left\">".$text["worstenemies"]."</td>
            <td width=\"75\" colspan=\"2\" align=\"center\">".$text["yourdeath"]."</td>
            <td width=\"75\" colspan=\"2\" align=\"center\">".$text["yourkill"]."</td>
            <td width=\"150\" align=\"center\">".$text["yourkdratio"]."</td>
            ";
    
    if($dbID == false)
    {
      $query = "SELECT id, kills, deaths 
                FROM ${t['players']}
                WHERE id = $playerid AND hide = 0
                LIMIT 1";
    }
    else 
    {
      $query = "SELECT id, kills, deaths 
                FROM ${t['players']}
                WHERE client_id = $playerid AND hide = 0
                LIMIT 1";        
    }
 
    $result = $coddb->sql_query($query);
    $row = $coddb->sql_fetchrow($result);
    
    if ($row == false) 
      return;  // no result given: does not exist or is hidden. Anyway, return whence thou camest!
        
    $playerid =  $row['id'];
 
    $kills = $row['kills'];
    $deaths = $row['deaths'];
  
    $query = "SELECT ${t['opponents']}.target_id, ${t['opponents']}.kills,
                     ${t['opponents']}.retals, ${t['players']}.fixed_name,
                     ${t['b3_clients']}.name
              FROM ${t['opponents']},
                   ${t['players']},
                   ${t['b3_clients']}
              WHERE ${t['opponents']}.killer_id = $playerid
                   AND ${t['players']}.id = ${t['opponents']}.target_id
                   AND ${t['b3_clients']}.id = ${t['players']}.client_id
                   AND ${t['players']}.hide = 0 
              ORDER BY ${t['opponents']}.retals DESC
              LIMIT $enemies_max";

  $result = $coddb->sql_query($query);

  while ($row = $coddb->sql_fetchrow($result))
  {
    if ($separatorline == 1)
      {
      $Output .= "<tr><td colspan=\"6\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>
      ";  // This draws a one pixel line between rows
      }
    $Output .= "<tr>
    ";
    $Output .= "<td align=\"left\"><a href=\"$link?func=player&playerid=${row['target_id']}&config=${currentconfignumber}\">
    ";//, $row['fixed_name'] ? $row['fixed_name'] : $row['name'], "</a></td>
    
    $Output .= htmlspecialchars(utf2iso($row['fixed_name'] ? $row['fixed_name'] : $row['name']));
    $tempname = htmlspecialchars(utf2iso($row['fixed_name'] ? $row['fixed_name'] : $row['name']));
      
    $Output .= " </a></td>";
    $Output .= "  <td align=\"center\" title=\"$tempname killed you ${row['retals']} times.\">${row['retals']}</td>
    ";
    if ( ($deaths > 0) && ($row['retals'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['retals']/$deaths);
      $Output .= "  <td align=\"center\" class=\"tiny\" title=\"$tempname is responsible for $temp% of your total deaths.\">($temp%)</td>
      ";   
    }
    else
    {
      $Output .= "  <td></td> 
      ";
    }
    $Output .= "   <td align=\"center\" title=\"You killed $tempname ${row['kills']} times.\">${row['kills']}</td>
    ";
    if ( ($kills > 0) && ($row['kills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['kills']/$kills);
      $Output .= "  <td align=\"center\" class=\"tiny\" title=\"$tempname makes $temp% of your total kills.\">($temp%)</td>
      ";   
    }
    else
    {
      $Output .= "  <td></td>
      ";
    }
    if ( $row['retals'] > 0)
    {
      $temp = sprintf("%.2f", $row['kills']/$row['retals']);
      if ($temp < 1) 
      {
        $Output .= "  <td class=\"attention\" align=\"center\" title=\"$tempname seems to be better than you!\">$temp</td>
        ";
      }
      else
      {
        $Output .= "  <td align=\"center\" title=\"You have a good K/D ratio on $tempname!\">$temp</td>
        ";
      } 
    }
    else
    {
      $Output .= "  <td></td>
      ";
    }
      
    $Output .= "</tr>
    ";
  }
  
  $Output .= "</table>
  ";
  $Output .= "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["whosyourenemy"]."
  ";
  $Output .= "</td></tr></table>
  ";     // Closing extra border-table
  
  return $Output;
}

// This functions shows who a player has hit, and whom he was hit by
function player_opponents($playerid, $dbID = false)
{

  $link = baselink();
  
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $enemies_max;
  global $currentconfignumber;
  global $text;

  echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["worstenemies"]."</td></tr><tr><td>
        <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
          <tr class=\"outertable\">
            <td>Player</td>
            <td colspan=\"2\" align=\"center\">".$text["kills"]."</td>
            <td colspan=\"2\" align=\"center\">".$text["deaths"]."</td>
            <td align=\"center\">".$text["ratio"]."</td>
  ";

  if($dbID == false)
  {
  $query = "SELECT id, kills, deaths 
            FROM ${t['players']}
            WHERE id = $playerid AND hide = 0
            LIMIT 1";
  }
  else 
  {
  $query = "SELECT id, kills, deaths 
            FROM ${t['players']}
            WHERE client_id = $playerid AND hide = 0
            LIMIT 1";   
}
 
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  if ($row == false) return;  // no result given: does not exist or is hidden. Anyway, return whence thou camest!
  $playerid =  $row['id'];
 
  $kills = $row['kills'];
  $deaths = $row['deaths'];
  
  $query = "SELECT ${t['opponents']}.target_id, ${t['opponents']}.kills,
                   ${t['opponents']}.retals, ${t['players']}.fixed_name,
                   ${t['b3_clients']}.name
            FROM ${t['opponents']},
                 ${t['players']},
                 ${t['b3_clients']}
            WHERE ${t['opponents']}.killer_id = $playerid
                 AND ${t['players']}.id = ${t['opponents']}.target_id
                 AND ${t['b3_clients']}.id = ${t['players']}.client_id
                 AND ${t['players']}.hide = 0 
            ORDER BY ${t['opponents']}.kills DESC
            LIMIT $enemies_max";

  $result = $coddb->sql_query($query);

  while ($row = $coddb->sql_fetchrow($result))
  {
    if ($separatorline == 1)
      echo "<tr><td colspan=\"6\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
    echo "<tr>";
    echo "<td><a href=\"$link?func=player&playerid=${row['target_id']}&config=${currentconfignumber}\">", htmlspecialchars(utf2iso($row['fixed_name'] ? $row['fixed_name'] : $row['name'])), "</a></td>";
    echo "  <td align=\"center\">${row['kills']}</td>";
    if ( ($kills > 0) && ($row['kills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['kills']/$kills);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "  <td align=\"center\">${row['retals']}</td>";
    if ( ($deaths > 0) && ($row['retals'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['retals']/$deaths);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    if ( $row['retals'] > 0)
    {
      $temp = sprintf("%.2f", $row['kills']/$row['retals']);
      echo "  <td align=\"center\">$temp</td>"; 
    }
    else
      echo "  <td></td>";
      
    echo "</tr>";
  }
  
  echo "</table>";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["whosyourenemy"]."";
  echo "</td></tr></table>";     // Closing extra border-table
}

//*****************************************************************************
//
//  Following are all weapon specific functions
//
//*****************************************************************************


// This function shows a summary of a weapons stats
function weapon_short($weaponid)
{

  $link = baselink();
    
  global $coddb;
  global $game;
  global $t; // table names from config
  global $w; // weapon aliases
  global $text;
 
  $query = "SELECT * 
            FROM ${t['weapons']}
            WHERE id = $weaponid
            LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);

  echo "<table class=\"outertable\" width=\"100%\">";
  if (isset($w[$row['name']]))
    echo "  <tr><td colspan=\"3\" align=\"center\" valign=\"top\">".$w[ $row['name'] ]."</td></tr><tr class=\"innertable\"><td valign=\"top\" width=\"150\">";
  else
    echo "  <tr><td colspan=\"3\" align=\"center\" valign=\"top\">${row['name']}</td></tr><tr class=\"innertable\"><td valign=\"top\" width=\"150\">";
  echo "    <table width=\"150\">";
  echo "      <tr><td class=\"innertable\">".$text["totkill"]."</td><td align=\"center\" class=\"innertable\">${row['kills']}</td></tr>";
  echo "      <tr><td class=\"innertable\">".$text["totteamkill"]."</td><td align=\"center\" class=\"innertable\">${row['teamkills']}</td></tr>";
  echo "      <tr><td class=\"innertable\">".$text["totsuicide"]."</td><td align=\"center\" class=\"innertable\">${row['suicides']}</td></tr>";
  echo "    </table>";
  echo "  </td><td width=\"50\" valign=\"top\">";
  // catch cod1, coduo and cod2 in one imagefolder
  if ($game == "cod1" && !file_exists("images/weapons/cod1/"))
    $gamename = "cod2";
  elseif ($game == "coduo" && !file_exists("images/weapons/coduo/"))
    $gamename = "cod2";
  else
    $gamename = $game;
  get_pic("images/weapons/$gamename/normal/${row['name']}");
  echo "  </td><td valign=\"top\" class=\"tiny\">";
  get_desc("weapon/${row['name']}");
  echo "</td></tr>";
  echo "</table>";
}

// This function shows how a specific weapon was used by or against all players
function weapon_players($weaponid)
{

  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $weap_minkills;
  global $exclude_ban;
  global $currentconfignumber;
  global $text;
  
echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["playerweaponstats"]."</td></tr><tr><td>
      <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
        <tr class=\"outertable\">
          <td>".$text["player"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["kills"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["deaths"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["suicides"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["teamkills"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["teamdeaths"]."</td>
      ";

  $query = "SELECT kills, suicides, teamkills
            FROM ${t['weapons']}
            WHERE id = $weaponid
            LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  
  $kills = $row['kills'];
  //$deaths = $row['deaths'];
  $suicides = $row['suicides'];
  $teamkills = $row['teamkills'];
  //$teamdeaths = $row['teamdeaths'];
    
  $query = "SELECT ${t['b3_clients']}.name, ${t['weaponusage']}.player_id, ${t['weaponusage']}.kills, 
                ${t['weaponusage']}.deaths, ${t['weaponusage']}.suicides, 
                ${t['weaponusage']}.teamkills, ${t['weaponusage']}.teamdeaths,
                ${t['players']}.fixed_name
            FROM ${t['b3_clients']}, ${t['players']}, ${t['weaponusage']}
            WHERE ${t['weaponusage']}.weapon_id = $weaponid
                AND ${t['players']}.id = ${t['weaponusage']}.player_id
                AND ${t['b3_clients']}.id = ${t['players']}.client_id
                AND (${t['weaponusage']}.kills > $weap_minkills
                    OR ${t['weaponusage']}.suicides > $weap_minkills)
                AND ${t['players']}.hide = 0";
   
   if ($exclude_ban) {
      $query .= " AND ${t['b3_clients']}.id NOT IN (
        SELECT distinct(target.id)
        FROM ${t['b3_penalties']} as penalties, ${t['b3_clients']} as target
        WHERE (penalties.type = 'Ban' OR penalties.type = 'TempBan')
        AND inactive = 0
        AND penalties.client_id = target.id
        AND ( penalties.time_expire = -1 OR penalties.time_expire > UNIX_TIMESTAMP(NOW()) )
      )";
    }           
    
    $query .= " ORDER BY ${t['weaponusage']}.kills DESC, ${t['weaponusage']}.suicides DESC";

  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result))
  {
    if ($separatorline == 1)
      echo "<tr><td colspan=\"11\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>\n";  // This draws a one pixel line between rows
    echo "<tr>";
    echo "<td><a href=\"$link?func=player&playerid=${row['player_id']}&config=${currentconfignumber}\">", htmlspecialchars(utf2iso($row['fixed_name'] ? $row['fixed_name'] : $row['name'])), "</a></td>";
    echo "  <td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
    if ( ($kills > 0) && ($row['kills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['kills']/$kills);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "  <td align=\"center\">", $row['deaths'] ? $row['deaths'] : "", "</td>";
    if ( ($kills > 0) && ($row['deaths'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['deaths']/$kills);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "  <td align=\"center\">", $row['suicides'] ? $row['suicides'] : "", "</td>";
    if ( ($suicides > 0) && ( $row['suicides'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['suicides']/$suicides);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>    ";
    echo "  <td align=\"center\">", $row['teamkills'] ? $row['teamkills'] : "", "</td>";
    if ( ($teamkills > 0) && ( $row['teamkills'] > 0) )
    {
      $temp = sprintf("%.2f", 100*$row['teamkills']/$teamkills);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "  <td align=\"center\">", $row['teamdeaths'] ? $row['teamdeaths'] : "", "</td>";
    if ( ($teamkills > 0) && ( $row['teamdeaths'] > 0 ) )
    {
      $temp = sprintf("%.2f", 100*$row['teamdeaths']/$teamkills);
      echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
    }
    else
      echo "  <td></td>";
    echo "</tr>\n";
  }
  echo "</table>";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["minweapon"]."";
  echo "</td></tr></table>";                                                                // Closing extra border-table
}

//******************************************************************************
//
//  Following are all map specific functions
//
//******************************************************************************

// This function gives a short overview about a specific map
function map_short($mapid)
{

  $link = baselink();
     
  global $coddb;
  global $game;
  global $separatorline;
  global $t; // table names from config
  global $m; // map aliases
  global $text;

  $query = "SELECT * 
            FROM ${t['maps']}
            WHERE id = $mapid
            LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);

  echo "<table class=\"outertable\" width=\"100%\">";
  if (isset($m[$row['name']]))
    echo "  <tr><td colspan=\"3\" align=\"center\" valign=\"top\">".$m[ $row['name'] ]."</td></tr><tr class=\"innertable\"><td valign=\"top\" width=\"150\">";
  else
    echo "  <tr><td colspan=\"3\" align=\"center\" valign=\"top\">${row['name']}</td></tr><tr class=\"innertable\"><td valign=\"top\" width=\"150\">";
  echo "    <table width=\"150\">";
  echo "      <tr><td class=\"innertable\">".$text["totkill"]."</td><td align=\"center\" class=\"innertable\">${row['kills']}</td></tr>";
  echo "      <tr><td class=\"innertable\">".$text["totteamkill"]."</td><td align=\"center\" class=\"innertable\">${row['teamkills']}</td></tr>";
  echo "      <tr><td class=\"innertable\">".$text["totsuicide"]."</td><td align=\"center\" class=\"innertable\">${row['suicides']}</td></tr>";
  echo "    </table>";
  echo "  </td><td width=\"50\" valign=\"top\">";

  // catch cod1, coduo and cod2 in one imagefolder
  if ($game == "cod1" && !file_exists("images/maps/cod1/"))
    $gamename = "cod2";
  elseif ($game == "coduo" && !file_exists("images/maps/coduo/"))
    $gamename = "cod2";
  else
    $gamename = $game;
  get_pic("images/maps/$gamename/middle/${row['name']}");

  echo "  </td><td valign=\"top\" class=\"tiny\">";
  get_desc("map/${row['name']}");
  echo "  </td></tr>";
  echo "</table>";
}

// This function tells about the lives, kills & deaths of all players in a specific map
function map_players($mapid)
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $map_minkills;
  global $map_minrounds;
  global $exclude_ban;
  global $currentconfignumber;
  global $text;
  
echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">".$text["playermapstats"]."</td></tr><tr><td>
      <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"innertable\">
        <tr class=\"outertable\">
          <td>".$text["player"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["kills"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["suicides"]."</td>
          <td colspan=\"2\" align=\"center\">".$text["teamkills"]."</td>
          <td align=\"center\">".$text["rounds"]."</td>
    ";

  $query = "SELECT kills, suicides, teamkills, rounds
            FROM ${t['maps']}
            WHERE id = $mapid
            LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  
  $kills = $row['kills'];
//  $deaths = $row['deaths'];
  $suicides = $row['suicides'];
  $teamkills = $row['teamkills'];
  $rounds = $row['rounds'];
//  $teamdeaths = $row['teamdeaths'];
  
  $query = "SELECT ${t['b3_clients']}.name, ${t['playermaps']}.player_id, ${t['playermaps']}.kills, 
                ${t['playermaps']}.suicides, 
                ${t['playermaps']}.teamkills,
                ${t['playermaps']}.rounds,
                ${t['players']}.fixed_name
            FROM ${t['b3_clients']}, ${t['players']}, ${t['playermaps']}
            WHERE ${t['playermaps']}.map_id = $mapid
                AND ${t['players']}.id = ${t['playermaps']}.player_id
                AND ${t['players']}.hide = 0
                AND ${t['b3_clients']}.id = ${t['players']}.client_id
                AND ( ${t['playermaps']}.kills > $map_minkills
                     OR ${t['playermaps']}.rounds > $map_minrounds )";
                     
    if ($exclude_ban) {
      $query .= " AND ${t['b3_clients']}.id NOT IN (
        SELECT distinct(target.id)
        FROM ${t['b3_penalties']} as penalties, ${t['b3_clients']} as target
        WHERE (penalties.type = 'Ban' OR penalties.type = 'TempBan')
        AND inactive = 0
        AND penalties.client_id = target.id
        AND ( penalties.time_expire = -1 OR penalties.time_expire > UNIX_TIMESTAMP(NOW()) )
      )";
    }
    $query .= "  ORDER BY ${t['playermaps']}.kills DESC";

    $result = $coddb->sql_query($query);
    while ($row = $coddb->sql_fetchrow($result))
    {
      if ($separatorline == 1)
        echo "<tr><td colspan=\"8\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>";  // This draws a one pixel line between rows
      echo "<tr>";
      echo "<td><a href=\"$link?func=player&playerid=${row['player_id']}&config=${currentconfignumber}\">", htmlspecialchars(utf2iso($row['fixed_name'] ? $row['fixed_name'] : $row['name'])), "</a></td>";
      echo "  <td align=\"center\">", $row['kills'] ? $row['kills'] : "", "</td>";
      if ( ($kills > 0) && ($row['kills'] > 0) )
      {
        $temp = sprintf("%.2f", 100*$row['kills']/$kills);
        echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
      }
      else
        echo "  <td></td>";
      echo "  <td align=\"center\">", $row['suicides'] ? $row['suicides'] : "", "</td>";
      if ( ($suicides > 0) && ( $row['suicides'] > 0) )
      {
        $temp = sprintf("%.2f", 100*$row['suicides']/$suicides);
        echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
      }
      else
        echo "  <td></td>    ";
      echo "  <td align=\"center\">", $row['teamkills'] ? $row['teamkills'] : "", "</td>";
      if ( ($teamkills > 0) && ( $row['teamkills'] > 0) )
      {
        $temp = sprintf("%.2f", 100*$row['teamkills']/$teamkills);
        echo "  <td align=\"center\" class=\"tiny\">($temp%)</td>";   
      }
      else
        echo "  <td></td>";
      echo "  <td align=\"center\">", $row['rounds'] ? $row['rounds'] : "", "</td>";

      echo "</tr>";
    }
    echo "</table>";
    echo "</td></tr><tr><td class=\"tiny\" align =\"right\">".$text["youneedmap"]."";
    echo "</td></tr></table>";    // Closing extra border-table
}

function player_rank($playerid, $dbID)
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t; // table names from config
  global $map_minkills;
  global $map_minrounds;

  if($dbID == false)
  {
    $query = "SELECT id, kills, deaths 
              FROM ${t['players']}
              WHERE id = $playerid AND hide = 0
              LIMIT 1";
  }
  else 
  {
    $query = "SELECT id, kills, deaths 
              FROM ${t['players']}
              WHERE client_id = $playerid AND hide = 0
              LIMIT 1";        
  }
  
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  if ($row == false) return;  // no result given: does not exist or is hidden. Anyway, return whence thou camest!
    $playerid =  $row['id'];

  $kills = $row['kills'];
  $deaths = $row['deaths'];
}
?>
