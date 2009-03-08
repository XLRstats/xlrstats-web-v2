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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
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

  
  ShowMedal($text["punchy"], $text["punchykill"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_default.gif", $text["mostpunchy"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
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

  ShowMedal($text["balooney"], $text["balooneykill"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_default.gif", $text["mostbalooney"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
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

  ShowMedal($text["betty"], $text["bettykill"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_sniper.gif", $text["mostbetty"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
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

  ShowMedal($text["lazy"], $text["duckkill"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_default.gif", $text["mostlazy"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
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

  ShowMedal($text["cldweapon"], $text["knifekill"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_knives.gif", $text["mostknife"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
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

  ShowMedal($text["bashking"], $text["bashes"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_bash.gif", $text["mostbash"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
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

  ShowMedal($text["supersniper"], $text["skills"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_sniper.gif", $text["mostsniper"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
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

  ShowMedal($text["clscombat"], $text["skills"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_pistol.gif", $text["mostpistol"]);  
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

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
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

  ShowMedal($text["nadekiller"], $text["nadekill"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_nade.gif", $text["mostnade"]);  
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

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
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
  ShowMedal($text["remotebomb"], $text["c4kill"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_c4.gif", $text["mostc4"]);  
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

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
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

  ShowMedal($text["surpriselover"], $text["claymorekill"], sprintf("%.1f",$row['total_kills']), $row['id'], $name  , "xlr_pro_claymore.gif", $text["mostclaymore"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, rounds, fixed_name
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

  ShowMedal($text["notingbetr"], $text["rounds"], $row['rounds'], $row['id'], $name  , "xlr_pro_rounds.gif", $text["mostround"]);  
    
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, winstreak, kills, rounds, fixed_name
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

  ShowMedal($text["serialkiller"], $text["winstrk"], $row['winstreak'], $row['id'], $name  , "xlr_pro_killstreak.gif", $text["bestwinstrk"]);

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

  $query =   "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['playerbody']}.kills) / ${t['players']}.kills ) AS total_kills
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

  ShowMedal($text["headhunter"], $text["pheadshots"], (int)($row['total_kills']*100)."%", $row['id'],$name  , "xlr_pro_headshots.gif", $text["mosthdsht"]);
}

function ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description)
{
  $link = baselink();
  global $game;
  global $currentconfignumber;
  global $text;
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
  }

  echo "

      <td align=\"center\" width=\"150\">
      <table width=\"150\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" align=\"center\" class=\"with_border_alternate\">
      <tr><td align=\"center\" class=\"cellmenu1\"><a name=\"$Description\"><strong>$MedalName</strong></a></td></tr>
      <tr> 
        <td width=\"150\" class=\"line1\" nowrap valign=\"top\" align=\"center\">
        <B>$ArchieveName: &nbsp;$ArchValue&nbsp;</B>
        <br/><a href=\"$link?func=player&playerid=$PlayerId&config=${currentconfignumber}\" title=\"See player details\">$Nick<br/></a>
        <img src=\"$MedalSrc\" style=\"filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='$MedalSrc', sizingMethod='scale')\" width=\"128\" height=\"256\" name=\"$Description\">
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills,  (deaths / ${t['players']}.rounds) AS pdeaths, fixed_name
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

  //ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description)
  ShowMedal($text["pwned"], $text["pdeaths"], (int)($row['pdeaths']),  $row['id'] , $name  , "xlr_shame_deaths.gif", $text["target1"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills,  (teamkills / ${t['players']}.rounds) AS pteamkills , fixed_name
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

  //ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description)
  ShowMedal($text["eyeshot"], $text["pteamkil"], sprintf("%.1f",$row['pteamkills']),  $row['id'] , $name  , "xlr_shame_teamkills.gif", $text["mostteamkill"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills, (teamdeaths / ${t['players']}.rounds) AS pteamdeaths, fixed_name
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

  //ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description)
  ShowMedal($text["sendjoey"], $text["pteamdeth"], sprintf("%.1f",$row['pteamdeaths']),  $row['id'] , $name  , "xlr_shame_teamdeaths.gif", $text["mosteamdeth"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id,${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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

  ShowMedal($text["mmnades"], $text["nadedeth"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_nade.gif", $text["mostnadeth"]);  
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


  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, losestreak, kills, deaths, rounds, fixed_name
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

  ShowMedal($text["needpractice"], $text["losstrk"], abs($row['losestreak']), $row['id'], $name  , "xlr_shame_loosestreak.gif", $text["highlosstrk"]);
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


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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


  //
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal($text["punchme"], $text["punchdeath"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_knives.gif", $text["mostpunchy"]);  
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


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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


  //
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal($text["needbaloon"], $text["balonydeath"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_knives.gif", $text["mostbalondeth"]);  
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


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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


  //
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal($text["bettytarget"], $text["bettydeath"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_knives.gif", $text["mostbetydeth"]);  
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


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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


  //
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal($text["ihateducks"], $text["duckdeath"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_knives.gif", $text["mostduckdeth"]);  
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

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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
    ShowMedal($text["mechanic"], $text["vehicledeth"], $row['total_deaths'], $row['id'], $name  , "xlr_shame_vehicle_deaths.gif", $text["mostcardeath"]);  
  else
    ShowMedal($text["mechanic"], $text["vehicledeth"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_vehicle_deaths.gif", $text["mostcardeath"]);  
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


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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


  //
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal($text["shaveme"], $text["knifedeath"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_knives.gif", $text["mostknifedeth"]);  
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


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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
  //
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal($text["hitme"], $text["bashdeath"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_bash.gif", $text["mostbashdeth"]);  
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


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
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
  //
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal($text["targtpract"], $text["sniperdeath"], sprintf("%.1f",$row['total_deaths']), $row['id'], $name  , "xlr_shame_sniper.gif", $text["mostsniped"]);  
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

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.suicides) / ${t['players']}.rounds) AS total_suicides
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

  ShowMedal($text["accidenthero"], $text["blindasbat"], sprintf("%.1f",$row['total_suicides']), $row['id'], $name  , "xlr_shame_blind.gif", $text["mostaccdeath"]);  
}
?>
