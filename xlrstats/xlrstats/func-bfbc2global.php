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

function player_bfbc2_globalstats($playerid, $dbID = false)
{
  global $t;
  global $coddb;

  if($dbID == false)
  {
    $query = "SELECT ${t['b3_clients']}.name
              FROM ${t['b3_clients']}, ${t['players']}
              WHERE ${t['players']}.id = $playerid 
              AND ${t['players']}.client_id =  ${t['b3_clients']}.id
              LIMIT 1";
  }
  else 
  {
    $query = "SELECT ${t['b3_clients']}.name
              FROM ${t['b3_clients']}, ${t['players']}
              WHERE ${t['players']}.client_id = $playerid
              AND ${t['players']}.client_id = ${t['b3_clients']}.id
              LIMIT 1";
  }

  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  
  $fullplayername = $row['name'];
  $clanpattern = '/\[.*\]\s/i';
  $playername = preg_replace($clanpattern, '', $fullplayername);

  $url = 'http://api.bfbcs.com/api/pc';
  $postdata = 'players='.$playername.'&fields=all';

  if(!function_exists('curl_init'))
  {
    $output = '<span class="servererrmsg">Site Admin: cURL support is disabled in your php.ini! Please enable it or contact your web service provider.</span>';
    return $output;
  }

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  $playerstats = curl_exec($ch);
  curl_close($ch);

  $playerstats = json_decode($playerstats);
  
  if(!isset($playerstats))
  {
    $output = '<p><span class="attention">bfbcs.com server is probably overloaded. Try later again!</span></p>';
    return $output;
  }

  if($playerstats->found == 0)
  {
    if($playerstats->players_nodata['0']->queue != 0)
    {
      $output = '<p><span class="attention">Updating stats for '.$playername.'<br />Queue: '.$playerstats->players_nodata['0']->queue.'<br />Please wait...</span></p>';
      return $output;
    }
    else
    {
      $output = '<p><span class="attention">Weird but player "'.$playername.'" does not exist in bfbcs.com database!</span></p>';
      return $output;
    }
  }

  $player = $playerstats->players['0'];
  
  $rank = $player->rank;
  $score = $player->score;
  $rank_image = '<img src="http://files.bfbcs.com/img/bfbcs/ranks_big/r'.sprintf("%03d", $rank).'.png">';
  $veteran_status_img = '<img src ="images/bc2global/veteran/' . $player->veteran . '.png" title="Veteran Status"/>';

  //Display rank name's first letters capital only
  $rankname = explode(" ", $player->rank_name);
  foreach($rankname as $key => $value)
  {
     if($value != "I" && $value != "II" && $value != "III")
       $value = strtolower($value);
  
    $value = ucwords($value);
    $ranks[] = $value;
  }

  $rankname = implode(" ", $ranks);

  $output = '
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
      <tr>
        <td>
          <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
            <tr class="outertable">
            <td align="center">Global Stats for '.$fullplayername.'</td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="1" cellpadding="2" class="outertable">
            <tr class="innertable">
              <td width="150px" valign="top">
                <table width="100%">
                  <tr>
                    <td align="center" style="font-weight:bold; font-size:9pt;">'.$rankname.'</td>
                  </tr>
                  <tr>
                    <td align="center">'.$rank_image.'</td>
                  </tr>
                  <tr>
                    <td align="center">'.display_rank_progress($rank, $score).'</td>
                  </tr>
                  <tr>
                    <td align="center">'.display_bestkit($player) . $veteran_status_img.'</td>
                  </tr>
                  <tr>
                    <td align="center">'.display_bestweapon($player).'</td>
                  </tr>
                </table>
              </td>
              <td valign="top" width="216px">
                <table width="100%" border="0" cellspacing="1" cellpadding="0" class="innertable">
                  <tr class="outertable">
                    <td colspan="2">General Data</td>
                  </tr>
              ';

  //-------------------- Return General Data ------------------------------
  $spm = @($player->score / ($player->time / 60));
  $kpm = @($player->kills / ($player->time / 60));
  $dpm = @($player->deaths / ($player->time / 60));
  
  $ratio = @($player->kills / $player->deaths);
  $ratio = sprintf("%.2f", $ratio);

  if($ratio < 1)
    $ratio = '<span style="color:red; font-weight:bold;">'.$ratio.'</span>';
  else
    $ratio = '<span style="color:green; font-weight:bold;">'.$ratio.'</span>';

  //Change seconds to hh:mm:ss (specially format time)
  $time_seconds = round($player->time);
  $hh = intval($time_seconds / 3600);
  $ss_remaining = ($time_seconds - ($hh * 3600));
  $mm = intval($ss_remaining / 60);
  $ss = ($ss_remaining - ($mm * 60));
  $time = $hh . "h " . $mm ."m " . $ss ."s";
  
  //Specially format last update time
  $lastupdate = date('d M Y, H:i', strtotime($player->date_lastupdate));

  $generalData = array(
                       "rank" => "Rank:",
                       "score" => "Score:",
                       "veteran" => "Veteran:",
                       "elo" => "Skill Level:",
                       "level" => "Level:",
                       "Time:" => $time,
                       "kills" => "Kills:",
                       "deaths" => "Deaths:",
                       "Ratio:" => $ratio,
                       "Update:" => $lastupdate
                       );

  foreach($generalData as $key => $value)
  {
    if(isset($player->$key))
    {
      if(gettype($player->$key) == 'double')
        $player->$key = sprintf("%.2f", $player->$key);
      elseif(gettype($player->$key) == 'integer')
        $player->$key = number_format($player->$key, 0, " ", " ");

      $output .= '<tr class="innertable">
                    <td align="left">'.$value.'</td><td align="right">'.$player->$key.'</td>
                  </tr>
                  <tr><td colspan="2" class="outertable"><img src="images/spacer.gif" width="1" height="1" alt=""></td></tr>';
    }
    else
    {
      $output .= '<tr class="innertable">
                    <td align="left">'.$key.'</td><td align="right">'.$value.'</td>
                 </tr>
                 <tr><td colspan="2" class="outertable"><img src="images/spacer.gif" width="1" height="1" alt=""></td></tr>';
    }
  }

  $output .= '  </table>
              </td>
              <td valign="top" width="216">
                <table width="100%" border="0" cellspacing="1" cellpadding="0" class="innertable">
                  <tr class="outertable">
                    <td colspan="2">Scores</td>
                  </tr>';

  //-------------------- Return Scores ------------------------------
  $player_scores = $playerstats->players['0']->general;

  $scores = array (
                    "sc_general" => "General Score:",
                    "sc_award" => "Award Score:",
                    "sc_bonus" => "Bonus Score:",
                    "sc_team" => "Team Score:",
                    "sc_squad" => "Squad Score:",
                    "sc_assault" => "Assault Score:",
                    "sc_support" => "Medic Score:",
                    "sc_recon" => "Recon Score:",
                    "sc_demo" => "Engineer Score:",
                    "sc_vehicle" => "Vehicle Score:"
                   );

  foreach($scores as $key => $value)
  {
    $output .= '<tr class="innertable">
                    <td align="left">'.$value.'</td><td align="right">'.number_format($player_scores->$key, 0, " ", " ").'</td>
                  </tr>
                  <tr><td colspan="2" class="outertable"><img src="images/spacer.gif" width="1" height="1" alt=""></td></tr>';
  }


  $output .= '         </table>
              </td>
              <td valign="top" width="216">
                <table width="100%" border="0" cellspacing="1" cellpadding="0" class="innertable">
                  <tr class="outertable">
                    <td colspan="2">Misc</td>
                  </tr>
              ';

  //-------------------- Return Miscellaneous Stats --------------------------
  $wlratio = @($player_scores->wins / $player_scores->losses);
  $wlratio = sprintf("%.2f", $wlratio);

  if($wlratio < 1)
    $wlratio = '<span style="color:red; font-weight:bold;">'.$wlratio.'</span>';
  else
    $wlratio = '<span style="color:green; font-weight:bold;">'.$wlratio.'</span>';

  //Specially format accuracy
  $accuracy = ($player_scores->accuracy * 100)."%";

  $misc = array (
                  "Accuracy:" => $accuracy,
                  "dogt" => "Dogtags:",
                  "games" => "Rounds Played:",
                  "wins" => "Wins:",
                  "losses" => "Losses:",
                  "W/L Ratio:" => $wlratio,
                  "teamkills" => "Teamkills:",
                  "Score per minute:" => $spm,
                  "Kills per minute:" => $kpm,
                  "Deaths per minute:" => $dpm
                );

  foreach($misc as $key => $value)
  {
    if(isset($player_scores->$key))
    {
      if(gettype($player_scores->$key) == 'double')
        $player_scores->$key = number_format($player_scores->$key, 2, ".", " ");
      elseif(gettype($player_scores->$key) == 'integer')
        $player_scores->$key = number_format($player_scores->$key, 0, " ", " ");

      $output .= '<tr class="innertable">
                    <td align="left">'.$value.'</td><td align="right">'.$player_scores->$key.'</td>
                  </tr>
                  <tr><td colspan="2" class="outertable"><img src="images/spacer.gif" width="1" height="1" alt=""></td></tr>';
    }
    else
    {
      if(gettype($value) == 'double')
        $value = number_format($value, 2, ".", " ");
      elseif(gettype($value) == 'integer')
        $value = number_format($value, 0, " ", " ");

      $output .= '<tr class="innertable">
                    <td align="left">'.$key.'</td><td align="right">'.$value.'</td>
                 </tr>
                 <tr><td colspan="2" class="outertable"><img src="images/spacer.gif" width="1" height="1" alt=""></td></tr>';
    }
  }
 
   $output .= '  </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

  ';

  //**************** Tabbed Content ****************
  $output .= '
  <div class="tabber">

     <div class="tabbertab">
     <h2>Weapons</h2>
      '.bfbc2_display_player_weapons($player).'
     </div>

     <div class="tabbertab">
      <h2>Vehicles</h2>
      '.bfbc2_display_player_vehicles($player).'
     </div>

     <div class="tabbertab">
      <h2>Insignias</h2>
      '.bfbc2_display_player_insignias($player).'
     </div>

     <div class="tabbertab">
      <h2>Pins</h2>
      '.bfbc2_display_player_pins($player).'
     </div>
 
     <div class="tabbertab">
     <h2>Achievements</h2>
      '.bfbc2_display_player_campaing_achievements($player).'<br />'
      .bfbc2_display_player_online_achievements($player).'
     </div>

    <div class="tabbertab">
      <h2>Kits</h2>
      '.bfbc2_display_player_kits($player).'
     </div>
 
    <div class="tabbertab">
      <h2>Team Stats</h2>
      '.bfbc2_display_player_teams($player).'
     </div>
</div>';
  
  return $output;
}

function bfbc2_display_player_weapons($player)
{
  $weapons = object2array($player->weapons);

  $weaponlist = '<table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
                   <tr>
                     <td>
                       <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
                         <tr class="outertable">
                           <td colspan="7" align="center">Your Weapon Stats</td>
                         </tr>
                         <tr>
                           <td class="innertable" align="center">
                ';

  foreach($weapons as $wname => $wstats)
  {
    if($wstats['kills'] > 0)
    {
      //Change seconds to hh:mm:ss (specially format time)
      $time_seconds = round($wstats['seconds']);
      $hh = intval($time_seconds / 3600);
      $ss_remaining = ($time_seconds - ($hh * 3600));
      $mm = intval($ss_remaining / 60);
      $ss = ($ss_remaining - ($mm * 60));
      $time = sprintf("%02d", $hh) . "h " . sprintf("%02d", $mm) . "m " . sprintf("%02d", $ss) ."s";

      $accuracy = @(number_format((($wstats['shots_hit'] / $wstats['shots_fired']) * 100), 2, ".", " "));
      //$acc_progress = '<div class="rankbarbg"><div><img src="images/bars/bc2bar.png" width="'.$accuracy.'px" height="5px" class="rankbar" /></div></div>';

      //Shorten weapon names
      if(strlen($wstats['name']) > 18)
      {
        $weaponname = explode(" ", $wstats['name']);
        array_pop($weaponname);
        $weaponname = implode(" ", $weaponname);
      }
      else
        $weaponname = $wstats['name'];

      $weaponlist .= '<div class="weapon">
                        <div class="image"><img src ="images/weapons/bfbc2/small/'.$wname.'.png" width="120px"/></div>
                        <div class="name">'.$weaponname.'</div>
                        <ul>
                          <li>
                            <span class="label">Kills:</span>
                            <span class="score">'.number_format($wstats['kills'], 0, " ", " ").'</span>
                          </li>
                          <li>
                            <span class="label">Headshots:</span>
                            <span class="score">'.number_format($wstats['headshots'], 0, " ", " ").'</span>
                          </li>
                          <li>
                            <span class="label">Shots Fired:</span>
                            <span class="score">'.number_format($wstats['shots_fired'], 0, " ", " ").'</span>
                          </li>
                          <li>
                            <span class="label">Shots Hit:</span>
                            <span class="score">'.number_format($wstats['shots_hit'], 0, " ", " ").'</span>
                          </li>
                          <li>
                            <span class="label">Accuracy:</span>
                            <span class="score">'.$accuracy.'%</span>
                          </li>
                          <li>
                            <span class="label">Time:</span>
                            <span class="score">'.$time.'</span>
                          </li>
                        </ul>
                      </div>
                     ';
    }
  }
  $weaponlist .= '     </td></tr>
                      </table>
                     </td>
                   </tr>
                 </table>
              ';
              
  return $weaponlist;
}

function bfbc2_display_player_vehicles($player)
{
  $vehicles = object2array($player->vehicles);

  $vehiclelist = '<table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
                   <tr>
                     <td>
                       <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
                         <tr class="outertable">
                           <td colspan="6" align="center">Your Vehicle Stats</td>
                         </tr>
                         <tr>
                           <td class="innertable" align="center">
                ';

  foreach($vehicles as $vname => $vstats)
  {
    if($vstats['seconds'] > 0)
    {
      //Change seconds to hh:mm:ss (specially format time)
      $time_seconds = round($vstats['seconds']);
      $hh = intval($time_seconds / 3600);
      $ss_remaining = ($time_seconds - ($hh * 3600));
      $mm = intval($ss_remaining / 60);
      $ss = ($ss_remaining - ($mm * 60));
      $time = sprintf("%02d", $hh) . "h " . sprintf("%02d", $mm) . "m " . sprintf("%02d", $ss) ."s";

      $avgspeed = @($vstats['distance'] / $time_seconds);

      $vehiclelist .= '<div class="weapon">
                         <div class="image"><img src ="images/weapons/bfbc2/small/'.$vname.'.png" width="120"/></div>
                         <div class="name">'.$vstats['name'].'</div>
                         <ul>
                           <li>
                             <span class="label">Class:</span>
                             <span class="score">'.ucwords($vstats['class']).'</span>
                           </li>
                           <li>
                             <span class="label">Roadkills:</span>
                             <span class="score">'.(($vstats['class'] != 'stationary') ? number_format($vstats['roadkills'], 0, " ", " ") : 'N/A').'</span>
                           </li>
                           <li>
                             <span class="label">Distance:</span>
                             <span class="score">'.(($vstats['class'] != 'stationary') ? number_format($vstats['distance'], 0, " ", " ") : 'N/A').'</span>
                           </li>
                           <li>
                             <span class="label">Time:</span>
                             <span class="score">'.$time.'</span>
                           </li>
                           <li>
                             <span class="label">Avg.Speed:</span>
                             <span class="score">'.(($vstats['class'] != 'stationary') ? number_format($avgspeed, 2, ".", " ").' d/s' : 'N/A').'</span>
                           </li>
                         </ul>
                       </div>
                      ';
    }
  }
  $vehiclelist .= '   </td></tr>
                      </table>
                     </td>
                   </tr>
                 </table>
              ';

  return $vehiclelist;
}

function bfbc2_display_player_insignias($player)
{
  $insignias = object2array($player->insiginias);

  $insignialist = '<table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
                     <tr>
                       <td>
                         <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
                           <tr class="outertable">
                             <td colspan="6" align="center">Your Insignia Stats</td>
                           </tr>
                           <tr><td align="center">';

  foreach($insignias as $insignia => $insigstats)
  {
    $insignialist .= '<div class="'.(($insigstats['count']== 1) ? 'insignia' : 'insignia locked' ).'">
                        <div class="name">'.$insigstats['name'].'</div>
                        <div class="image"><img style="padding:5px;" src="images/bc2global/insignias/i'.sprintf("%02d", $insignia + 1).'.png" /></div>
                     ';

  $slash = " / ";

  if(isset($insigstats['time']))
  {
    $ins_value1 = $insigstats['time']['value'] / 86400;
    $ins_target1 = $insigstats['time']['target'] / 86400;
    $ins_label1 = ($ins_target1 == 1 ? ' day' : ' days') . " spent online";

    if($insigstats['count'] == 0)
    {
      //Change seconds to dd:hh
      $time_seconds = round($insigstats['time']['value']);
      $dd = intval($time_seconds / 86400);
      $ss_remaining = ($time_seconds - ($dd * 86400));
      $hh = intval($ss_remaining / 3600);
      $ins_value1 = sprintf("%01d", $dd) . "d " . sprintf("%02d", $hh) . "h";
    }
  }
  
  if(isset($insigstats['criteria1']))
  {
    $ins_value1 = $insigstats['criteria1']['value'];
    $ins_target1 = $insigstats['criteria1']['target'];
    $ins_label1 = $insigstats['criteria1']['label'];
  }

  if(isset($insigstats['criteria2']))
  {
    $ins_value2 = $insigstats['criteria2']['value'];
    $ins_target2 = $insigstats['criteria2']['target'];
    $ins_label2 = $insigstats['criteria2']['label'];
  }

  //Missing labels added manually!
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Distinguished Combat Efficiency") $ins_label1 = "50 Combat Efficiency Pins ";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Distinguished Combat Excellence") $ins_label1 = "50 Combat Excellence Pins";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Exemplary Weapon Service") $ins_label1 = "12 weapon pins";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Exemplary Combat Service") $ins_label1 = "11 combat pins<br />8 objective pins";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Exemplary Vehicle Service") $ins_label1 = "5 vehicle pins";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Elite Service") $ins_label1 = "40 unique pins";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Distinguished Weapon Knowledge") $ins_label1 = "Get all weapon bronze stars";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Distinguished Vehicle Knowledge") $ins_label1 = "Get all vehicle bronze stars";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Distinguished Battlefield Knowledge") $ins_label1 = " Get all bronze stars";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Exemplary Battlefield Knowledge") $ins_label1 = "Get 10 silver stars";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Elite Battlefield Knowledge") $ins_label1 = "Get 5 gold stars";
  if(!isset($insigstats['criteria1']) && $insigstats['name'] == "Valorous Battlefield Knowledge") $ins_label1 = "Get 2 platinum stars";

  if(isset($insigstats['criteria1']) || isset($insigstats['time']))
  {
    if($insigstats['count']== 1)
      $insignialist .= '<div class="criteria">' . $ins_target1 . (preg_replace('/# of/',' ', $ins_label1)).'</div>';
    else 
      $insignialist .= '<div class="criteria">' . $ins_value1 . $slash . $ins_target1 . (preg_replace('/# of/',' ', $ins_label1)).'</div>';
  }
  else
  {
    $insignialist .= '<div class="criteria">' . (preg_replace('/# of/',' ', $ins_label1)).'</div>';
  }

  if(isset($insigstats['criteria2']))
  {
    if($insigstats['count']== 1)
      $insignialist .= '<div class="criteria">' . $ins_target2 . (preg_replace('/# of/',' ', $ins_label2)).'</div>';
    else 
      $insignialist .= '<div class="criteria">' . $ins_value2 . $slash . $ins_target2 . (preg_replace('/# of/',' ', $ins_label2)).'</div>';
  }

    $insignialist .= '</div>';
  }

  $insignialist .= '   </td></tr>
                         </table>
                       </td>
                     </tr>
                   </table>
                  ';

  return $insignialist;
}

function bfbc2_display_player_pins($player)
{
  $pins = object2array($player->pins);

  $pinlist = '<table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
                     <tr>
                       <td>
                         <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
                           <tr class="outertable">
                             <td colspan="6" align="center">Your Pin Stats</td>
                           </tr>
                           <tr><td align="center">';

  //Pin Definitions Manually Added
  $pinlabels = array ( "Kill 7 enemies with assault rifles", 
                       "Kill 4 enemies with grenade launchers",
                       "Kill 7 enemies with sniper rifles",
                       "Kill 4 enemies with handguns",
                       "Kill 4 enemies with shotguns",
                       "Kill 5 enemies with rocket launchers",
                       "Kill 7 enemies with light machine guns",
                       "Kill 7 enemies with sub-machine guns",
                       "Kill 5 enemies with stationary weapons",
                       "Kill 4 enemies with explosives",
                       "Kill 4 enemies with melee weapons",
                       "Destroy 4 enemy vehicles",
                       "Reach a kill streak of 6",
                       "Reach a kill streak of 8",
                       "Do 7 kill assists",
                       "Do 2 savior kills",
                       "Do 2 avenger kills",
                       "Do 5 headshots",
                       "Be the best player in a round",
                       "Be part of the best squad in a round",
                       "Kill an enemy 5 times",
                       "Kill your nemesis",
                       "Obtain one attack and one defend order",
                       "Do 3 road kills with any vehicle",
                       "Kill 4 enemies with cars",
                       "Kill 7 enemies with tanks",
                       "Kill 4 enemies with sea vehicles",
                       "Kill 5 enemies with air vehicles",
                       "Blow up 4 M-COM stations",
                       "Defend 4 M-COM stations",
                       "Win a Rush round",
                       "Win a Conquest round",
                       "Win a Squad Deathmatch round",
                       "Win a Squad Rush round",
                       "Capture 4 flags",
                       "Defend 4 flags",
                       "Do 7 resupplies",
                       "Do 5 motion mine assists",
                       "Do 5 revives",
                       "Perform 7 repairs",
                       "Kill 8 enemies with the M16 SPECACT",
                       "Kill 8 enemies with the UMP SPECACT",
                       "Kill 8 enemies with the MG3 SPECACT",
                       "Kill 8 enemies with the M95 SPECACT",
                       "Reach a kill streak of 5 with the M16 SPECACT",
                       "Reach a kill streak of 5 with the UMP SPECACT",
                       "Reach a kill streak of 5 with the MG3 SPECACT",
                       "Reach a kill streak of 5 with the M95 SPECACT"
                       );
  
  $pinswithlabels = array_combine($pinlabels, $pins);
  $i = 0;
  foreach($pinswithlabels as $pin => $pinstats)
  {
    $i++;
    $pinlist .= '<div class="'.(($pinstats['count'] > 0) ? 'insignia' : 'insignia locked' ).'">
                        <div class="name">'.$pinstats['name'].'</div>
                        <div class="image"><img style="padding:5px;" src="images/bc2global/pins/p'.sprintf("%02d", $i).'.png" /></div>
                        <div class="count">x'.$pinstats['count'].'</div>
                        <div class="criteria">'.$pin.'</div>
                     ';

    $pinlist .= '</div>';
  }

  $pinlist .= '   </td></tr>
                         </table>
                       </td>
                     </tr>
                   </table>
                  ';

  return $pinlist;
}

function bfbc2_display_player_campaing_achievements($player)
{
  $achievements = object2array($player->achievements);
  $campaingachs = array_slice($achievements,0,30, true);

  $campaingachlist = '<table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
                     <tr>
                       <td>
                         <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
                           <tr class="outertable">
                             <td colspan="6" align="center">Your Campaing Achievement Stats</td>
                           </tr>
                           <tr><td align="center">';

  $campainglabels = array (
                            "Finish 'Operation Aurora'",
                            "Finish 'Cold War'",
                            "Finish 'Heart of Darkness'",
                            "Finish 'Upriver'",
                            "Finish 'Crack the Sky'",
                            "Finish 'Snowblind'",
                            "Finish 'Heavy Metal'",
                            "Finish 'High Value Target'",
                            "Finish 'Sangre del Toro'",
                            "Finish 'No One Gets Left Behind'",
                            "Finish 'Zero Dark Thirty'",
                            "Finish 'Force Multiplier'",
                            "Finish 'Airborne'",
                            "Finish 'Airborne' on Hard",
                            "Find 5 collectable weapons",
                            "Find 15 collectable weapons",
                            "Destroy 1 satellite uplink",
                            "Destroy 15 satellite uplinks",
                            "Destroy all satellite uplinks",
                            "10 melee kills",
                            "Drive 5 km in any land vehicle",
                            "Destroy 100 objects",
                            "Destroy 1000 objects",
                            "Demolish 1 house",
                            "Demolish 50 houses",
                            "50 kills with assault rifles",
                            "50 kills with sub machine guns",
                            "50 kills with light machine guns",
                            "50 kills with sniper rifles",
                            "50 kills with shotguns"
                          );

  $campaingwithlabels = array_combine($campainglabels, $campaingachs);
  $i = 0;

  foreach($campaingwithlabels as $campaingach => $campaingachstats)
  {
    $i++;
    $campaingachlist .= '<div class="'.(($campaingachstats['unlocked']== 1) ? 'insignia' : 'insignia locked' ).'">
                         <div class="name">'.$campaingachstats['name'].'</div>
                         <div class="image"><img style="padding:5px;" src="images/bc2global/achievements/ta'.sprintf("%02d", $i).'.png" /></div>
                         <div class="criteria">'.$campaingach.'</div>
                     ';

    $campaingachlist .= '</div>';
  }

  $campaingachlist .= '   </td></tr>
                         </table>
                       </td>
                     </tr>
                   </table>
                  ';

  return $campaingachlist;
}

function bfbc2_display_player_online_achievements($player)
{
  $achievements = object2array($player->achievements);
  $onlineachs = array_slice($achievements,30,54, true);

  $onlineachlist = '<table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
                     <tr>
                       <td>
                         <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
                           <tr class="outertable">
                             <td colspan="6" align="center">Your Online Achievement Stats</td>
                           </tr>
                           <tr><td align="center">';

  $onlinelabels = array (
                          "Reach Rank 10",
                          "Reach Rank 22",
                          "3 Assault weapons unlocked",
                          "3 Engineer weapons unlocked",
                          "3 Medic weapons unlocked ",
                          "3 Recon weapons unlocked",
                          "7 unlocks obtained in any single kit ",
                          "15 minutes spent playing",
                          "In a round, get one kill with the knife, the M60 and the RPG-7",
                          "5 kills with each pistol",
                          "Roadkill an enemy with any helicopter",
                          "5 friends knifed",
                          "20 demolish kills",
                          "Destroy an enemy helicopter with a stationary RPG",
                          "Get a headshot kill with the repair tool",
                          "Win a round in all online game modes",
                          "5 Gold Squad pins",
                          "10 service support with all kits",
                          "10 unique awards",
                          "50 unique awards",
                          "get all SPECACT Assault awards",
                          "get all SPECACT Engineer awards",
                          "get all SPECACT Medic awards",
                          "get all SPECACT Recon awards"
                        );

  $onlinewithlabels = array_combine($onlinelabels, $onlineachs);
  $i = 30;

  foreach($onlinewithlabels as $onlineach => $onlineachstats)
  {
    $i++;
    $onlineachlist .= '<div class="'.(($onlineachstats['unlocked']== 1) ? 'insignia' : 'insignia locked' ).'">
                       <div class="name">'.$onlineachstats['name'].'</div>
                       <div class="image"><img style="padding:5px;" src="images/bc2global/achievements/ta'.sprintf("%02d", $i).'.png" /></div>
                       <div class="criteria">'.$onlineach.'</div>
                      ';

    $onlineachlist .= '</div>';
  }

  $onlineachlist .= '   </td></tr>
                         </table>
                       </td>
                     </tr>
                   </table>
                  ';

  return $onlineachlist;
}

function bfbc2_display_player_kits($player)
{
  $kits = object2array($player->kits);

  $kitlist = '   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
                   <tr>
                     <td>
                       <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
                         <tr class="outertable">
                           <td colspan="7" align="center">Your Kit Stats</td>
                         </tr>
                         <tr>
                           <td class="outertable" align="center">Kit Name</td>
                           <td class="outertable" align="center">Score</td>
                           <td class="outertable" align="center">Kills</td>
                           <td class="outertable" align="center">Deaths</td>
                           <td class="outertable" align="center">Ratio</td>
                         </tr>
             ';

  foreach($kits as $kit => $kitstats)
  {
    $ratio = @($kitstats['kills'] / $kitstats['deaths']);
    $ratio = sprintf("%.2f", $ratio);

    if($ratio < 1)
      $style = 'color:red; font-weight:bold;';
    else
      $style = 'color:green; font-weight:bold';

    $kitlist .=  '      <tr>
                           <td class="innertable" align="left"><img src="images/bc2global/kits/'.$kit.'.png" />&nbsp;'.$kitstats['name'].'</td>
                           <td class="innertable" align="center">'.number_format($kitstats['score'], 0, " ", " ").'</td>
                           <td class="innertable" align="center">'.number_format($kitstats['kills'], 0, " ", " ").'</td>
                           <td class="innertable" align="center">'.number_format($kitstats['deaths'], 0, " ", " ").'</td>
                           <td class="innertable" align="center"><span style="'.$style.'">'.$ratio.'</span></td>
                         </tr>
                         <tr><td colspan="5" class="outertable"><img src="images/spacer.gif" width="1" height="1" alt=""></td></tr>
               ';
  }

  $kitlist .= '       </table>
                     </td>
                   </tr>
                 </table>
                ';

  return $kitlist;
}

function bfbc2_display_player_teams($player)
{
  $teams = object2array($player->teams);

  $teamlist = '  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
                   <tr>
                     <td>
                       <table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
                         <tr class="outertable">
                           <td colspan="7" align="center">Your Team Stats</td>
                         </tr>
                         <tr>
                           <td class="outertable" align="center">Team Name</td>
                           <td class="outertable" align="center">Wins</td>
                           <td class="outertable" align="center">Losses</td>
                           <td class="outertable" align="center">Ratio</td>
                         </tr>
             ';

  foreach($teams as $team => $teamstats)
  {
    $ratio = @($teamstats['win'] / $teamstats['loss']);
    $ratio = sprintf("%.2f", $ratio);

    if($ratio < 1)
      $style = 'color:red; font-weight:bold;';
    else
      $style = 'color:green; font-weight:bold';

    $teamlist .=  '      <tr>
                           <td class="innertable" align="left">'.$teamstats['name'].'</td>
                           <td class="innertable" align="center">'.number_format($teamstats['win'], 0, " ", " ").'</td>
                           <td class="innertable" align="center">'.number_format($teamstats['loss'], 0, " ", " ").'</td>
                           <td class="innertable" align="center"><span style="'.$style.'">'.$ratio.'</span></td>
                         </tr>
                         <tr><td colspan="4" class="outertable"><img src="images/spacer.gif" width="1" height="1" alt=""></td></tr>
               ';
  }

  $teamlist .= '       </table>
                     </td>
                   </tr>
                 </table>
                ';

  return $teamlist;
}

function display_rank_progress($rank, $score)
{
  $rank_list = array( '0' => 0,
                      '1' => 6500,
                      '2' => 11000,
                      '3' => 18500,
                      '4' => 28000,
                      '5' => 40000,
                      '6' => 53000,
                      '7' => 68000,
                      '8' => 84000,
                      '9' => 100000,
                      '10' => 120000,
                      '11' => 138000,
                      '12' => 158000,
                      '13' => 179000,
                      '14' => 200000,
                      '15' => 224000,
                      '16' => 247000,
                      '17' => 272000,
                      '18' => 297000,
                      '19' => 323000,
                      '20' => 350000,
                      '21' => 377000,
                      '22' => 405000,
                      '23' => 437000,
                      '24' => 472000,
                      '25' => 537000,
                      '26' => 620000,
                      '27' => 720000,
                      '28' => 832000,
                      '29' => 956000,
                      '30' => 1090000,
                      '31' => 1240000,
                      '32' => 1400000,
                      '33' => 1550000,
                      '34' => 1730000,
                      '35' => 1900000,
                      '36' => 2100000,
                      '37' => 2300000,
                      '38' => 2530000,
                      '39' => 2700000,
                      '40' => 2928000,
                      '41' => 3142000,
                      '42' => 3378000,
                      '43' => 3604000,
                      '44' => 3852000,
                      '45' => 4090000,
                      '46' => 4350000,
                      '47' => 4600000,
                      '48' => 4872000,
                      '49' => 5134000,
                      '50' => 5400000);

  $score_between_levels = $rank_list[$rank+1] - $rank_list[$rank];
  $score_achievement = $score - $rank_list[$rank];
  $score_percentage = @($score_achievement / $score_between_levels);
  $bar_width = round($score_percentage * 100);
  $image_path = 'images/bc2global/';

  if($score >= 5400000)
    $progressbar = '<div class="general_stars_box"><div><img src="'.$image_path.'general.png" class="general_stars" /></div></div>';
  else
    $progressbar = '<div class="rankbarbg"><div><img src="'.$image_path.'bc2bar.png" width="'.$bar_width.'px" height="5px" class="rankbar" /></div></div>';

  return $progressbar;
}

function display_bestkit($player)
{
  $kits = object2array($player->kits);
  foreach ( $kits as $key => $value )
  {
    $kit_easy_name[] = $value['name'] ;
    $kit_score[] = $value['score'];
    $kit_short_name[] = $key;
  }

  $temp_kit_names = array_combine($kit_short_name, $kit_easy_name);
  $temp_kits_scores = array_combine($kit_easy_name, $kit_score);
  $bestkitscore = max($temp_kits_scores);

  $bestkit = "";

  foreach ($temp_kits_scores as $key => $value)
  { 
    if($value == $bestkitscore)
      $bestkit = $key;

    foreach ($temp_kit_names as $key => $value)
    {
      if($value == $bestkit)
        $bestkit_img = $key.".png";
    }
  }

  $bestkit_img = '<img src ="images/bc2global/kits/' . $bestkit_img .'" title="Favorite Kit : ' . $bestkit . '"/>';

  return $bestkit_img;
}

function display_bestweapon($player)
{
  $weapons = object2array($player->weapons);
  foreach ( $weapons as $key => $value )
  {
    $weapon_easy_name[] = $value['name'] ;
    $weapon_kills[] = $value['kills'];
    $weapon_short_name[] = $key;
  }

  $temp_weapon_names = array_combine($weapon_short_name, $weapon_easy_name);
  $temp_weapons_scores = array_combine($weapon_easy_name, $weapon_kills);
  $bestweaponkills = max($temp_weapons_scores);

  $bestweapon = "";
  
  foreach ($temp_weapons_scores as $key => $value)
  { 
    if($value == $bestweaponkills)
      $bestweapon = $key;

    foreach ($temp_weapon_names as $key => $value)
    {
      if($value == $bestweapon)
        $bestweapon_img = $key.".png";
    }
  }

  $bestweapon_img = '<img src ="images/weapons/bfbc2/small/' . $bestweapon_img .'" title="Favorite Weapon : ' . $bestweapon . '"/>';

  return $bestweapon_img;
}

//function that converts objects to array
function object2array($object)
{
  if(!is_object($object) && !is_array($object))
    return $object;

  if(is_object($object))
    $object = get_object_vars( $object );

  return array_map('object2array', $object);
}

?>