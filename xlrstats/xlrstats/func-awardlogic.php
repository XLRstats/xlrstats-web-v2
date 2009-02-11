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
  
  $nr_awards = intval($main_width / 160); 

  pro_medals_begin();
  shuffle($pro_medals);
  foreach(array_slice($pro_medals, 0, $nr_awards) as $m)
    eval($m.";");
  unset($m);
  pro_medals_end();
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ${t['weaponusage']}.kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id IN $wp_punchy)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER BY ${t['weaponusage']}.kills DESC
          LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal("Punchy fan", "Punchy kills", $row['kills'], $row['id'], $name  , "xlr_pro_default.gif", "Most Punchy kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ${t['weaponusage']}.kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id IN $wp_ballooney)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER BY ${t['weaponusage']}.kills DESC
          LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal("Ballooney Pitcher", "Ballooney kills", $row['kills'], $row['id'], $name  , "xlr_pro_default.gif", "Most Ballooney kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ${t['weaponusage']}.kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id IN $wp_betty)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER BY ${t['weaponusage']}.kills DESC
          LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal("Betty SharpShooter", "Betty kills", $row['kills'], $row['id'], $name  , "xlr_pro_sniper.gif", "Most Betty kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ${t['weaponusage']}.kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id IN $wp_killerducks)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER BY ${t['weaponusage']}.kills DESC
          LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal("Lazy Larry", "Killer Duck kills", $row['kills'], $row['id'], $name  , "xlr_pro_default.gif", "Most Killer Ducks kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ${t['weaponusage']}.kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id IN $wp_knives)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER BY ${t['weaponusage']}.kills DESC
          LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal("Cold weapon fan", "Knife kills", $row['kills'], $row['id'], $name  , "xlr_pro_knives.gif", "Most knife kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ${t['weaponusage']}.kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id IN $wp_bashes)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER BY ${t['weaponusage']}.kills DESC
          LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal("Bash King", "Bashes", $row['kills'], $row['id'], $name  , "xlr_pro_bash.gif", "Most bash kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ${t['weaponusage']}.kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id IN $wp_snipers)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER BY ${t['weaponusage']}.kills DESC
          LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal("Super Sniper", "Kills", $row['kills'], $row['id'], $name  , "xlr_pro_sniper.gif", "Most sniper kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ${t['weaponusage']}.kills
          FROM ${t['weaponusage']}
          JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
          JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
          WHERE (${t['weaponusage']}.weapon_id IN $wp_pistols)
          AND ((${t['players']}.kills > $minkills)
          OR (${t['players']}.rounds > $minrounds))
          AND (${t['players']}.hide = 0)
          AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
          ORDER BY ${t['weaponusage']}.kills DESC
          LIMIT 1 ";


  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  ShowMedal("Close Combat Pistol Hero", "Kills", $row['kills'], $row['id'], $name  , "xlr_pro_pistol.gif", "Most pistol kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, SUM(${t['weaponusage']}.kills) AS total_kills
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

  ShowMedal("Nade killer", "Nade kills", $row['total_kills'], $row['id'], $name  , "xlr_pro_nade.gif", "Most nade kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, SUM(${t['weaponusage']}.kills) AS total_kills
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
  ShowMedal("Remote bomb fan", "C4 Kills", $row['total_kills'], $row['id'], $name  , "xlr_pro_c4.gif", "Most C4 kills");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, SUM(${t['weaponusage']}.kills) AS total_kills
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

  ShowMedal("Surprise lover", "Claymore kills", $row['total_kills'], $row['id'], $name  , "xlr_pro_claymore.gif", "Most Claymore kills");  
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

  ShowMedal("Nothing better to do", "Rounds", $row['rounds'], $row['id'], $name  , "xlr_pro_rounds.gif", "Most rounds played");  
    
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

  ShowMedal("Serial Killer", "Win streak", $row['winstreak'], $row['id'], $name  , "xlr_pro_killstreak.gif", "Best winstreak");

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

  $current_time = gmdate("U");

  $query =   "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, SUM(${t['playerbody']}.kills) AS total_kills
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

  ShowMedal("Head hunter", "Headshots", $row['total_kills'], $row['id'],$name  , "xlr_pro_headshots.gif", "Most headshots");
}

function ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description)
{
  $link = baselink();
  global $game;
  global $currentconfignumber;
  // do we have game specific medals?
  if (file_exists("./images/medals/$game/"))
    $MedalSrc = "./images/medals/$game/$MedalPicture";
  else
    $MedalSrc = "./images/medals/$MedalPicture";

  if ($ArchValue == 0 || $ArchValue == "" || $ArchValue == false)
  {
    $PlayerId = "";
    $ArchValue = "Award Still Available ::";
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
  
  $nr_awards = intval($main_width / 160); 

  pro_medals_begin("Our shame award winners", "shame Medals");
  shuffle($shame_medals);
  foreach(array_slice($shame_medals, 0, $nr_awards) as $m)
    eval($m.";");
  unset($m);

  pro_medals_end("Do not try to be on top in here ;)"); 
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
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills,  deaths, fixed_name
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      ORDER BY deaths DESC  
      LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);

  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  //ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description)
  ShowMedal("Got pwned!", "Deaths", $row['deaths'],  $row['id'] , $name  , "xlr_shame_deaths.gif", "Target no. 1");  
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
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills,  teamkills, fixed_name
      FROM ${t['b3_clients']}, ${t['players']}
      WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)
      AND ((${t['players']}.kills > $minkills)
      OR (${t['players']}.rounds > $minrounds))
      AND (${t['players']}.hide = 0)
      AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)
      ORDER BY teamkills DESC  
      LIMIT 1";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);

  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];

  //ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description)
  ShowMedal("Eyes Wide Shut!", "Teamkills", $row['teamkills'],  $row['id'] , $name  , "xlr_shame_teamkills.gif", "Most Teamkills");  
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
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, kills,  teamdeaths, fixed_name
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
  ShowMedal("Send Joey, he'll do anything!", "Teamdeaths", $row['teamdeaths'],  $row['id'] , $name  , "xlr_shame_teamdeaths.gif", "Most Teamdeaths");  
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

  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id,${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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

  ShowMedal("Mmmm nades!", "Nade deaths", $row['total_deaths'], $row['id'], $name  , "xlr_shame_nade.gif", "Most nade deaths");  
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

  ShowMedal("Needs some practice", "Lose streak", abs($row['losestreak']), $row['id'], $name  , "xlr_shame_loosestreak.gif", "Higher losestreak");
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
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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

  ShowMedal("Punch me Now!", "Punchy deaths", $row['total_deaths'], $row['id'], $name  , "xlr_shame_knives.gif", "Most Punchy deaths");  
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
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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

  ShowMedal("Need Balloons!", "Ballooney deaths", $row['total_deaths'], $row['id'], $name  , "xlr_shame_knives.gif", "Most Ballooney deaths");  
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
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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

  ShowMedal("Bettys Target", "Betty deaths", $row['total_deaths'], $row['id'], $name  , "xlr_shame_knives.gif", "Most Betty deaths");  
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
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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

  ShowMedal("I hate Ducks!", "Killerducks deaths", $row['total_deaths'], $row['id'], $name  , "xlr_shame_knives.gif", "Most Killerducks deaths");  
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
  $current_time = gmdate("U");

  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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
    ShowMedal("Mechanic", "Deaths by vehicle", $row['total_deaths'], $row['id'], $name  , "xlr_shame_vehicle_deaths.gif", "Most deaths by exploding vehicle");  
  else
    ShowMedal("Mechanic", "Deaths by vehicle", $row['total_deaths'], $row['id'], $name  , "xlr_shame_vehicle_deaths.gif", "Most deaths by exploding vehicle");  
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
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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

  ShowMedal("Shave me please!", "Knife deaths", $row['total_deaths'], $row['id'], $name  , "xlr_shame_knives.gif", "Most knife deaths");  
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
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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

  ShowMedal("Hit me please!", "Bash deaths", $row['total_deaths'], $row['id'], $name  , "xlr_shame_bash.gif", "Most bash deaths");  
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
  $current_time = gmdate("U");


  $query = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.deaths) AS total_deaths
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

  ShowMedal("Target Practice!", "Sniper deaths", $row['total_deaths'], $row['id'], $name  , "xlr_shame_sniper.gif", "Most sniper deaths");  
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

  $current_time = gmdate("U");

  $query = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, SUM(${t['weaponusage']}.suicides) AS total_suicides
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

  ShowMedal("Accidental Hero", "Blind as a Bat", $row['total_suicides'], $row['id'], $name  , "xlr_shame_blind.gif", "Most accidental deaths");  
}
?>
