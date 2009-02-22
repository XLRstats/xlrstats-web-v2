<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webfront for XLRstats for B3 (www.bigbrotherbot.com)
 * (c) 2004-2008 www.xlr8or.com (mailto:xlr8or@xlr8or.com)
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

//*********************
// These are the standard cod:waw settings
//*********************

// Teamnames and colors
$team1 = "Wehrmacht / Imperial Army"; // red team
$team2 = "Marine Raiders / Red Army"; // blue team
$spectators = "Spectators";


//*********************
// Weapons names
//*********************
//Stock CoDWaW

$w['30cal_bipod_crouch_mp'] = "M1919A6 Bipod (Crouch)";
$w['30cal_bipod_mp'] = "Browning M1919A6 Bipod";
$w['30cal_bipod_prone_mp'] = "Browning M1919A6 Bipod (Prone)";
$w['30cal_bipod_stand_mp'] = "Browning M1919A6 Bipod (Stand)";
$w['30cal_mp'] = "Browning M1919A6";
$w['357magnum_mp'] = ".357 Magnum Revolver";
$w['artillery_mp'] = "Artillery";
$w['bar_bipod_crouch_mp'] = "B.A.R. Bipod (Crouch)";
$w['bar_bipod_mp'] = "B.A.R. Bipod";
$w['bar_bipod_prone_mp'] = "B.A.R. Bipod (Prone)";
$w['bar_bipod_stand_mp'] = "B.A.R. Bipod (Stand)";
$w['bar_mp'] = "B.A.R.";
$w['bazooka_mp'] = "M9A1 Bazooka";
$w['briefcase_bomb_defuse_mp'] = "Bomb Defuse";
$w['briefcase_bomb_mp'] = "Bomb Explosion";
$w['colt_mp'] = "Colt M1911";
$w['defaultweapon_mp'] = "Default Weapon";
$w['dogs_mp'] = "Dogs";
$w['dog_bite_mp'] = "Dog Bite";
$w['doublebarreledshotgun_grip_mp'] = "Double-Barreled Shotgun Grip";
$w['doublebarreledshotgun_mp'] = "Double-Barreled Shotgun";
$w['doublebarreledshotgun_sawoff_mp'] = "Double-Barreled Shotgun Sawoff";
$w['dp28_bipod_crouch_mp'] = "DP-28 Bipod (Crouch)";
$w['dp28_bipod_mp'] = "DP-28 Bipod";
$w['dp28_bipod_prone_mp'] = "DP-28 Bipod (Prone)";
$w['dp28_bipod_stand_mp'] = "DP-28 Bipod (Stand)";
$w['dp28_mp'] = "DP-28";
$w['fg42_bipod_crouch_mp'] = "FG42 Bipod (Crouch)";
$w['fg42_bipod_mp'] = "FG42 Bipod";
$w['fg42_bipod_prone_mp'] = "FG42 Bipod (Prone)";
$w['fg42_bipod_stand_mp'] = "FG42 Bipod (Stand)";
$w['fg42_mp'] = "FG42";
$w['fg42_telescopic_mp'] = "FG42 Telescopic Sight";
$w['frag_grenade_mp'] = "Frag Grenade";
$w['frag_grenade_short_mp'] = "Martyrdom";
$w['gewehr43_aperture_mp'] = "Gewehr 43 Aperture Sight";
$w['gewehr43_gl_mp'] = "Gewehr 43 Grenade Launcher";
$w['gewehr43_mp'] = "Gewehr 43";
$w['gewehr43_silenced_mp'] = "Gewehr 43 Suppressor";
$w['gewehr43_telescopic_mp'] = "Gewehr 43 Telescopic Sight";
$w['kar98k_bayonet_mp'] = "Kar98k Bayonet";
$w['kar98k_gl_mp'] = "Kar98k Grenade Launcher";
$w['kar98k_mp'] = "Kar98k";
$w['kar98k_scoped_mp'] = "Kar98k Sniper Scope";
$w['m1carbine_aperture_mp'] = "M1A1 Carbine Aperture Sight";
$w['m1carbine_bayonet_mp'] = "M1A1 Carbine Bayonet";
$w['m1carbine_bigammo_mp'] = "M1A1 Carbine Box Magazine";
$w['m1carbine_flash_mp'] = "M1A1 Carbine Flash Hider";
$w['m1carbine_mp'] = "M1A1 Carbine";
$w['m1garand_bayonet_mp'] = "M1 Garand Bayonet";
$w['m1garand_flash_mp'] = "M1 Garand Flash Hider";
$w['m1garand_gl_mp'] = "M1 Garand Grenade Launcher";
$w['m1garand_mp'] = "M1 Garand";
$w['m1garand_scoped_mp'] = "M1 Garand Sniper Scope";
$w['m2_flamethrower_mp'] = "M2 Flamethrower";
$w['m8_white_smoke_mp'] = "M8 White Smoke";
$w['mg42_bipod_crouch_mp'] = "MG42 Bipod (Crouch)";
$w['mg42_bipod_mp'] = "MG42 Bipod";
$w['mg42_bipod_prone_mp'] = "MG42 Bipod (Prone)";
$w['mg42_bipod_stand_mp'] = "MG42 Bipod (Stand)";
$w['mg42_mp'] = "MG42";
$w['mine_bouncing_betty_mp'] = "Bouncing Betty";
$w['molotov_mp'] = "Molotov Cocktail";
$w['mosinrifle_bayonet_mp'] = "Mosin Nagant Bayonet";
$w['mosinrifle_gl_mp'] = "Mosin Nagant Grenade Launcher";
$w['mosinrifle_mp'] = "Mosin Nagant";
$w['mosinrifle_scoped_mp'] = "Mosin Nagant Sniper Scope";
$w['mp40_aperture_mp'] = "MP40 Aperture Sight";
$w['mp40_bigammo_mp'] = "MP40 Dual Magazines";
$w['mp40_mp'] = "MP40";
$w['mp40_silenced_mp'] = "MP40 Suppressor";
$w['nambu_mp'] = "Nambu";
$w['napalmblob_mp'] = "Molotov Cocktail";
$w['panzer4_gunner_front_mp'] = "Panzer IV Frontgunner";
$w['panzer4_gunner_mp'] = "Panzer IV Gunner";
$w['panzer4_mp_explosion_mp'] = "Panzer IV Explosion";
$w['panzer4_turret_mp'] = "Panzer IV Turret";
$w['panzershrek_mp'] = "Panzerschreck";
$w['ppsh_aperture_mp'] = "PPSh-41 Aperture Sight";
$w['ppsh_bigammo_mp'] = "PPSh-41 Round Drum";
$w['ppsh_mp'] = "PPSh-41";
$w['ptrs41_mp'] = "PTRS-41";
$w['radar_mp'] = "Recon Plane";
$w['satchel_charge_mp'] = "Satchel Charge";
$w['shotgun_bayonet_mp'] = "M1897 Trenchgun Bayonet";
$w['shotgun_grip_mp'] = "M1897 Trenchgun Grip";
$w['shotgun_mp'] = "M1897 Trenchgun";
$w['signal_flare_mp'] = "Signal Flare";
$w['springfield_bayonet_mp'] = "Springfield Bayonet";
$w['springfield_gl_mp'] = "Springfield Grenade Launcher";
$w['springfield_mp'] = "Springfield";
$w['springfield_scoped_mp'] = "Springfield Sniper Scope";
$w['stg44_aperture_mp'] = "StG44 Aperture Sight";
$w['stg44_flash_mp'] = "StG44 Flash Hider";
$w['stg44_mp'] = "StG44";
$w['stg44_telescopic_mp'] = "StG44 Telescopic Sight";
$w['sticky_grenade_mp'] = "N 74 ST Grenade";
$w['svt40_aperture_mp'] = "SVT-40 Aperture Sight";
$w['svt40_flash_mp'] = "SVT-40 Flash Hider";
$w['svt40_mp'] = "SVT-40";
$w['svt40_telescopic_mp'] = "SVT-40 Telescopic Sight";
$w['t34_gunner_front_mp'] = "T-34 Front Gunner";
$w['t34_gunner_mp'] = "T-34 Gunner";
$w['t34_mp_explosion_mp'] = "T-34 Explosion";
$w['t34_turret_mp'] = "T-34 Turret";
$w['tabun_gas_mp'] = "Tabun Gas";
$w['thompson_aperture_mp'] = "Thompson Aperture Sight";
$w['thompson_bigammo_mp'] = "Thompson Round Drum";
$w['thompson_mp'] = "Thompson";
$w['thompson_silenced_mp'] = "Thompson Suppressor";
$w['tokarev_mp'] = "Tokarev TT-33";
$w['type100smg_aperture_mp'] = "Type 100 Aperture Sight";
$w['type100smg_bigammo_mp'] = "Type 100 Box Magazine";
$w['type100smg_mp'] = "Type 100";
$w['type100smg_silenced_mp'] = "Type 100 Suppressor";
$w['type99lmg_bayonet_mp'] = "Type 99 Bayonet";
$w['type99lmg_bipod_mp'] = "Type 99 Bipod";
$w['type99lmg_mp'] = "Type 99";
$w['type99rifle_bayonet_mp'] = "Arisaka Bayonet";
$w['type99rifle_gl_mp'] = "Arisaka Grenade Launcher";
$w['type99rifle_mp'] = "Arisaka";
$w['type99rifle_scoped_mp'] = "Arisaka Sniper Scope";
$w['type99_lmg_bipod_crouch_mp'] = "Type 99 Bipod (Crouch)";
$w['type99_lmg_bipod_prone_mp'] = "Type 99 Bipod (Prone)";
$w['type99_lmg_bipod_stand_mp'] = "Type 99 Bipod (Stand)";
$w['walther_mp'] = "Walther P38";
$w['mod_melee'] = "Knife";
$w['mod_falling'] = "Falling";

//No weapon? 
$w['none'] = "Bad luck...";

//These are not in iw_14.iwd, I'm not very sure about them
$w['explodable_barrel'] = "Barrel Explosion";
$w['destructible_car'] = "Vehicle Explosion";


//*********************
// Map names
//*********************
// Stock CoDWaW
$m['mp_airfield'] = "Airfield";
$m['mp_asylum'] = "Asylum";
$m['mp_castle'] = "Castle";
$m['mp_courtyard'] = "Courtyard";
$m['mp_dome'] = "Dome";
$m['mp_downfall'] = "Downfall";
$m['mp_hangar'] = "Hangar";
$m['mp_makin'] = "Makin";
$m['mp_outskirts'] = "Outskirts";
$m['mp_roundhouse'] = "Roundhouse";
$m['mp_seelow'] = "Seelow";
$m['mp_shrine'] = "Cliffside";
$m['mp_suburban'] = "Upheaval";

// Custom Maps CoDWaW


//*********************
// Event names
//*********************
$e['bomb_plant'] = "Bomb Plant";
$e['bomb_defuse'] = "Bomb Defuse";
$e['re_pickup'] = "Pickup";
$e['re_capture'] = "Capture";
$e['re_drop'] = "Drop";


//*********************
// Bodypart names
//*********************
$b['head'] = $text["head"];
$b['neck'] = $text["neck"];
$b['torso_lower'] = $text["torso_lower"];
$b['torso_upper'] = $text["torso_upper"];
$b['left_arm_upper'] = $text["left_arm_upper"];
$b['left_arm_lower'] = $text["left_arm_lower"];
$b['left_hand'] = $text["left_hand"];
$b['right_arm_upper'] = $text["right_arm_upper"];
$b['right_arm_lower'] = $text["right_arm_lower"];
$b['right_hand'] = $text["right_hand"];
$b['left_leg_upper'] = $text["left_leg_upper"];
$b['left_leg_lower'] = $text["left_leg_lower"];
$b['left_foot'] = $text["left_foot"];
$b['right_leg_upper'] = $text["right_leg_upper"];
$b['right_leg_lower'] = $text["right_leg_lower"];
$b['right_foot'] = $text["right_foot"];
$b['none'] = $text["totaldisrupt"];

?>
