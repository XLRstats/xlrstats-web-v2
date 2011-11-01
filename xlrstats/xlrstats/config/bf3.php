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

//*********************
// These are the standard BF3 settings
//*********************

// Teamnames and colors
$team1 = "Red"; // red team
$team2 = "Blue"; // blue team
$spectators = "Spectators";


//*********************
// Weapons names
//*********************

//Assault
$w['M16A4'] = "M16A4 Assault Rifle";
$w['Weapons/AK74M/AK74'] = "AK-74M Assault Rifle";
$w['Weapons/M416/M416'] = "M416 Assault Rifle";
$w['F2000'] = "FN2000 Assault Rifle";
$w['AEK-971'] = "AEK-971 Assault Rifle";
$w['AN-94 Abakan'] = "AN-94 Abakan Assault Rifle";
//$w[''] = "AS VAL Assault Rifle";
$w['Weapons/G3A3/G3A3'] = "G3 Assault Rifle";
$w['Weapons/KH2002/KH2002'] = "Khaybar KH-2002 Assault Rifle";
//$w[''] = "Steyr Aug Assault Rifle";


//Engineer (SMGs and Carbines)
$w['Weapons/UMP45/UMP45'] = "UMP-45 Sub Machine Gun";
$w['AKS-74u'] = "AKS 74U Sub Machine Gun";
$w['M4A1'] = "M4A1 Carbine Rifle";
$w['Weapons/SCAR-H/SCAR-H'] = "SCAR-H Carbine Rifle";
$w['Weapons/G36C/G36C'] = "G36C Carbine Rifle";
$w['SG 553 LB'] = "SG553 Carbine Rifle";
//$w[''] = "P90 Sub Machine Gun";
$w['MP7'] = "MP7 Sub Machine Gun";
$w['PP-2000'] = "PP-2000 Sub Machine Gun";
$w['MagpulPDR'] = "PDW-R Sub Machine Gun";
$w['Weapons/A91/A91'] = "A-91 Sub Carbine Rifle";

//Medic
$w['M27IAR'] = "M27 Machine Gun";
$w['RPK-74M'] = "RPK Machine Gun";
$w['M249'] = "M249 Machine Gun";
$w['M240'] = "M240 Machine Gun";
$w['M60'] = "M60 Machine Gun";
$w['Pecheneg'] = "PKP Pecheneg Machine Gun";
//$w[''] = "Type 88 Machine Gun";
//$w[''] = "MG36 Machine Gun";

//Recon
$w['Mk11'] = "MK11 Sniper Rifle";
$w['SVD'] = "SVD Semi Automatic Sniper Rifle";
$w['M40A5'] = "M40A5 Sniper Rifle";
$w['SV98'] = "SV98 Bolt Action Sniper Rifle";
//$w[''] = "M98B Bolt Action Sniper Rifle";
$w['M39'] = "M39 Semi Automatic Sniper Rifle";
$w['SKS'] = "SKS Semi Automatic Sniper Rifle";
//$w[''] = "M82 Semi Automatic Sniper Rifle";
$w['Type88'] = "Type 88 Semi Automatic Sniper Rifle";

//Shotguns
$w['870MCS'] = "Remington 870 Shotgun";
//$w[''] = "Saiga 12 Semi Automatic Shotgun";
//$w[''] = "USAS 12 Semi Automatic Shotgun";
$w['DAO-12'] = "DAO 12 Semi Automatic Shotgun";
//$w[''] = "M1014 Semi Automatic Shotgun";
//$w[''] = "SPAS-12 Pump Action Shutgun";

//Sidearms
$w['M9'] = "Beretta M9 Semi Automatic Pistol";
$w['Weapons/MP443/MP443'] = "MP-443 Grach Semi Automatic Pistol";
$w['M93R'] = "Beretta Model 93R Pistol";
$w['M1911'] = "M1911 Pistol";
$w['Glock18'] = "Glock 18 Fully Automatic Pistol";
$w['Weapons/MP412Rex/MP412REX'] = "MP412 REX .357 Magnum Pistol";
$w['Taurus .44'] = ".44 Magnum Pistol";

//Rocket Launchers
$w['RPG-7'] = "RPG-7 ROcket Launcher";
$w['SMAW'] = "SMAW Rocket Launcher";
$w['FGM-148'] = "Javelin Anti Tank Missile Launcher";
$w['FIM92'] = "FIM-92 Stinger Anti Air Missile Launcher";
$w['Weapons/Sa18IGLA/Sa18IGLA'] = "SA-18 IGLA Anti Air Missile Launcher";
//$w[''] = "AT4 Light Anti Tank Rocket Launcher";

//Equipment
$w['Weapons/Gadgets/C4/C4'] = "C4 explosives";
$w['Weapons/Gadgets/Claymore/Claymor'] = "Claymore mine";
$w['M15 AT Mine'] = "AT mine";
//$w[''] = "Mortar";
//$w[''] = "EOD Bot";
$w['Repair Tool'] = "Repair Tool";
$w['Medkit'] = "Defibrillator";
$w['M26Mass'] = "M26 MASS";
$w['M320'] = "M320 Grenade Launcher";
$w['Weapons/Knife/Knife'] = "Knife";
$w['M67'] = "M67 Hand Grenade";
//$w[''] = "M18 Smoke Grenade";

//*********************
// Vehicle names
//*********************

//Tanks
//$w[''] = "M1 Abrams Tank";
//$w[''] = "T-90 Tank";

//APCs
//$w[''] = "LAV-25 APC";
//$w[''] = "BMP-2 APC";
//$w[''] = "9K22 Tunguska Mobile AA";
//$w[''] = "LAV-AD Air Defense Vehicle";

//Helicopters
//$w[''] = "AH-1 Super Cobra Attack Helicopter";
//$w[''] = "Mi-28 Attack Helicopter";
//$w[''] = "UH-1Y Super Huey";
//$w[''] = "KA-60 Chopper";
//$w[''] = "AH-6J Little Bird Recon Helicopter";
//$w[''] = "Z-11 Recon Helicopter";

//Jets
//$w[''] = "F/A 18 Super Hornet Jet";
//$w[''] = "A10 Thunderbolt Jet";
//$w[''] = "Sukhoi Su-35 Jet";
//$w[''] = "Sukhoi Su-39 Jet";

//Transport Vehicles
//$w[''] = "Humvee";
//$w[''] = "Vodnik";
//$w[''] = "Growler ITV";
//$w[''] = "VDV Buggy";
//$w[''] = "RHIB Boat";
//$w[''] = "AAV-7A1 / Amphibious Assault Vehicle";

//*********************
// Other Weapon Names
//*********************
$w['SoldierCollision'] = "Soldier Collision";
$w['Suicide'] = "Suicide";
$w['Melee'] = "Melee";
$w['Death'] = "Death"; //?
$w['RoadKill'] = "Road Kill";
$w['DamageArea'] = "Damage Area"; //?
$w[' '] = $text["notidentify"];


//*********************
// Map names
//*********************
//Stock
$m['MP_001'] = "Grand Bazaar";
$m['MP_003'] = "Teheran Highway";
$m['MP_007'] = "Caspian Border";
$m['MP_011'] = "Seine Crossing";
$m['MP_012'] = "Operation Firestorm";
$m['MP_013'] = "Damavand Peak";
$m['MP_017'] = "Noshahar Canals";
$m['MP_018'] = "Kharg Island";
$m['MP_Subway'] = "Operation Metro";

$m['None'] = "-Unknown-";

//*********************
// Event names
//*********************
$e[''] = "";

//*********************
// Bodypart names
//*********************
$b['None'] = $text["noneurt"];
$b['body'] = $text["notidentify"];
$b['head'] = $text["head"];

?>