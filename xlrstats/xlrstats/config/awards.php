<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2010 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
 ***************************************************************************/

/***************************************************************************
 *  This program is free software, you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY, without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Library General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program, if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 *
 *  http://www.gnu.org/copyleft/gpl.html
 ***************************************************************************/

//*******************
// Global awards: Random 5 are displayed
//*******************
$pro_medals = array();
$shame_medals = array();

// Pro Medals --------------------------------------------------------------------------------------
$pro_medals[] = 'pro_medal_serial_killer';                // win streak           all
$pro_medals[] = 'pro_medal_nothing_better_to_do';         // rounds played        all
$pro_medals[] = 'pro_medal_best_ratio';                   // highest ratio        all
$pro_medals[] = 'pro_medal_most_kills';                   // most kills           all
$pro_medals[] = 'pro_medal_highest_skill';                // highest skill        all

// Action medals in actionbased games only
if ($actionbased == 1)
{
    $pro_medals[] = 'pro_medal_action_hero';             // total actions         all (only for actionbased gametypes!)
}

$g = array('cod1', 'coduo', 'cod2', 'cod4', 'codwaw', 'cod6', 'cod7', 'urt', 'bfbc2', 'moh');
if (in_array($game, $g))
{
    $pro_medals[] = 'pro_medal_nade_killer';              // nade kills           cod urt bfbc2 moh
    $pro_medals[] = 'pro_medal_sniper_killer';            // sniper kills         cod urt bfbc2 moh
}

$g = array('cod1', 'coduo', 'cod2', 'cod4', 'codwaw', 'cod6', 'cod7', 'urt', 'smg', 'bfbc2', 'moh');
if (in_array($game, $g))
{
    $pro_medals[] = 'pro_medal_head_hunter';              // most headshots       cod urt smg bfbc2 moh
    $pro_medals[] = 'pro_medal_pistol_killer';            // pistol kills         cod urt smg bfbc2 moh
}

$g = array('cod1', 'coduo', 'cod2');
if (in_array($game, $g))
{
    $pro_medals[] = 'pro_medal_bash_killer';              // bash kills           cod1 coduo cod2
}

$g = array('coduo', 'cod4', 'cod6', 'cod7', 'moh');
if (in_array($game, $g))
{
    $pro_medals[] = 'pro_medal_remote_bomb_fan';          // Satchell/C4 kills    coduo cod4 cod6 moh
}

$g = array('cod4', 'cod6', 'cod7');
if (in_array($game, $g))
{
    $pro_medals[] = 'pro_medal_surprise_lover';           // claymore kills       cod4 cod6
}

if ($game == 'codwaw' )
{
    $pro_medals[] = 'pro_medal_bouncing_betty';           // bouncing betty kills codwaw
    $pro_medals[] = 'pro_medal_firestarter';              // flame thrower kills  codwaw
}

$g = array('codwaw', 'smg');
if (in_array($game, $g))
{
    $pro_medals[] = 'pro_medal_mortal_cocktail';          // molotov kills        codwaw smg
}

$g = array('cod4', 'codwaw', 'cod6', 'cod7', 'urt', 'smg', 'bfbc2', 'moh');
if (in_array($game, $g))
{
    $pro_medals[] = 'pro_medal_cold_weapon_killer';       // knife kills          cod4 codwaw cod6 urt smg bfbc2
}

if ($game == 'wop')
{
    $pro_medals[] = 'pro_medal_ballooney_killer';         // ballooney kills      wop
    $pro_medals[] = 'pro_medal_betty_killer';             // betty kills          wop
    $pro_medals[] = 'pro_medal_killerducks_killer';       // killerducks kills    wop
    $pro_medals[] = 'pro_medal_punchy_killer';            // punchy kills         wop
}

if ($game == 'smg')
{
    $pro_medals[] = 'pro_medal_dynamite';                 // dynamite kills       smg
}

if ($game == 'cod7')
{
    $pro_medals[] = 'pro_medal_tomahawk';                 // Tomahawk kills       cod7
    $pro_medals[] = 'pro_medal_crossbow';                 // Crossbow kills       cod7
}

// Shame Medals ------------------------------------------------------------------------------------
$shame_medals[] = 'shame_medal_target_no_one';            // deaths               all
$shame_medals[] = 'shame_medal_need_some_practice';       // lose streak          all
$shame_medals[] = 'shame_medal_careless';                 // accidents            all

// Teamkills in teambased games only
if ($teambased == 1)
{
    $shame_medals[] = 'shame_medal_most_teamkills';       // teamkiller           all (only for teambased gametypes!)
    $shame_medals[] = 'shame_medal_most_teamdeaths';      // most teamkilled      all (only for teambased gametypes!)
}

$g = array('cod1', 'coduo', 'cod2', 'cod4', 'cod6', 'cod7', 'codwaw', 'urt', 'bfbc2', 'moh');
if (in_array($game, $g))
{
    $shame_medals[] = 'shame_medal_nade_magneto';         // nades                cod urt bfbc2 moh
    $shame_medals[] = 'shame_medal_sniped';               // killed by snipers    cod urt bfbc2 moh
}

$g = array('cod4', 'codwaw', 'cod6', 'cod7', 'urt', 'smg', 'moh');
if (in_array($game, $g))
{
    $shame_medals[] = 'shame_medal_def_knifes';           // knife deaths         cod4 codwaw cod6 urt smg moh
}

$g = array('cod1', 'coduo', 'cod2');
if (in_array($game, $g))
{
    $shame_medals[] = 'shame_medal_def_bashes';           // bash deaths          cod1 coduo cod2
}

$g = array('cod4', 'codwaw', 'cod6', 'cod7');
if (in_array($game, $g))
{
    $shame_medals[] = 'shame_medal_fireman';              // exploding vehicle    cod4 codwaw cod6
}

$g = array('codwaw', 'cod6', 'cod7');
if (in_array($game, $g))
{
    $shame_medals[] = 'shame_medal_barrel_deaths';        // barrel explosion     codwaw cod6
}

if ($game == 'wop')
{
    $shame_medals[] = 'shame_medal_def_ballooney';        // ballooney deaths     wop
    $shame_medals[] = 'shame_medal_def_betty';            // betty deaths         wop
    $shame_medals[] = 'shame_medal_def_punchy';           // punchy deaths        wop
    $shame_medals[] = 'shame_medal_killerducks';          // killerducks deaths   wop
}

if ($game == 'smg' )
{
    $shame_medals[] = 'shame_medal_dynamite_deaths';      // dynamite deaths      smg
}
?>
