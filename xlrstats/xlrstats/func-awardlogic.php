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

function pro_medals_begin($Title = "Our award winners", $AwardName = "pr0 Medals")
{
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">$Title</td></tr><tr><td>";
  echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"innertable\">";
  echo "  <tr><td align=\"center\" class=\"title\"><a name=\"pr0 Medals\"><B>$AwardName</B></a></td></tr>";
  echo "</table>";
  echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\ class=\"with_border\">";
  echo "  <tr>";
}

function pro_medals_end($EndingText = "Top these players to win an award!")
{
  echo "

    </tr>
    </table>
    <br>
  ";
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\">$EndingText";
  echo "</td></tr></table>";  
}

function global_awards()
{
  $link = baselink();
  global $pro_medals;
  global $main_width;
  global $text;
  
  $nr_awards = intval($main_width / 160); 

  pro_medals_begin($text["winner"], $text["pro"]);
  shuffle($pro_medals);
  foreach(array_slice($pro_medals, 0, $nr_awards) as $m)
    eval($m.";");
  unset($m);
  pro_medals_end($text["topthisplayers"]);
}

function country_flag($ip) 
{
  global $geoip_path;
  
  if (file_exists($geoip_path."GeoIP.dat"))
  {
    $geocountry = $geoip_path."GeoIP.dat";
    $gi = geoip_open($geocountry,GEOIP_STANDARD);
    $countryid = strtolower (geoip_country_code_by_addr($gi, $ip));
    $country = geoip_country_name_by_addr($gi, $ip);
    if ( !is_null($countryid) and $countryid != "") 
      $flag = "<img src=\"images/flags/".$countryid.".gif\" title=\"".$country."\" alt=\"".$country."\">";
    else 
      $flag = "<img width=\"16\" height=\"11\" src=\"images/spacer.gif\" title=\"".$country."\" alt=\"".$country."\">"; 

    geoip_close($gi);
    return $flag;
  }
}

function pro_medal_punchy_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_punchy;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_punchy)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
  
  $fname = __FUNCTION__;
  
  ShowMedal($text["punchy"], $text["punchykill"], $score, $playerid, $name, "xlr_pro_default.gif", $text["mostpunchy"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_ballooney_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_ballooney;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_ballooney)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["balooney"], $text["balooneykill"], $score, $playerid, $name, "xlr_pro_default.gif", $text["mostbalooney"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_betty_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_betty;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_betty)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["betty"], $text["bettykill"], $score, $playerid, $name, "xlr_pro_sniper.gif", $text["mostbetty"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_killerducks_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_killerducks;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_killerducks)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["lazy"], $text["duckkill"], $score, $playerid, $name, "xlr_pro_default.gif", $text["mostlazy"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_cold_weapon_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_knives;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_knives)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["cldweapon"], $text["knifekill"], $score, $playerid, $name, "xlr_pro_knives.gif", $text["mostknife"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_bash_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_bashes;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_bashes)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
 
  $fname = __FUNCTION__;

  ShowMedal($text["bashking"], $text["bashes"], $score, $playerid, $name, "xlr_pro_bash.gif", $text["mostbash"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_sniper_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_snipers;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_snipers)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
  
  $fname = __FUNCTION__;

  ShowMedal($text["supersniper"], $text["skills"], $score, $playerid, $name, "xlr_pro_sniper.gif", $text["mostsniper"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_pistol_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_pistols;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_pistols)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];

  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
  
  $fname = __FUNCTION__;

  ShowMedal($text["clscombat"], $text["skills"], $score, $playerid, $name, "xlr_pro_pistol.gif", $text["mostpistol"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_nade_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_nades;
  global $text;

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_nades)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
  
  $fname = __FUNCTION__;

  ShowMedal($text["nadekiller"], $text["nadekill"], $score, $playerid, $name  , "xlr_pro_nade.gif", $text["mostnade"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_remote_bomb_fan()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_bomb;
  global $text;

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id = $wp_bomb)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
  
  $fname = __FUNCTION__;
  
  ShowMedal($text["remotebomb"], $text["c4kill"], $score, $playerid, $name, "xlr_pro_c4.gif", $text["mostc4"], $players, $scores, $fname, $playerids, $flags);  
}   

function pro_medal_surprise_lover()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_claymore;
  global $text;

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id = $wp_claymore)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          GROUP BY ${t['players']}.id
          ORDER BY total_kills DESC
          LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_kills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_kills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["surpriselover"], $text["claymorekill"], $score, $playerid, $name, "xlr_pro_claymore.gif", $text["mostclaymore"], $players, $scores, $fname, $playerids, $flags);  
}

function pro_medal_nothing_better_to_do()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, rounds, fixed_name
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      ORDER BY rounds DESC
      LIMIT 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);     
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = $row['rounds'];
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = $row['rounds'];
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
  
  $fname = __FUNCTION__;

  ShowMedal($text["notingbetr"], $text["rounds"], $score, $playerid, $name  , "xlr_pro_rounds.gif", $text["mostround"], $players, $scores, $fname, $playerids, $flags);  
    
}

function pro_medal_serial_killer()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, winstreak, kills, rounds, fixed_name
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      ORDER BY winstreak DESC, rounds ASC
      LIMIT 1";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = $row['winstreak'];
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = $row['winstreak'];
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
 
  $fname = __FUNCTION__;

  ShowMedal($text["serialkiller"], $text["winstrk"], $score, $playerid, $name, "xlr_pro_killstreak.gif", $text["bestwinstrk"], $players, $scores, $fname, $playerids, $flags);

}

function pro_medal_head_hunter()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $bp_head;
  global $text;

  $current_time = gmdate("U");

  $query =   "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['playerbody']}.kills) / ${t['players']}.kills ) AS total_kills
      FROM ${t['playerbody']}
      JOIN ${t['players']} ON ${t['playerbody']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['playerbody']}.bodypart_id IN $bp_head)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_kills DESC
      LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = (int)($row['total_kills']*100)."%";
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = (int)($row['total_kills']*100)."%";
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["headhunter"], $text["pheadshots"], $score, $playerid, $name, "xlr_pro_headshots.gif", $text["mosthdsht"], $players, $scores, $fname, $playerids, $flags);
}

function ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description, $PlayerNames, $Scores, $FunctionName, $PlayerListIds, $Country)
{
  $link = baselink();
  global $game;
  global $currentconfignumber;
  global $text;
  global $geoip_path;
  // do we have game specific medals?
  if (file_exists("./images/medals/$game/"))
    $MedalSrc = "./images/medals/$game/$MedalPicture";
  else
    $MedalSrc = "./images/medals/$MedalPicture";

  // Clean the Nick from html code (translate)
  $Nick = htmlspecialchars(utf2iso($Nick));

  if ($ArchValue == 0 || $ArchValue == "" || $ArchValue == false)
  {
    $PlayerId = "";
    $ArchValue = $text["awardavailable"];
    $ArchieveName = ":";
    $Nick = "";
    $Scores[] = "";
    $text["owner"] = "";
    $text["score"] = ":";
  }
  
  if (!isset($_GET['fname'])) 
  {
  echo "<td align=\"center\" width=\"150\">
      <table width=\"150\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" align=\"center\" class=\"with_border_alternate\">
      <tr><td align=\"center\" class=\"cellmenu1\"><a name=\"$Description\"><strong><a href='$link?func=medal&fname=$FunctionName' title=\"".$text["seemedaldetails"]."\">$MedalName</a></strong></a></td></tr>
      <tr> 
        <td width=\"150\" class=\"line1\" nowrap valign=\"top\" align=\"center\">
        <B>$ArchieveName: &nbsp;$ArchValue&nbsp;</B>
        <br/><a href=\"$link?func=player&playerid=$PlayerId&config=${currentconfignumber}\" title=\"".$text["seeplayerdetails"]."\">$Nick<br/></a>
        <a href='$link?func=medal&fname=$FunctionName' title=\"".$text["seemedaldetails"]."\">
        <img src=\"$MedalSrc\" border=\"0\" style=\"filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='$MedalSrc', sizingMethod='scale')\" width=\"128\" height=\"256\" name=\"$Description\">
        </a>
        </td>
      </tr>
      <tr> 
        <td class=\"line0\" valign=\"top\" align=\"center\">
         $Description 
        <br><br>
        </td>
      </tr>
      </table>
      </td>
  ";
  }

  else 
  {
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\">
        <tr><td colspan=\"2\" align=\"center\">".$text["medaldetails"]."</td></tr>
        <tr><td>
          <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"innertable\">
            <tr class=\"outertable\"><td width=\"50%\"align=\"center\">$MedalName</td><td align=\"center\">".$text["topplayers"]."</td></tr>
            <tr><td>
              <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\" class=\"outertable\">
                <tr class=\"innertable\"><td width=\"150\" bgcolor=\"#EFEFEF\" rowspan=\"3\" align=\"center\"><img src=\"$MedalSrc\" style=\"filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='$MedalSrc', sizingMethod='scale')\" width=\"128\" height=\"256\" title=\"$MedalName\"></img></td>
                <td valign=\"top\">
                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"innertable\">
                    <tr><td height=\"10px\"><b><br>".$text["owner"]."<a href=\"$link?func=player&playerid=$PlayerId&config=${currentconfignumber}\" title=\"".$text["seeplayerdetails"]."\">$Nick</a></b></td></tr>
                    <tr class=\"innertable\"><td><b>".$text["score"].": $ArchValue<br><br></b></td></tr>
                    <tr><td colspan=\"1\" class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>
                    <tr class=\"innertable\"><td valign=\"top\"><b><br>".$text["medaldescription"]."<br></b>$Description</td></tr>
                  </table></td>
              </table></td>
                <td valign=\"top\">
                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"innertable\">
                    <tr><td>
                      <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"innertable\">
                        <tr class=\"outertable\">
                        <td align=\"center\">".$text["place"]."</td>
                        ".(file_exists($geoip_path."GeoIP.dat") ? "<td align=\"center\">".$text["cntry"]."</td>" : "")."
                        <td align=\"center\">".$text["player"]."</td>
                        <td align=\"center\">".$text["mdscore"]."</td></tr>
      ";

  for ($i = 0; $i<10; $i++)
  {
    if(@$Scores[$i] > 0) 
    {
      echo "<tr class=\"innertable\">
            <td width=\"50\" align=\"center\">".($i+1)."</td>
            ".(file_exists($geoip_path."GeoIP.dat") ? "<td width=\"50\" align=\"center\">".$Country[$i]."</td>" : "")."
            <td align=\"left\"><a href=\"$link?func=player&playerid=".$PlayerListIds[$i]."&config=${currentconfignumber}\" title=\"".$text["seeplayerdetails"]."\">".$PlayerNames[$i]."</td></a>
            <td align=\"center\">".$Scores[$i]."</td></tr>
            <tr><td colspan=".(file_exists($geoip_path."GeoIP.dat") ? '4' : '3')." class=\"outertable\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td></tr>
           ";
    }
  }

  echo "</table></tr></td>
        </table></td></tr>
    </table></td></tr>
    </table>
    ";
  }
}
 
function global_lame_awards()
{
  $link = baselink();
  global $shame_medals;
  global $main_width;
  global $text;
  
  $nr_awards = intval($main_width / 160); 

  pro_medals_begin($text["shameaward"], $text["shame"]);
  shuffle($shame_medals);
  foreach(array_slice($shame_medals, 0, $nr_awards) as $m)
    eval($m.";");
  unset($m);

  pro_medals_end($text["dontbetophere"]); 
}

function shame_medal_target_no_one()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $maxdays;
  global $minkills;
  global $minrounds;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, ip, kills,  (deaths / ${t['players']}.rounds) AS pdeaths, fixed_name
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      ORDER BY pdeaths DESC  
      LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = (int)($row['pdeaths']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = (int)($row['pdeaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
 
  $fname = __FUNCTION__;

  ShowMedal($text["pwned"], $text["pdeaths"], $score, $playerid, $name, "xlr_shame_deaths.gif", $text["target1"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_most_teamkills()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $maxdays;
  global $minkills;
  global $minrounds;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, ip, kills,  (teamkills / ${t['players']}.rounds) AS pteamkills , fixed_name
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      ORDER BY pteamkills DESC  
      LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['pteamkills']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['pteamkills']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["eyeshot"], $text["pteamkil"], $score, $playerid, $name, "xlr_shame_teamkills.gif", $text["mostteamkill"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_most_teamdeaths()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $maxdays;
  global $minkills;
  global $minrounds;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, ip, kills, (teamdeaths / ${t['players']}.rounds) AS pteamdeaths, fixed_name
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      ORDER BY teamdeaths DESC  
      LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['pteamdeaths']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['pteamdeaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
 
  $fname = __FUNCTION__;

  //ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description)
  ShowMedal($text["sendjoey"], $text["pteamdeth"], $score, $playerid, $name, "xlr_shame_teamdeaths.gif", $text["mosteamdeth"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_nade_magneto()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $maxdays;
  global $minkills;
  global $minrounds;
  global $wp_nades;
  global $text;

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_nades)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1 ";  

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['name'];
  $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_deaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
 
  $fname = __FUNCTION__;

  ShowMedal($text["mmnades"], $text["nadedeth"], $score, $playerid, $name, "xlr_shame_nade.gif", $text["mostnadeth"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_need_some_practice()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $text;
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, ip, losestreak, kills, deaths, rounds, fixed_name
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      ORDER BY losestreak ASC, rounds ASC
      LIMIT 1";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = abs($row['losestreak']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = abs($row['losestreak']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
 
  $fname = __FUNCTION__;

  ShowMedal($text["needpractice"], $text["losstrk"], $score, $playerid, $name , "xlr_shame_loosestreak.gif", $text["highlosstrk"], $players, $scores, $fname, $playerids, $flags);
}

function shame_medal_def_punchy()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $wp_punchy;
  global $text;
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_punchy)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];

  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_deaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["punchme"], $text["punchdeath"], $score, $playerid, $name, "xlr_shame_knives.gif", $text["mostpunchyd"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_def_ballooney()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $wp_ballooney;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_ballooney)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_deaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }
 
  $fname = __FUNCTION__;

  ShowMedal($text["needbaloon"], $text["balonydeath"], $score, $playerid, $name, "xlr_shame_knives.gif", $text["mostbalondeth"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_def_betty()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $wp_betty;
  global $text;
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_betty)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];

  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_deaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["bettytarget"], $text["bettydeath"], $score, $playerid, $name, "xlr_shame_knives.gif", $text["mostbetydeth"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_killerducks()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $wp_killerducks;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_killerducks)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_deaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["ihateducks"], $text["duckdeath"], $score, $playerid, $name, "xlr_shame_knives.gif", $text["mostduckdeth"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_fireman()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_fireman;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id = $wp_fireman)
      AND (${t['players']}.rounds > $minrounds)
      AND (${t['players']}.hide = 0)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  if ($row['total_deaths'] > 0)
    $score = $row['total_deaths'];
  else
    $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
    if ($row['total_deaths'] > 0)
      $scores[] = $row['total_deaths'];
    else
      $scores[] = sprintf("%.1f",$row['total_deaths']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["mechanic"], $text["vehicledeth"], $score, $playerid, $name, "xlr_shame_vehicle_deaths.gif", $text["mostcardeath"], $players, $scores, $fname, $playerids, $flags);    
}

function shame_medal_def_knifes()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $wp_knives;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_knives)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_deaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["shaveme"], $text["knifedeath"], $score, $playerid, $name, "xlr_shame_knives.gif", $text["mostknifedeth"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_def_bashes()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $wp_bashes;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_bashes)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_deaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }
  
  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["hitme"], $text["bashdeath"], $score, $playerid, $name, "xlr_shame_bash.gif", $text["mostbashdeth"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_sniped()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $maxdays;
  global $minrounds;
  global $wp_snipers;
  global $text;
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_snipers)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_deaths DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_deaths']);
  $playerid = $row['id'];

  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_deaths']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["targtpract"], $text["sniperdeath"], $score, $playerid, $name, "xlr_shame_sniper.gif", $text["mostsniped"], $players, $scores, $fname, $playerids, $flags);  
}

function shame_medal_careless()
{
  $link = baselink();
  global $coddb;
  global $separatorline;
  global $t;  //table names
  global $a_name;  //award names 
  global $a_desc;  //award descriptions
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $wp_accidents;
  global $text;

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.suicides) / ${t['players']}.rounds) AS total_suicides
      FROM ${t['weaponusage']}
      JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
      JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
      WHERE (${t['weaponusage']}.weapon_id IN $wp_accidents)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      GROUP BY ${t['players']}.id
      ORDER BY total_suicides DESC
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = sprintf("%.1f",$row['total_suicides']);
  $playerid = $row['id'];
  
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);
  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = sprintf("%.1f",$row['total_suicides']);
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
    }

  $fname = __FUNCTION__;

  ShowMedal($text["accidenthero"], $text["blindasbat"], $score, $playerid, $name, "xlr_shame_blind.gif", $text["mostaccdeath"], $players, $scores, $fname, $playerids, $flags);  
}

?>
