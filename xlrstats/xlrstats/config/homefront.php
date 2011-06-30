<?php
/***************************************************************************
 * Xlrstats Webmodule
 * Webrfront for XLRstats for B3 (www.bigbrotherbot.com)
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

//*******************************
// Standard Homefront Settings
//*******************************

// Teamnames and colors
$team1 = "KPA"; // red team
$team2 = "USA"; // blue team
$spectators = "Spectators";

//*********************
// Weapons
//*********************

//*********************
//Assault Rifles
//*********************

$w['RIF_M4'] = "M4 Rifle";
$w['RIF_ACR'] = "ACR Rifle";
$w['RIF_SCAR'] = "SCAR-L Rifle";
$w['RIF_M16'] = "M16 Rifle";
$w['RIF_T3AK'] = "T3AK Rifle";
$w['RIF_XM10'] = "XM10 Rifle";

//*********************
//Sub Machine Guns
//*********************

$w['SMG_DIABLO'] = "PWS Diablo SMG";
$w['SMG_SV45'] = "Super V SMG";

//*********************
//Light Machine Guns
//*********************

$w['LMG_M249'] = "M249 LMG";
$w['LMG_SCARMG'] = "SCAR-H LMG";

//*********************
//Sniper Rifles
//*********************

$w['SNI_M110'] = "M110 Sniper Rifle";
$w['SNI_M200'] = "M200 Sniper Rifle";

//*********************
//Side Arms
//*********************

$w['PST_M9'] = "M9";

//*********************
//Attachments
//*********************
$w['EXP_GL_Airburst'] = "Airburst Launcher (attached)";
$w['EXP_GL_Impact'] = "Grenade Launcher (attached)";
$w['SHT_M4Shotgun'] = "M4 Shotgun (attached)";

//*********************
//Downloadable Guns
//*********************

$w['SHT_870'] = "870 Express Shotgun";

//*********************
//Explosives
//*********************

$w['EXP_Frag'] = "Grenade";
$w[''] = "EMP Grenade";
$w[''] = "Flashbang";
$w['EXP_C4'] = "C4";
$w['PhosphorusFireGrenade'] = "White Phosphorus Grenade";

//*********************
//Drones
//*********************

$w['GAssault_Bullet'] = "MQ50 MG Wolverine";
$w['AAssault_Missile'] = "AQ-11 Buzzard";
$w[''] = "RQ-10 Parrot";
$w['GAntiTankDumb_Missile'] = "MQ60 AT Rhino Missile dumbfired";
$w['GAntiTank_Missile'] = "MQ60 AT Rhino Missile locked";
$w['DroneExplosion'] = "Drone Explosion";

//*********************
//Airstrikes
//*********************

$w['EXP_Hellfire'] = "Hellfire";
$w['EXP_Carpet'] = "Cluster Bomb";
$w['PhosphorusFire'] = "White Phosphorus";

//*********************
//Rocket Launchers
//*********************

$w['ATW_ATRL'] = "RPG Launcher";
$w['ATW_PROX'] = "Proximity Launcher";

//*********************
// Wehicles
//*********************

$w['RanOver'] = "Ran Over";

//Humvee
$w['M1114_Seat1_Bullet'] = "M1151 Humvee (KPA)";
$w['Veh_50calSplash'] = "M1151 Humvee (USA)";

//Light Armor Vehicles
$w['LAV25_AntiAir_Missile'] = "LAV Piranha (AntiAir Missile)";
$w['LAV_Seat0_Bullet'] = "LAV Piranha (M242 50mm Gun)";
$w['LAV_Seat1_Rocket'] = "LAV Piranha (Rocket Launcher)";

//Heavy Tank
$w['M1A3_Seat0_Shell'] = "M1A3 Abrams (120mm Cannon)";
$w['M1A3_Seat1_Bullet'] = "M1A3 Abrams (.50 cal MG)";
$w['T99_Seat0_Shell'] = "T-99 Battle Tank (125mm Cannon)";
$w['T99_Seat1_Bullet'] = "T-99 Battle Tank (.50 cal MG)";

//Scout Heli
$w['MD600_MiniGun'] = "MD600 (Minigun)";
$w['MD600_MiniGunSplash'] = "MD600 (MiniGunSplash)";

//Attack Heli
$w['AH64D_Seat0_AirToAir_Missile'] = "AH-64 Apache (Missile locked)";
$w['AH64D_Seat0_Missile'] = "AH-64 Apache (Missile dumbfired)";
$w['AH64D_Seat1_Bullet'] = "AH-64 Apache (30mm Cannon)";
$w['Z10_Seat1_Bullet'] = "Z-10 Chimera (30mm Cannon)";

//*********************
// Misc
//*********************

$w['CQC_M9Knife'] = "Knife";

//*********************
//Accidents
//*********************

$w['Crushed'] = "Crushed";
$w['Drown'] = "Drowned";
$w['SpawnCamp'] = "SpawnCamp";
$w['Suicided'] = "Suicide";
$w['Burn'] = "Burned";
$w['Fell'] = "Fell to Death";
$w['OutOfCombat'] = "Out Of Combat";
$w['AbandonedVehicle'] = "Abandoned Vehicle";
$w['VehicleCollisionPassenger'] = "Road Kill";
$w['VehicleExplosion'] = "Exploding Vehicle";

//*********************
//unknown
//*********************

$w['EXP_GL_Bounce'] = "EXP_GL_Bounce ???";
$w['Veh_30mmSplash'] = "Veh_30mmSplash ???";

//*********************
// Map names
//*********************
// Stock Homefront Maps
$m['fl-angelisland'] = "Angel Island";
$m['fl-borderlands'] = "Borderlands";
$m['fl-crossroads'] = "Crossroads";
$m['fl-culdesac'] = "Cul-de-Sac";
$m['fl-farm'] = "Farm";
$m['fl-harbor'] = "Green Zone";
$m['fl-lowlands'] = "Lowlands";
$m[''] = "Suburb";


//*********************
// Event names
//*********************

//*********************
// Bodypart names
//*********************

?>