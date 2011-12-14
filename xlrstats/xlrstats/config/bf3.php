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
$team1 = "US Marines"; // red team
$team2 = "RU Army"; // blue team
$spectators = "Spectators";


//******************************
// Weapons names (Main Classes)
//******************************

//Assault
$w['Weapons/M416/M416'] = "M416 Assault Rifle";
$w['AEK-971'] = "AEK-971 Assault Rifle";
$w['M16A4'] = "M16A3 Assault Rifle";
$w['F2000'] = "FN2000 Assault Rifle";
$w['Weapons/KH2002/KH2002'] = "Khaybar KH-2002 Assault Rifle";
$w['AN-94 Abakan'] = "AN-94 Abakan Assault Rifle";
$w['Weapons/AK74M/AK74'] = "AK-74M Assault Rifle";
$w['Weapons/G3A3/G3A3'] = "G3 Assault Rifle";

//Engineer (SMGs and Carbines)
$w['Weapons/SCAR-H/SCAR-H'] = "SCAR-H Carbine Rifle";
$w['Weapons/A91/A91'] = "A-91 Sub Carbine Rifle";
$w['Weapons/G36C/G36C'] = "G36C Carbine Rifle";
$w['M4A1'] = "M4A1 Carbine Rifle";
$w['AKS-74u'] = "AKS 74U Sub Machine Gun";
$w['SG 553 LB'] = "SG553 Carbine Rifle";

//Recon
$w['SV98'] = "SV98 Bolt Action Sniper Rifle";
$w['SKS'] = "SKS Semi Automatic Sniper Rifle";
$w['M40A5'] = "M40A5 Sniper Rifle";
$w['Model98B'] = "M98B Bolt Action Sniper Rifle";
$w['Mk11'] = "MK11 MOD 0 Sniper Rifle";
$w['SVD'] = "SVD Semi Automatic Sniper Rifle";
$w['M39'] = "M39 Semi Automatic Sniper Rifle";

//Support
$w['M249'] = "M249 Machine Gun";
$w['Pecheneg'] = "PKP Pecheneg Machine Gun";
$w['M240'] = "M240B Machine Gun";
$w['M60'] = "M60E4 Machine Gun";
$w['M27IAR'] = "M27 IAR Machine Gun";
$w['RPK-74M'] = "RPK Machine Gun";
$w['Type88'] = "Type 88 Machine Gun"; //?????

//******************************
// Weapons names (General)
//******************************

//Shotguns
$w['870MCS'] = "Remington 870 Shotgun";
$w['M1014'] = "M1014 Semi Automatic Shotgun";
$w['Siaga20k'] = "Saiga 12 Semi Automatic Shotgun";
$w['DAO-12'] = "DAO 12 Semi Automatic Shotgun";
$w['USAS-12'] = "USAS 12 Semi Automatic Shotgun";

//Sidearms
$w['M1911'] = "M1911 Pistol";
$w['M9'] = "Beretta M9 Semi Automatic Pistol";
$w['Weapons/MP443/MP443'] = "MP-443 Grach Semi Automatic Pistol";
$w['Glock18'] = "Glock 18 Fully Automatic Pistol";
$w['Taurus .44'] = ".44 Magnum Pistol";
$w['Weapons/MP412Rex/MP412REX'] = "MP412 REX .357 Magnum Pistol";
$w['M93R'] = "Beretta Model 93R Pistol";

//SMGs
$w['PP-2000'] = "PP-2000 Sub Machine Gun";
$w['Weapons/UMP45/UMP45'] = "UMP-45 Sub Machine Gun";
$w['Weapons/MagpulPDR/MagpulPDR'] = "PDW-R Sub Machine Gun";
$w['Weapons/P90/P90'] = "P90 Sub Machine Gun";
$w['MP7'] = "MP7 Sub Machine Gun";

//Assault
$w['AS VAL'] = "AS VAL Assault Rifle";

//******************************
// Weapons names (Other)
//******************************

//Rocket Launchers
$w['RPG-7'] = "RPG-7 Rocket Launcher";                                     //Engineer
$w['SMAW'] = "SMAW Rocket Launcher";                                       //Engineer
$w['FGM-148'] = "Javelin Anti Tank Missile Launcher";                      //Engineer
$w['FIM92'] = "FIM-92 Stinger Anti Air Missile Launcher";                  //Engineer
$w['Weapons/Sa18IGLA/Sa18IGLA'] = "SA-18 IGLA Anti Air Missile Launcher";  //Engineer

//Equipment
$w['Weapons/Gadgets/C4/C4'] = "C4 explosives";                  //Support
$w['Weapons/Gadgets/Claymore/Claymore'] = "M18 Claymore";       //Support
$w['M15 AT Mine'] = "AT mine";                                  //Engineer
$w['Repair Tool'] = "Repair Tool";                              //Engineer
$w['Defib'] = "Defibrillator";                                  //Assault
$w['M26Mass'] = "M26 MASS";                                     //Assault
$w['M320'] = "M320 Grenade Launcher";                           //Assault
$w['Weapons/Knife/Knife'] = "Knife";                            //General
$w['M67'] = "M67 Hand Grenade";                                 //General
//$w[''] = "M18 Smoke Grenade";                                 //General
//$w[''] = "M224 Mortar";                                       //Support
//$w[''] = "EOD Bot";                                           //Engineer

//Misc
$w['SoldierCollision'] = "Soldier Collision";
$w['Suicide'] = "Suicide";
$w['Melee'] = "Melee";
$w['Death'] = "Vehicle/Mortar Kill";
$w['RoadKill'] = "Road Kill";
$w['DamageArea'] = "Damage Area"; //?
$w[' '] = $text["notidentify"];

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
//B2K Maps
$m['XP1_001'] = "Strike at Karkand";
$m['XP1_002'] = "Gulf of Oman";
$m['XP1_003'] = "Sharqi Peninsula";
$m['XP1_004'] = "Wake Island";
$m['None'] = "-Unknown-";

//*********************
// Event names
//*********************
$e[''] = "";

//*********************
// Bodypart names
//*********************
$b['torso'] = $text["body"];
$b['head'] = $text["head"];

?>