<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2010 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
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

// no direct access
defined( '_XLREXEC' ) or die( 'Restricted access' );

$allowed_funcs = array(
  'pro_medal_serial_killer',
  'pro_medal_nothing_better_to_do',
  'pro_medal_best_ratio',
  'pro_medal_most_kills',
  'pro_medal_highest_skill',
  'pro_medal_action_hero',
  'pro_medal_nade_killer',
  'pro_medal_sniper_killer',
  'pro_medal_head_hunter',
  'pro_medal_pistol_killer',
  'pro_medal_bash_killer',
  'pro_medal_remote_bomb_fan',
  'pro_medal_surprise_lover',
  'pro_medal_bouncing_betty',
  'pro_medal_firestarter',
  'pro_medal_mortal_cocktail',
  'pro_medal_cold_weapon_killer',
  'pro_medal_ballooney_killer',
  'pro_medal_betty_killer',
  'pro_medal_killerducks_killer',
  'pro_medal_punchy_killer',
  'pro_medal_dynamite',
  'shame_medal_target_no_one',
  'shame_medal_need_some_practice',
  'shame_medal_careless',
  'shame_medal_most_teamkills',
  'shame_medal_most_teamdeaths',
  'shame_medal_nade_magneto',
  'shame_medal_sniped',
  'shame_medal_def_knifes',
  'shame_medal_def_bashes',
  'shame_medal_fireman',
  'shame_medal_barrel_deaths',
  'shame_medal_def_ballooney',
  'shame_medal_def_betty',
  'shame_medal_def_punchy',
  'shame_medal_killerducks',
  'shame_medal_dynamite_deaths'
);


//------------------------------------------------------------------------------------------------------------

function medal_begin($Title = "Our award winners", $AwardName = "pr0 Medals")
{
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"outertable\"><tr><td align=\"center\">$Title</td></tr><tr><td>";
  echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"innertable\">";
  echo "  <tr><td align=\"center\" class=\"title\"><a name=\"pr0 Medals\"><B>$AwardName</B></a></td></tr>";
  echo "</table>";
  echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\ class=\"with_border\">";
  echo "  <tr>";
}

function medal_end($EndingText = "Top these players to win an award!")
{
  global $text;
  global $award_cache_time;

  echo "

    </tr>
    </table>
    <br>
  ";
  if (isset($award_cache_time)) $award_refresh_time = (int)($award_cache_time/3600) . " " . $text["hours"];
  else $award_refresh_time = $text["hour"]; 
  echo "</td></tr><tr><td class=\"tiny\" align =\"right\" title=\"".$text["awardrefresh"]." $award_refresh_time\">$EndingText";
  echo "</td></tr></table>";  
}

function global_awards()
{
  $link = baselink();
  global $pro_medals;
  global $main_width;
  global $text;
  
  $nr_awards = intval($main_width / 160); 

  medal_begin($text["winner"], $text["pro"]);
  shuffle($pro_medals);
  foreach(array_slice($pro_medals, 0, $nr_awards) as $m)
    eval($m.";");
  unset($m);
  medal_end($text["topthisplayers"]);
}

function global_lame_awards()
{
  $link = baselink();
  global $shame_medals;
  global $main_width;
  global $text;
  
  $nr_awards = intval($main_width / 160); 

  medal_begin($text["shameaward"], $text["shame"]);
  shuffle($shame_medals);
  foreach(array_slice($shame_medals, 0, $nr_awards) as $m)
    eval($m.";");
  unset($m);

  medal_end($text["dontbetophere"]); 
}

function CreateMedal($qry, $rowname, $orderby, $decimal, $unit = "")
{
  global $coddb;
  global $t;  //table names
  global $w;
  global $minkills;
  global $minrounds;
  global $maxdays;
  global $text;
  global $exclude_ban;

  $current_time = gmdate("U");
  $query = $qry;
  $query .= "AND ((${t['players']}.kills > $minkills)
        OR (${t['players']}.rounds > $minrounds))
        AND (${t['players']}.hide = 0)
        AND ($current_time - ${t['b3_clients']}.time_edit  < $maxdays*60*60*24)";

  if ($exclude_ban)
  {
    $query .= " AND ${t['b3_clients']}.id NOT IN (
        SELECT distinct(target.id)
        FROM ${t['b3_penalties']} as penalties, ${t['b3_clients']} as target
        WHERE (penalties.type = 'Ban' OR penalties.type = 'TempBan')
        AND inactive = 0
        AND penalties.client_id = target.id
        AND ( penalties.time_expire = -1 OR penalties.time_expire > UNIX_TIMESTAMP(NOW()) )
    )";
  }

  $query .= " GROUP BY ${t['players']}.id
      ORDER BY $orderby
      LIMIT 1 ";

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $name = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
  $score = (number_format((abs($row[$rowname])),$decimal)).$unit;
  $playerid = $row['id'];
  $query = str_replace("LIMIT 1", "LIMIT 0, 10", $query);
  $result = $coddb->sql_query($query);

  while ($row = $coddb->sql_fetchrow($result)) 
  {
    $names = $row['fixed_name'] ? $row['fixed_name'] : $row['name'];
    $players[] = $names;
    $scores[] = (number_format((abs($row[$rowname])),$decimal)).$unit;
    $playerids[] = $row['id'];
    $flags[] = country_flag($row['ip']);
  }

  if(!isset($playerids, $flags, $players, $scores)) 
  {
    $playerids = "";
    $flags = "";
    $players = "";
    $scores = "";
  }

  return array($score, $playerid, $name, $players, $scores, $playerids, $flags); 
}

function ShowMedal($MedalName, $ArchieveName, $ArchValue, $PlayerId, $Nick, $MedalPicture, $Description, $PlayerNames, $Scores, $FunctionName, $PlayerListIds, $Country, $ch)
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
  
  flush();
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
  $ch->close();
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
                  <tr class=\"innertable\"><td width=\"150\" rowspan=\"3\" align=\"center\"><img src=\"$MedalSrc\" style=\"filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='$MedalSrc', sizingMethod='scale')\" width=\"128\" height=\"256\" title=\"$MedalName\"></img></td>
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
  
    for ($i=0; $i<10; $i++)
    {
      if(@$Scores[$i] > 0) 
      {
        echo "<tr class=\"innertable\">
              <td width=\"50\" align=\"center\">".($i+1)."</td>
              ".(file_exists($geoip_path."GeoIP.dat") ? "<td width=\"50\" align=\"center\">".$Country[$i]."</td>" : "")."
              <td align=\"left\"><a href=\"$link?func=player&playerid=".$PlayerListIds[$i]."&config=${currentconfignumber}\" title=\"".$text["seeplayerdetails"]."\">".htmlspecialchars(utf2iso($PlayerNames[$i]))."</td></a>
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

//------------------------------------------------------------------------------------------------------------
function pro_medal_punchy_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_punchy;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_punchy)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["punchy"], $text["punchykill"], $score, $playerid, $name, "xlr_pro_default.png", $text["mostpunchy"], $players, $scores, $fname, $playerids, $flags, $ch);
  }
}

function pro_medal_ballooney_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_ballooney;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_ballooney)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["balooney"], $text["balooneykill"], $score, $playerid, $name, "xlr_pro_default.png", $text["mostbalooney"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_betty_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_betty;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_betty)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["betty"], $text["bettykill"], $score, $playerid, $name, "xlr_pro_sniper.png", $text["mostbetty"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_killerducks_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_killerducks;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_killerducks)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["lazy"], $text["duckkill"], $score, $playerid, $name, "xlr_pro_default.png", $text["mostlazy"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_cold_weapon_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_knives;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);
  
  if ($ch->cval == 0)
  {
   $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_knives)";
  
  list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
  ShowMedal($text["cldweapon"], $text["knifekill"], $score, $playerid, $name, "xlr_pro_knives.png", $text["mostknife"], $players, $scores, $fname, $playerids, $flags, $ch);
  }
}

function pro_medal_bash_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_bashes;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_bashes)";

  list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
  ShowMedal($text["bashking"], $text["bashes"], $score, $playerid, $name, "xlr_pro_bash.png", $text["mostbash"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_sniper_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_snipers;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_snipers)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["supersniper"], $text["skills"], $score, $playerid, $name, "xlr_pro_sniper.png", $text["mostsniper"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_pistol_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_pistols;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $current_time = gmdate("U");
  
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_pistols)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["clscombat"], $text["skills"], $score, $playerid, $name, "xlr_pro_pistol.png", $text["mostpistol"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_nade_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_nades;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_nades)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["nadekiller"], $text["nadekill"], $score, $playerid, $name  , "xlr_pro_nade.png", $text["mostnade"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_remote_bomb_fan()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_bomb;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $current_time = gmdate("U");
  
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id = $wp_bomb)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["remotebomb"], $text["c4kill"], $score, $playerid, $name, "xlr_pro_c4.png", $text["mostc4"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}   

function pro_medal_surprise_lover()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_claymore;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $current_time = gmdate("U");
  
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
            FROM ${t['weaponusage']}
            JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
            JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
            WHERE (${t['weaponusage']}.weapon_id = $wp_claymore)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["surpriselover"], $text["claymorekill"], $score, $playerid, $name, "xlr_pro_claymore.png", $text["mostclaymore"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_bouncing_betty()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_bouncingbetty;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
            FROM ${t['weaponusage']}
            JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
            JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
            WHERE (${t['weaponusage']}.weapon_id = $wp_bouncingbetty)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["minekiller"], $text["bouncingbettykill"], $score, $playerid, $name, "xlr_pro_bouncing_betty.png", $text["mostbouncingbetty"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_nothing_better_to_do()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, rounds, fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";
  
    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "rounds", "rounds DESC", 0, "");
    ShowMedal($text["notingbetr"], $text["rounds"], $score, $playerid, $name  , "xlr_pro_rounds.png", $text["mostround"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }    
}

function pro_medal_serial_killer()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, winstreak, kills, rounds, fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "winstreak", "winstreak DESC, rounds ASC", 0, "");
    ShowMedal($text["serialkiller"], $text["winstrk"], $score, $playerid, $name, "xlr_pro_killstreak.png", $text["bestwinstrk"], $players, $scores, $fname, $playerids, $flags, $ch);
  }  
}

function pro_medal_best_ratio()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ratio, fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "ratio", "ratio DESC", 2, "");
    ShowMedal($text["bestratio"], $text["bestratio1"], $score, $playerid, $name, "xlr_pro_default.png", $text["bestratio2"], $players, $scores, $fname, $playerids, $flags, $ch);
  }  
}

function pro_medal_most_kills()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, kills, fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "kills", "kills DESC", 0, "");
    ShowMedal($text["mostkills"], $text["mostkills1"], $score, $playerid, $name, "xlr_pro_default.png", $text["mostkills2"], $players, $scores, $fname, $playerids, $flags, $ch);
  }  
}

function pro_medal_highest_skill()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, skill, fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "skill", "skill DESC", 0, "");
    ShowMedal($text["highestskill"], $text["highestskill1"], $score, $playerid, $name, "xlr_pro_default.png", $text["highestskill2"], $players, $scores, $fname, $playerids, $flags, $ch);
  }  
}

function pro_medal_head_hunter()
{
  global $currentconfignumber;
  global $t;  //table names
  global $bp_head;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry =   "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, ((SUM(${t['playerbody']}.kills) / ${t['players']}.kills )*100) AS total_kills
        FROM ${t['playerbody']}
        JOIN ${t['players']} ON ${t['playerbody']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['playerbody']}.bodypart_id IN $bp_head)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 0, "%");
    ShowMedal($text["headhunter"], $text["pheadshots"], $score, $playerid, $name, "xlr_pro_headshots.png", $text["mosthdsht"], $players, $scores, $fname, $playerids, $flags, $ch);
  }
}

function pro_medal_action_hero()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.fixed_name, ${t['players']}.id, ${t['b3_clients']}.ip, sum( ${t['playeractions']}.count ) AS total_actions
            FROM ${t['playeractions']}, ${t['b3_clients']}, ${t['players']}
            WHERE (${t['playeractions']}.player_id = ${t['players']}.id)
            AND (${t['players']}.client_id = ${t['b3_clients']}.id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_actions", "total_actions DESC", 0, "");
    ShowMedal($text["actionhero"], $text["totalactions"], $score, $playerid, $name, "xlr_pro_actions.png", $text["mostactions"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_mortal_cocktail()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_molotov;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
            FROM ${t['weaponusage']}
            JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
            JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
            WHERE (${t['weaponusage']}.weapon_id = $wp_molotov)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["molotov"], $text["molotovkills"], $score, $playerid, $name, "xlr_pro_mortal_cocktail.png", $text["mostmolotov"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_firestarter()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_flamethrower;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
            FROM ${t['weaponusage']}
            JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
            JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
            WHERE (${t['weaponusage']}.weapon_id = $wp_flamethrower)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["flamekiller"], $text["fthrowerkills"], $score, $playerid, $name, "xlr_pro_firestarter.png", $text["mostflamekill"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function pro_medal_dynamite()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_dynamite;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, (SUM(${t['weaponusage']}.kills) / ${t['players']}.rounds ) AS total_kills
            FROM ${t['weaponusage']}
            JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
            JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
            WHERE (${t['weaponusage']}.weapon_id = $wp_dynamite)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_kills", "total_kills DESC", 2, "");
    ShowMedal($text["dynamitekiller"], $text["dynamitekills"], $score, $playerid, $name, "xlr_pro_default.png", $text["mostdynamitekill"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

//------------------------------------------------------------------------------------------------------------

function shame_medal_target_no_one()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, ip, kills,  (deaths / ${t['players']}.rounds) AS pdeaths, fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "pdeaths", "pdeaths DESC", 0, "");
    ShowMedal($text["pwned"], $text["pdeaths"], $score, $playerid, $name, "xlr_shame_deaths.png", $text["target1"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_most_teamkills()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, ip, kills,  (teamkills / ${t['players']}.rounds) AS pteamkills , fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "pteamkills", "pteamkills DESC", 2, "");
    ShowMedal($text["eyeshot"], $text["pteamkil"], $score, $playerid, $name, "xlr_shame_teamkills.png", $text["mostteamkill"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_most_teamdeaths()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, ip, kills, (teamdeaths / ${t['players']}.rounds) AS pteamdeaths, fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "pteamdeaths", "pteamdeaths DESC", 2, "");
    ShowMedal($text["sendjoey"], $text["pteamdeth"], $score, $playerid, $name, "xlr_shame_teamdeaths.png", $text["mosteamdeth"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_nade_magneto()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_nades;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_nades)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["mmnades"], $text["nadedeth"], $score, $playerid, $name, "xlr_shame_nade.png", $text["mostnadeth"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_need_some_practice()
{
  global $currentconfignumber;
  global $t;  //table names
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['b3_clients']}.time_edit, ${t['players']}.id, ip, losestreak, kills, deaths, rounds, fixed_name
        FROM ${t['b3_clients']}, ${t['players']}
        WHERE (${t['b3_clients']}.id = ${t['players']}.client_id)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "losestreak", "losestreak ASC, rounds ASC", 0, "");
    ShowMedal($text["needpractice"], $text["losstrk"], $score, $playerid, $name , "xlr_shame_loosestreak.png", $text["highlosstrk"], $players, $scores, $fname, $playerids, $flags, $ch);
  }
}

function shame_medal_def_punchy()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_punchy;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_punchy)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["punchme"], $text["punchdeath"], $score, $playerid, $name, "xlr_shame_knives.png", $text["mostpunchyd"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_def_ballooney()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_ballooney;
  global $text;

  $current_time = gmdate("U");
  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_ballooney)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["needbaloon"], $text["balonydeath"], $score, $playerid, $name, "xlr_shame_knives.png", $text["mostbalondeth"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_def_betty()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_betty;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_betty)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["bettytarget"], $text["bettydeath"], $score, $playerid, $name, "xlr_shame_knives.png", $text["mostbetydeth"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_killerducks()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_killerducks;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);
  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_killerducks)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["ihateducks"], $text["duckdeath"], $score, $playerid, $name, "xlr_shame_knives.png", $text["mostduckdeth"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_fireman()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_fireman;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id = $wp_fireman)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["mechanic"], $text["vehicledeth"], $score, $playerid, $name, "xlr_shame_vehicle_deaths.png", $text["mostcardeath"], $players, $scores, $fname, $playerids, $flags, $ch);    
  }
}

function shame_medal_def_knifes()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_knives;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_knives)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["shaveme"], $text["knifedeath"], $score, $playerid, $name, "xlr_shame_knives.png", $text["mostknifedeth"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_def_bashes()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_bashes;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_bashes)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["hitme"], $text["bashdeath"], $score, $playerid, $name, "xlr_shame_bash.png", $text["mostbashdeth"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_sniped()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_snipers;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_snipers)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["targtpract"], $text["sniperdeath"], $score, $playerid, $name, "xlr_shame_sniper.png", $text["mostsniped"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_careless()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_accidents;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = " SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.suicides) / ${t['players']}.rounds) AS total_suicides
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_accidents)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_suicides", "total_suicides DESC", 2, "");
    ShowMedal($text["accidenthero"], $text["blindasbat"], $score, $playerid, $name, "xlr_shame_blind.png", $text["mostaccdeath"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_barrel_deaths()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_barrel;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_barrel)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["barrelvictim"], $text["barreldeaths"], $score, $playerid, $name, "xlr_shame_barrel_deaths.png", $text["mostbarrel"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

function shame_medal_dynamite_deaths()
{
  global $currentconfignumber;
  global $t;  //table names
  global $wp_dynamite;
  global $text;

  $fname = __FUNCTION__;
  $ch = new cache($fname, $currentconfignumber);

  if ($ch->cval == 0)
  {
    $qry = "SELECT ${t['b3_clients']}.name, ${t['players']}.id, ip, ${t['b3_clients']}.time_edit, ${t['players']}.fixed_name, rounds, (SUM(${t['weaponusage']}.deaths) / ${t['players']}.rounds) AS total_deaths
        FROM ${t['weaponusage']}
        JOIN ${t['players']} ON ${t['weaponusage']}.player_id = ${t['players']}.id
        JOIN ${t['b3_clients']} ON ${t['players']}.client_id = ${t['b3_clients']}.id
        WHERE (${t['weaponusage']}.weapon_id IN $wp_dynamite)";

    list($score, $playerid, $name, $players, $scores, $playerids, $flags) = CreateMedal($qry, "total_deaths", "total_deaths DESC", 2, "");
    ShowMedal($text["mmdynamite"], $text["dynamitedeth"], $score, $playerid, $name, "xlr_shame_nade.png", $text["mostdyndeth"], $players, $scores, $fname, $playerids, $flags, $ch);  
  }
}

//------------------------------------------------------------------------------------------------------------
class cache
{
  var $cache_dir = './dynamic/cache/';//This is the directory where the cache files will be stored;
  var $cache_time = 3600;//How much time will keep the cache files in seconds.
  
  var $caching = false;
  var $file = '';
  var $cval = 0;

  function cache($fname, $currentconfignumber)
  {
    global $lang_file;
    global $award_cache_time;

    $lang = explode(".", $lang_file);
    if (isset($award_cache_time)) $this->cache_time = $award_cache_time;
    //echo $this->cache_time;

    //Constructor of the class
    $this->file = $this->cache_dir . $fname . '_' . $currentconfignumber . '_' . $lang[0] . ".txt";
    if ( file_exists ( $this->file ) && ( filemtime($this->file) + $this->cache_time ) > time() && !isset($_GET['fname']) )
    {
      //Grab the cache:
      $handle = fopen( $this->file , "r");
      do {
        $data = fread($handle, 8192);
        if (strlen($data) == 0) {
          break;
        }
        $this->cval = 1;
        echo $data;
      } while (true);
      fclose($handle);
    }
    else
    {
      //create cache :
      $this->caching = true;
      ob_start();
    }
  }
  
  function close()
  {
    //You should have this at the end of each page
    if ( $this->caching )
    {
      //You were caching the contents so display them, and write the cache file
      $data = ob_get_clean();
      echo $data;
      $fp = fopen( $this->file , 'w' );
      fwrite ( $fp , $data );
      fclose ( $fp );
    }
  }
}
?>
