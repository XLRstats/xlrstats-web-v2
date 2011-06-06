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

//*********************
// These are the standard cod blackops settings
//*********************

// Teamnames and colors
$team1 = "Tropas / Speznas"; // red team
$team2 = "OP 40 / Black Ops"; // blue team
$spectators = "Spectators";

//*********************
// Weapons names
//*********************

//*********************
//Sub Machine Guns
//*********************

//MP5K
$w['mp5k_mp'] = "MP5K";
$w['mp5k_acog_mp'] = "MP5K ACOG Sight";
$w['mp5k_acog_dualclip_mp'] = "MP5K ACOG Sight & Dual Mag";
$w['mp5k_acog_extclip_mp'] = "MP5K ACOG Sight & Extended Mag";
$w['mp5k_acog_grip_mp'] = "MP5K ACOG Sight & Grip";
$w['mp5k_acog_rf_mp'] = "MP5K ACOG Sight & Rapid Fire";
$w['mp5k_acog_silencer_mp'] = "MP5K ACOG Sight & Suppressor";
$w['mp5k_dualclip_mp'] = "MP5K Dual Mag";
$w['mp5k_dualclip_silencer_mp'] = "MP5K Dual Mag & Suppressor";
$w['mp5k_elbit_mp'] = "MP5K Red Dot Sight";
$w['mp5k_elbit_dualclip_mp'] = "MP5K Red Dot Sight & Dual Mag";
$w['mp5k_elbit_extclip_mp'] = "MP5K Red Dot Sight & Extended Mag";
$w['mp5k_elbit_grip_mp'] = "MP5K Red Dot Sight & Grip";
$w['mp5k_elbit_rf_mp'] = "MP5K Red Dot Sight & Rapid Fire";
$w['mp5k_elbit_silencer_mp'] = "MP5K Red Dot Sight & Suppressor";
$w['mp5k_extclip_mp'] = "MP5K Extended Mag";
$w['mp5k_extclip_silencer_mp'] = "MP5K Extended Mag & Suppressor";
$w['mp5k_grip_mp'] = "MP5K Grip";
$w['mp5k_grip_rf_mp'] = "MP5K Grip & Rapid Fire";
$w['mp5k_grip_dualclip_mp'] = "MP5K Grip & Dual Mag";
$w['mp5k_grip_extclip_mp'] = "MP5K Grip & Extended Mag";
$w['mp5k_grip_silencer_mp'] = "MP5K Grip & Suppressor";
$w['mp5k_reflex_mp'] = "MP5K Reflex Sight";
$w['mp5k_reflex_extclip_mp'] = "MP5K Reflex Sight & Extended Mag";
$w['mp5k_reflex_grip_mp'] = "MP5K Reflex Sight & Grip";
$w['mp5k_reflex_rf_mp'] = "MP5K Reflex Sight & Rapid Fire";
$w['mp5k_reflex_silencer_mp'] = "MP5K Reflex Sight & Suppressor";
$w['mp5k_rf_mp'] = "MP5K Rapid Fire";
$w['mp5k_rf_silencer_mp'] = "MP5K Rapid Fire & Suppressor";
$w['mp5k_silencer_mp'] = "MP5K Suppressor";
$w['mp5kdw_mp'] = "MP5K Dual Wield";

//SKORPION
$w['skorpion_mp'] = "Skorpion";
$w['skorpion_acog_mp'] = "Skorpion ACOG Sight";
$w['skorpion_acog_dualclip_mp'] = "Skorpion ACOG Sight & Dual Mag";
$w['skorpion_acog_grip_mp'] = "Skorpion ACOG Sight & Grip";
$w['skorpion_acog_rf_mp'] = "Skorpion ACOG Sight & Rapid Fire";
$w['skorpion_acog_silencer_mp'] = "Skorpion ACOG Sight & Suppressor";
$w['skorpion_dualclip_mp'] = "Skorpion Dual Mag";
$w['skorpion_dualclip_silencer_mp'] = "Skorpion Dual Mag & Suppressor";
$w['skorpion_elbit_mp'] = "Skorpion Red Dot Sight";
$w['skorpion_elbit_dualclip_mp'] = "Skorpion Red Dot Sight & Dual Mag";
$w['skorpion_elbit_extclip_mp'] = "Skorpion Red Dot Sight & Extended Mag";
$w['skorpion_elbit_grip_mp'] = "Skorpion Red Dot Sight & Grip";
$w['skorpion_elbit_rf_mp'] = "Skorpion Red Dot Sight & Rapid Fire";
$w['skorpion_elbit_silencer_mp'] = "Skorpion Red Dot Sight & Suppressor";
$w['skorpion_extclip_mp'] = "Skorpion Extended Mag";
$w['skorpion_extclip_silencer_mp'] = "Skorpion Extended Mag & Suppressor";
$w['skorpion_grip_mp'] = "Skorpion Grip";
$w['skorpion_grip_rf_mp'] = "Skorpion Grip & Rapid Fire";
$w['skorpion_grip_dualclip_mp'] = "Skorpion Grip & Dual Mag";
$w['skorpion_grip_extclip_mp'] = "Skorpion Grip & Extended Mag";
$w['skorpion_grip_silencer_mp'] = "Skorpion Grip & Suppressor";
$w['skorpion_reflex_mp'] = "Skorpion Reflex Sight";
$w['skorpion_reflex_extclip_mp'] = "Skorpion Reflex Sight & Extended Mag";
$w['skorpion_reflex_grip_mp'] = "Skorpion Reflex Sight & Grip";
$w['skorpion_reflex_rf_mp'] = "Skorpion Reflex Sight & Rapid Fire";
$w['skorpion_reflex_silencer_mp'] = "Skorpion Reflex Sight & Suppressor";
$w['skorpion_rf_mp'] = "Skorpion Rapid Fire";
$w['skorpion_rf_silencer_mp'] = "Skorpion Rapid Fire & Suppressor";
$w['skorpion_silencer_mp'] = "Skorpion Suppressor";
$w['skorpiondw_mp'] = "Skorpion Dual Wield";

//MAC11
$w['mac11_mp'] = "MAC11";
$w['mac11_acog_mp'] = "MAC11 ACOG Sight";
$w['mac11_acog_dualclip_mp'] = "MAC11 ACOG Sight & Dual Mag";
$w['mac11_acog_grip_mp'] = "MAC11 ACOG Sight & Grip";
$w['mac11_acog_rf_mp'] = "MAC11 ACOG Sight & Rapid Fire";
$w['mac11_acog_silencer_mp'] = "MAC11 ACOG Sight & Suppressor";
$w['mac11_dualclip_mp'] = "MAC11 Dual Mag";
$w['mac11_dualclip_silencer_mp'] = "MAC11 Dual Mag & Suppressor";
$w['mac11_elbit_mp'] = "MAC11 Red Dot Sight";
$w['mac11_elbit_dualclip_mp'] = "MAC11 Red Dot Sight & Dual Mag";
$w['mac11_elbit_extclip_mp'] = "MAC11 Red Dot Sight & Extended Mag";
$w['mac11_elbit_grip_mp'] = "MAC11 Red Dot Sight & Grip";
$w['mac11_elbit_rf_mp'] = "MAC11 Red Dot Sight & Rapid Fire";
$w['mac11_elbit_silencer_mp'] = "MAC11 Red Dot Sight & Suppressor";
$w['mac11_extclip_mp'] = "MAC11 Extended Mag";
$w['mac11_extclip_silencer_mp'] = "MAC11 Extended Mag & Suppressor";
$w['mac11_grip_mp'] = "MAC11 Grip";
$w['mac11_grip_rf_mp'] = "MAC11 Grip & Rapid Fire";
$w['mac11_grip_dualclip_mp'] = "MAC11 Grip & Dual Mag";
$w['mac11_grip_extclip_mp'] = "MAC11 Grip & Extended Mag";
$w['mac11_grip_silencer_mp'] = "MAC11 Grip & Suppressor";
$w['mac11_reflex_mp'] = "MAC11 Reflex Sight";
$w['mac11_reflex_extclip_mp'] = "MAC11 Reflex Sight & Extended Mag";
$w['mac11_reflex_grip_mp'] = "MAC11 Reflex Sight & Grip";
$w['mac11_reflex_rf_mp'] = "MAC11 Reflex Sight & Rapid Fire";
$w['mac11_reflex_silencer_mp'] = "MAC11 Reflex Sight & Suppressor";
$w['mac11_rf_mp'] = "MAC11 Rapid Fire";
$w['mac11_rf_silencer_mp'] = "MAC11 Rapid Fire & Suppressor";
$w['mac11_silencer_mp'] = "MAC11 Suppressor";
$w['mac11dw_mp'] = "MAC11 Dual Wield";

//AK74U
$w['ak74u_mp'] = "AK74U";
$w['ak74u_acog_mp'] = "AK74U ACOG Sight";
$w['ak74u_acog_dualclip_mp'] = "AK74U ACOG Sight & Dual Mag";
$w['ak74u_acog_grip_mp'] = "AK74U ACOG Sight & Grip";
$w['ak74u_acog_rf_mp'] = "AK74U ACOG Sight & Rapid Fire";
$w['ak74u_acog_silencer_mp'] = "AK74U ACOG Sight & Suppressor";
$w['ak74u_dualclip_mp'] = "AK74U Dual Mag";
$w['ak74u_dualclip_silencer_mp'] = "AK74U Dual Mag & Suppressor";
$w['ak74u_elbit_mp'] = "AK74U Red Dot Sight";
$w['ak74u_elbit_dualclip_mp'] = "AK74U Red Dot Sight & Dual Mag";
$w['ak74u_elbit_extclip_mp'] = "AK74U Red Dot Sight & Extended Mag";
$w['ak74u_elbit_grip_mp'] = "AK74U Red Dot Sight & Grip";
$w['ak74u_elbit_rf_mp'] = "AK74U Red Dot Sight & Rapid Fire";
$w['ak74u_elbit_silencer_mp'] = "AK74U Red Dot Sight & Suppressor";
$w['ak74u_extclip_mp'] = "AK74U Extended Mag";
$w['ak74u_extclip_silencer_mp'] = "AK74U Extended Mag & Suppressor";
$w['ak74u_gl_mp'] = "AK74U Grenade Launcher Equipped";
$w['ak74u_grip_mp'] = "AK74U Grip";
$w['ak74u_grip_rf_mp'] = "AK74U Grip & Rapid Fire";
$w['ak74u_grip_dualclip_mp'] = "AK74U Grip & Dual Mag";
$w['ak74u_grip_extclip_mp'] = "AK74U Grip & Extended Mag";
$w['ak74u_grip_silencer_mp'] = "AK74U Grip & Suppressor";
$w['ak74u_reflex_mp'] = "AK74U Reflex Sight";
$w['ak74u_reflex_dualclip_mp'] = "AK74U Reflex Sight & Dual Mag";
$w['ak74u_reflex_extclip_mp'] = "AK74U Reflex Sight & Extended Mag";
$w['ak74u_reflex_grip_mp'] = "AK74U Reflex Sight & Grip";
$w['ak74u_reflex_rf_mp'] = "AK74U Reflex Sight & Rapid Fire";
$w['ak74u_reflex_silencer_mp'] = "AK74U Reflex Sight & Suppressor";
$w['ak74u_rf_mp'] = "AK74U Rapid Fire";
$w['ak74u_rf_silencer_mp'] = "AK74U Rapid Fire & Suppressor";
$w['ak74u_silencer_mp'] = "AK74U Suppressor";
$w['ak74udw_mp'] = "AK74U Dual Wield";

//UZI
$w['uzi_mp'] = "Uzi";
$w['uzi_acog_mp'] = "Uzi ACOG Sight";
$w['uzi_acog_dualclip_mp'] = "Uzi ACOG Sight & Dual Mag";
$w['uzi_acog_grip_mp'] = "Uzi ACOG Sight & Grip";
$w['uzi_acog_rf_mp'] = "Uzi ACOG Sight & Rapid Fire";
$w['uzi_acog_silencer_mp'] = "Uzi ACOG Sight & Suppressor";
$w['uzi_dualclip_mp'] = "Uzi Dual Mag";
$w['uzi_dualclip_silencer_mp'] = "Uzi Dual Mag & Suppressor";
$w['uzi_elbit_mp'] = "Uzi Red Dot Sight";
$w['uzi_elbit_dualclip_mp'] = "Uzi Red Dot Sight & Dual Mag";
$w['uzi_elbit_extclip_mp'] = "Uzi Red Dot Sight & Extended Mag";
$w['uzi_elbit_grip_mp'] = "Uzi Red Dot Sight & Grip";
$w['uzi_elbit_rf_mp'] = "Uzi Red Dot Sight & Rapid Fire";
$w['uzi_elbit_silencer_mp'] = "Uzi Red Dot Sight & Suppressor";
$w['uzi_extclip_mp'] = "Uzi Extended Mag";
$w['uzi_extclip_silencer_mp'] = "Uzi Extended Mag & Suppressor";
$w['uzi_grip_mp'] = "Uzi Grip";
$w['uzi_grip_rf_mp'] = "Uzi Grip & Rapid Fire";
$w['uzi_grip_dualclip_mp'] = "Uzi Grip & Dual Mag";
$w['uzi_grip_extclip_mp'] = "Uzi Grip & Extended Mag";
$w['uzi_grip_silencer_mp'] = "Uzi Grip & Suppressor";
$w['uzi_reflex_mp'] = "Uzi Reflex Sight";
$w['uzi_reflex_extclip_mp'] = "Uzi Reflex Sight & Extended Mag";
$w['uzi_reflex_grip_mp'] = "Uzi Reflex Sight & Grip";
$w['uzi_reflex_rf_mp'] = "Uzi Reflex Sight & Rapid Fire";
$w['uzi_reflex_silencer_mp'] = "Uzi Reflex Sight & Suppressor";
$w['uzi_rf_mp'] = "Uzi Rapid Fire";
$w['uzi_rf_silencer_mp'] = "Uzi Rapid Fire & Suppressor";
$w['uzi_silencer_mp'] = "Uzi Suppressor";
$w['uzidw_mp'] = "Uzi Dual Wield";

//PM63
$w['pm63_mp'] = "PM63";
$w['pm63_acog_mp'] = "PM63 ACOG Sight";
$w['pm63_acog_dualclip_mp'] = "PM63 ACOG Sight & Dual Mag";
$w['pm63_acog_grip_mp'] = "PM63 ACOG Sight & Grip";
$w['pm63_acog_rf_mp'] = "PM63 ACOG Sight & Rapid Fire";
$w['pm63_acog_silencer_mp'] = "PM63 ACOG Sight & Suppressor";
$w['pm63_dualclip_mp'] = "PM63 Dual Mag";
$w['pm63_dualclip_silencer_mp'] = "PM63 Dual Mag & Suppressor";
$w['pm63_elbit_mp'] = "PM63 Red Dot Sight";
$w['pm63_elbit_dualclip_mp'] = "PM63 Red Dot Sight & Dual Mag";
$w['pm63_elbit_extclip_mp'] = "PM63 Red Dot Sight & Extended Mag";
$w['pm63_elbit_grip_mp'] = "PM63 Red Dot Sight & Grip";
$w['pm63_elbit_rf_mp'] = "PM63 Red Dot Sight & Rapid Fire";
$w['pm63_elbit_silencer_mp'] = "PM63 Red Dot Sight & Suppressor";
$w['pm63_extclip_mp'] = "PM63 Extended Mag";
$w['pm63_extclip_silencer_mp'] = "PM63 Extended Mag & Suppressor";
$w['pm63_grip_mp'] = "PM63 Grip";
$w['pm63_grip_rf_mp'] = "PM63 Grip & Rapid Fire";
$w['pm63_grip_dualclip_mp'] = "PM63 Grip & Dual Mag";
$w['pm63_grip_extclip_mp'] = "PM63 Grip & Extended Mag";
$w['pm63_grip_silencer_mp'] = "PM63 Grip & Suppressor";
$w['pm63_reflex_mp'] = "PM63 Reflex Sight";
$w['pm63_reflex_extclip_mp'] = "PM63 Reflex Sight & Extended Mag";
$w['pm63_reflex_grip_mp'] = "PM63 Reflex Sight & Grip";
$w['pm63_reflex_rf_mp'] = "PM63 Reflex Sight & Rapid Fire";
$w['pm63_reflex_silencer_mp'] = "PM63 Reflex Sight & Suppressor";
$w['pm63_rf_mp'] = "PM63 Rapid Fire";
$w['pm63_rf_silencer_mp'] = "PM63 Rapid Fire & Suppressor";
$w['pm63_silencer_mp'] = "PM63 Suppressor";
$w['pm63dw_mp'] = "PM63 Dual Wield";

//MPL
$w['mpl_mp'] = "MPL";
$w['mpl_acog_mp'] = "MPL ACOG Sight";
$w['mpl_acog_dualclip_mp'] = "MPL ACOG Sight & Dual Mag";
$w['mpl_acog_grip_mp'] = "MPL ACOG Sight & Grip";
$w['mpl_acog_rf_mp'] = "MPL ACOG Sight & Rapid Fire";
$w['mpl_acog_silencer_mp'] = "MPL ACOG Sight & Suppressor";
$w['mpl_dualclip_mp'] = "MPL Dual Mag";
$w['mpl_dualclip_silencer_mp'] = "MPL Dual Mag & Suppressor";
$w['mpl_elbit_mp'] = "MPL Red Dot Sight";
$w['mpl_elbit_dualclip_mp'] = "MPL Red Dot Sight & Dual Mag";
$w['mpl_elbit_extclip_mp'] = "MPL Red Dot Sight & Extended Mag";
$w['mpl_elbit_grip_mp'] = "MPL Red Dot Sight & Grip";
$w['mpl_elbit_rf_mp'] = "MPL Red Dot Sight & Rapid Fire";
$w['mpl_elbit_silencer_mp'] = "MPL Red Dot Sight & Suppressor";
$w['mpl_extclip_mp'] = "MPL Extended Mag";
$w['mpl_extclip_silencer_mp'] = "MPL Extended Mag & Suppressor";
$w['mpl_grip_mp'] = "MPL Grip";
$w['mpl_grip_rf_mp'] = "MPL Grip & Rapid Fire";
$w['mpl_grip_dualclip_mp'] = "MPL Grip & Dual Mag";
$w['mpl_grip_extclip_mp'] = "MPL Grip & Extended Mag";
$w['mpl_grip_silencer_mp'] = "MPL Grip & Suppressor";
$w['mpl_reflex_mp'] = "MPL Reflex Sight";
$w['mpl_reflex_extclip_mp'] = "MPL Reflex Sight & Extended Mag";
$w['mpl_reflex_grip_mp'] = "MPL Reflex Sight & Grip";
$w['mpl_reflex_rf_mp'] = "MPL Reflex Sight & Rapid Fire";
$w['mpl_reflex_silencer_mp'] = "MPL Reflex Sight & Suppressor";
$w['mpl_rf_mp'] = "MPL Rapid Fire";
$w['mpl_rf_silencer_mp'] = "MPL Rapid Fire & Suppressor";
$w['mpl_silencer_mp'] = "MPL Suppressor";
$w['mpldw_mp'] = "MPL Dual Wield";

//SPECTRE
$w['spectre_mp'] = "Spectre";
$w['spectre_acog_mp'] = "Spectre ACOG Sight";
$w['spectre_acog_dualclip_mp'] = "Spectre ACOG Sight & Dual Mag";
$w['spectre_acog_grip_mp'] = "Spectre ACOG Sight & Grip";
$w['spectre_acog_rf_mp'] = "Spectre ACOG Sight & Rapid Fire";
$w['spectre_acog_silencer_mp'] = "Spectre ACOG Sight & Suppressor";
$w['spectre_dualclip_mp'] = "Spectre Dual Mag";
$w['spectre_dualclip_silencer_mp'] = "Spectre Dual Mag & Suppressor";
$w['spectre_elbit_mp'] = "Spectre Red Dot Sight";
$w['spectre_elbit_dualclip_mp'] = "Spectre Red Dot Sight & Dual Mag";
$w['spectre_elbit_extclip_mp'] = "Spectre Red Dot Sight & Extended Mag";
$w['spectre_elbit_grip_mp'] = "Spectre Red Dot Sight & Grip";
$w['spectre_elbit_rf_mp'] = "Spectre Red Dot Sight & Rapid Fire";
$w['spectre_elbit_silencer_mp'] = "Spectre Red Dot Sight & Suppressor";
$w['spectre_extclip_mp'] = "Spectre Extended Mag";
$w['spectre_extclip_silencer_mp'] = "Spectre Extended Mag & Suppressor";
$w['spectre_grip_mp'] = "Spectre Grip";
$w['spectre_grip_rf_mp'] = "Spectre Grip & Rapid Fire";
$w['spectre_grip_dualclip_mp'] = "Spectre Grip & Dual Mag";
$w['spectre_grip_extclip_mp'] = "Spectre Grip & Extended Mag";
$w['spectre_grip_silencer_mp'] = "Spectre Grip & Suppressor";
$w['spectre_reflex_mp'] = "Spectre Reflex Sight";
$w['spectre_reflex_extclip_mp'] = "Spectre Reflex Sight & Extended Mag";
$w['spectre_reflex_grip_mp'] = "Spectre Reflex Sight & Grip";
$w['spectre_reflex_rf_mp'] = "Spectre Reflex Sight & Rapid Fire";
$w['spectre_reflex_silencer_mp'] = "Spectre Reflex Sight & Suppressor";
$w['spectre_rf_mp'] = "Spectre Rapid Fire";
$w['spectre_rf_silencer_mp'] = "Spectre Rapid Fire & Suppressor";
$w['spectre_silencer_mp'] = "Spectre Suppressor";
$w['spectredw_mp'] = "Spectre Dual Wield";

//KIPARIS
$w['kiparis_mp'] = "Kiparis";
$w['kiparis_acog_mp'] = "Kiparis ACOG Sight";
$w['kiparis_acog_dualclip_mp'] = "Kiparis ACOG Sight & Dual Mag";
$w['kiparis_acog_grip_mp'] = "Kiparis ACOG Sight & Grip";
$w['kiparis_acog_rf_mp'] = "Kiparis ACOG Sight & Rapid Fire";
$w['kiparis_acog_silencer_mp'] = "Kiparis ACOG Sight & Suppressor";
$w['kiparis_dualclip_mp'] = "Kiparis Dual Mag";
$w['kiparis_dualclip_silencer_mp'] = "Kiparis Dual Mag & Suppressor";
$w['kiparis_elbit_mp'] = "Kiparis Red Dot Sight";
$w['kiparis_elbit_dualclip_mp'] = "Kiparis Red Dot Sight & Dual Mag";
$w['kiparis_elbit_extclip_mp'] = "Kiparis Red Dot Sight & Extended Mag";
$w['kiparis_elbit_grip_mp'] = "Kiparis Red Dot Sight & Grip";
$w['kiparis_elbit_rf_mp'] = "Kiparis Red Dot Sight & Rapid Fire";
$w['kiparis_elbit_silencer_mp'] = "Kiparis Red Dot Sight & Suppressor";
$w['kiparis_extclip_mp'] = "Kiparis Extended Mag";
$w['kiparis_extclip_silencer_mp'] = "Kiparis Extended Mag & Suppressor";
$w['kiparis_grip_mp'] = "Kiparis Grip";
$w['kiparis_grip_rf_mp'] = "Kiparis Grip & Rapid Fire";
$w['kiparis_grip_dualclip_mp'] = "Kiparis Grip & Dual Mag";
$w['kiparis_grip_extclip_mp'] = "Kiparis Grip & Extended Mag";
$w['kiparis_grip_silencer_mp'] = "Kiparis Grip & Suppressor";
$w['kiparis_reflex_mp'] = "Kiparis Reflex Sight";
$w['kiparis_reflex_extclip_mp'] = "Kiparis Reflex Sight & Extended Mag";
$w['kiparis_reflex_grip_mp'] = "Kiparis Reflex Sight & Grip";
$w['kiparis_reflex_rf_mp'] = "Kiparis Reflex Sight & Rapid Fire";
$w['kiparis_reflex_silencer_mp'] = "Kiparis Reflex Sight & Suppressor";
$w['kiparis_rf_mp'] = "Kiparis Rapid Fire";
$w['kiparis_rf_silencer_mp'] = "Kiparis Rapid Fire & Suppressor";
$w['kiparis_silencer_mp'] = "Kiparis Suppressor";
$w['kiparisdw_mp'] = "Kiparis Dual Wield";

//*********************
//Assault Rifles
//*********************

//M16
$w['m16_mp'] = "M16";
$w['m16_acog_mp'] = "M16 ACOG Sight";
$w['m16_acog_dualclip_mp'] = "M16 ACOG Sight & Dual Mag";
$w['m16_acog_extclip_mp'] = "M16 ACOG Sight & Extended Mag";
$w['m16_acog_silencer_mp'] = "M16 ACOG Sight & Suppressor";
$w['m16_dualclip_mp'] = "M16 Dual Mag";
$w['m16_dualclip_silencer_mp'] = "M16 Dual Mag & Suppressor";
$w['m16_elbit_mp'] = "M16 Red Dot Sight";
$w['m16_elbit_dualclip_mp'] = "M16 Red Dot Sight & Dual Mag";
$w['m16_elbit_extclip_mp'] = "M16 Red Dot Sight & Extended Mag";
$w['m16_elbit_silencer_mp'] = "M16 Red Dot Sight & Suppressor";
$w['m16_extclip_mp'] = "M16 Extended Mag";
$w['m16_extclip_silencer_mp'] = "M16 Extended Mag & Suppressor";
$w['m16_ft_mp'] = "M16 Flamethrower Equipped";
$w['m16_gl_mp'] = "M16 Grenade Launcher Equipped";
$w['m16_ir_mp'] = "M16 Infrared Scope";
$w['m16_ir_dualclip_mp'] = "M16 Infrared Scope & Dual Mag";
$w['m16_ir_extclip_mp'] = "M16 Infrared Scope & Extended Mag";
$w['m16_ir_silencer_mp'] = "M16 Infrared Scope & Suppressor";
$w['m16_mk_mp'] = "M16 Masterkey Equipped";
$w['m16_reflex_mp'] = "M16 Reflex Sight";
$w['m16_reflex_dualclip_mp'] = "M16 Reflex Sight & Dual Mag";
$w['m16_reflex_extclip_mp'] = "M16 Reflex Sight & Extended Mag";
$w['m16_reflex_silencer_mp'] = "M16 Reflex Sight & Suppressor";
$w['m16_silencer_mp'] = "M16 Suppressor";

//ENFIELD
$w['enfield_mp'] = "Enfield";
$w['enfield_acog_mp'] = "Enfield ACOG Sight";
$w['enfield_acog_dualclip_mp'] = "Enfield ACOG Sight & Dual Mag";
$w['enfield_acog_extclip_mp'] = "Enfield ACOG Sight & Extended Mag";
$w['enfield_acog_silencer_mp'] = "Enfield ACOG Sight & Suppressor";
$w['enfield_dualclip_mp'] = "Enfield Dual Mag";
$w['enfield_dualclip_silencer_mp'] = "Enfield Dual Mag & Suppressor";
$w['enfield_elbit_mp'] = "Enfield Red Dot Sight";
$w['enfield_elbit_dualclip_mp'] = "Enfield Red Dot Sight & Dual Mag";
$w['enfield_elbit_extclip_mp'] = "Enfield Red Dot Sight & Extended Mag";
$w['enfield_elbit_silencer_mp'] = "Enfield Red Dot Sight & Suppressor";
$w['enfield_extclip_mp'] = "Enfield Extended Mag";
$w['enfield_extclip_silencer_mp'] = "Enfield Extended Mag & Suppressor";
$w['enfield_ft_mp'] = "Enfield Flamethrower Equipped";
$w['enfield_gl_mp'] = "Enfield Grenade Launcher Equipped";
$w['enfield_ir_mp'] = "Enfield Infrared Scope";
$w['enfield_ir_dualclip_mp'] = "Enfield Infrared Scope & Dual Mag";
$w['enfield_ir_extclip_mp'] = "Enfield Infrared Scope & Extended Mag";
$w['enfield_ir_silencer_mp'] = "Enfield Infrared Scope & Suppressor";
$w['enfield_mk_mp'] = "Enfield Masterkey Equipped";
$w['enfield_reflex_mp'] = "Enfield Reflex Sight";
$w['enfield_reflex_dualclip_mp'] = "Enfield Reflex Sight & Dual Mag";
$w['enfield_reflex_extclip_mp'] = "Enfield Reflex Sight & Extended Mag";
$w['enfield_reflex_silencer_mp'] = "Enfield Reflex Sight & Suppressor";
$w['enfield_silencer_mp'] = "Enfield Suppressor";

//M14
$w['m14_mp'] = "M14";
$w['m14_acog_mp'] = "M14 ACOG Sight";
$w['m14_acog_dualclip_mp'] = "M14 ACOG Sight & Dual Mag";
$w['m14_acog_extclip_mp'] = "M14 ACOG Sight & Extended Mag";
$w['m14_acog_silencer_mp'] = "M14 ACOG Sight & Suppressor";
$w['m14_dualclip_mp'] = "M14 Dual Mag";
$w['m14_dualclip_silencer_mp'] = "M14 Dual Mag & Suppressor";
$w['m14_elbit_mp'] = "M14 Red Dot Sight";
$w['m14_elbit_dualclip_mp'] = "M14 Red Dot Sight & Dual Mag";
$w['m14_elbit_extclip_mp'] = "M14 Red Dot Sight & Extended Mag";
$w['m14_elbit_silencer_mp'] = "M14 Red Dot Sight & Suppressor";
$w['m14_extclip_mp'] = "M14 Extended Mag";
$w['m14_extclip_silencer_mp'] = "M14 Extended Mag & Suppressor";
$w['m14_ft_mp'] = "M14 Flamethrower Equipped";
$w['m14_gl_mp'] = "M14 Grenade Launcher Equipped";
$w['m14_ir_mp'] = "M14 Infrared Scope";
$w['m14_ir_dualclip_mp'] = "M14 Infrared Scope & Dual Mag";
$w['m14_ir_extclip_mp'] = "M14 Infrared Scope & Extended Mag";
$w['m14_ir_grip_mp'] = "M14 Infrared Scope & Grip";
$w['m14_ir_silencer_mp'] = "M14 Infrared Scope & Suppressor";
$w['m14_mk_mp'] = "M14 Masterkey Equipped";
$w['m14_reflex_mp'] = "M14 Reflex Sight";
$w['m14_reflex_dualclip_mp'] = "M14 Reflex Sight & Dual Mag";
$w['m14_reflex_extclip_mp'] = "M14 Reflex Sight & Extended Mag";
$w['m14_reflex_silencer_mp'] = "M14 Reflex Sight & Suppressor";
$w['m14_silencer_mp'] = "M14 Suppressor";
//m14 only
$w['m14_acog_grip_mp'] = "M14 ACOG Sight & Grip";
$w['m14_elbit_grip_mp'] = "M14 Red Dot Sight & Grip";
$w['m14_grip_mp'] = "M14 Grip";
$w['m14_grip_extclip_mp'] = "M14 Grip & Extended Mag";
$w['m14_grip_silencer_mp'] = "M14 Grip & Suppressor";
$w['m14_reflex_grip_mp'] = "M14 Reflex Sight & Grip";

//FAMAS
$w['famas_mp'] = "Famas";
$w['famas_acog_mp'] = "Famas ACOG Sight";
$w['famas_acog_dualclip_mp'] = "Famas ACOG Sight & Dual Mag";
$w['famas_acog_extclip_mp'] = "Famas ACOG Sight & Extended Mag";
$w['famas_acog_silencer_mp'] = "Famas ACOG Sight & Suppressor";
$w['famas_dualclip_mp'] = "Famas Dual Mag";
$w['famas_dualclip_silencer_mp'] = "Famas Dual Mag & Suppressor";
$w['famas_elbit_mp'] = "Famas Red Dot Sight";
$w['famas_elbit_dualclip_mp'] = "Famas Red Dot Sight & Dual Mag";
$w['famas_elbit_extclip_mp'] = "Famas Red Dot Sight & Extended Mag";
$w['famas_elbit_silencer_mp'] = "Famas Red Dot Sight & Suppressor";
$w['famas_extclip_mp'] = "Famas Extended Mag";
$w['famas_extclip_silencer_mp'] = "Famas Extended Mag & Suppressor";
$w['famas_ft_mp'] = "Famas Flamethrower Equipped";
$w['famas_gl_mp'] = "Famas Grenade Launcher Equipped";
$w['famas_ir_mp'] = "Famas Infrared Scope";
$w['famas_ir_dualclip_mp'] = "Famas Infrared Scope & Dual Mag";
$w['famas_ir_extclip_mp'] = "Famas Infrared Scope & Extended Mag";
$w['famas_ir_silencer_mp'] = "Famas Infrared Scope & Suppressor";
$w['famas_mk_mp'] = "Famas Masterkey Equipped";
$w['famas_reflex_mp'] = "Famas Reflex Sight";
$w['famas_reflex_dualclip_mp'] = "Famas Reflex Sight & Dual Mag";
$w['famas_reflex_extclip_mp'] = "Famas Reflex Sight & Extended Mag";
$w['famas_reflex_silencer_mp'] = "Famas Reflex Sight & Suppressor";
$w['famas_silencer_mp'] = "Famas Suppressor";

//GALIL
$w['galil_mp'] = "Galil";
$w['galil_acog_mp'] = "Galil ACOG Sight";
$w['galil_acog_dualclip_mp'] = "Galil ACOG Sight & Dual Mag";
$w['galil_acog_extclip_mp'] = "Galil ACOG Sight & Extended Mag";
$w['galil_acog_silencer_mp'] = "Galil ACOG Sight & Suppressor";
$w['galil_dualclip_mp'] = "Galil Dual Mag";
$w['galil_dualclip_silencer_mp'] = "Galil Dual Mag & Suppressor";
$w['galil_elbit_mp'] = "Galil Red Dot Sight";
$w['galil_elbit_dualclip_mp'] = "Galil Red Dot Sight & Dual Mag";
$w['galil_elbit_extclip_mp'] = "Galil Red Dot Sight & Extended Mag";
$w['galil_elbit_silencer_mp'] = "Galil Red Dot Sight & Suppressor";
$w['galil_extclip_mp'] = "Galil Extended Mag";
$w['galil_extclip_silencer_mp'] = "Galil Extended Mag & Suppressor";
$w['galil_ft_mp'] = "Galil Flamethrower Equipped";
$w['galil_gl_mp'] = "Galil Grenade Launcher Equipped";
$w['galil_ir_mp'] = "Galil Infrared Scope";
$w['galil_ir_dualclip_mp'] = "Galil Infrared Scope & Dual Mag";
$w['galil_ir_extclip_mp'] = "Galil Infrared Scope & Extended Mag";
$w['galil_ir_silencer_mp'] = "Galil Infrared Scope & Suppressor";
$w['galil_mk_mp'] = "Galil Masterkey Equipped";
$w['galil_reflex_mp'] = "Galil Reflex Sight";
$w['galil_reflex_dualclip_mp'] = "Galil Reflex Sight & Dual Mag";
$w['galil_reflex_extclip_mp'] = "Galil Reflex Sight & Extended Mag";
$w['galil_reflex_silencer_mp'] = "Galil Reflex Sight & Suppressor";
$w['galil_silencer_mp'] = "Galil Suppressor";

//AUG
$w['aug_mp'] = "AUG";
$w['aug_acog_mp'] = "AUG ACOG Sight";
$w['aug_acog_dualclip_mp'] = "AUG ACOG Sight & Dual Mag";
$w['aug_acog_extclip_mp'] = "AUG ACOG Sight & Extended Mag";
$w['aug_acog_silencer_mp'] = "AUG ACOG Sight & Suppressor";
$w['aug_dualclip_mp'] = "AUG Dual Mag";
$w['aug_dualclip_silencer_mp'] = "AUG Dual Mag & Suppressor";
$w['aug_elbit_mp'] = "AUG Red Dot Sight";
$w['aug_elbit_dualclip_mp'] = "AUG Red Dot Sight & Dual Mag";
$w['aug_elbit_extclip_mp'] = "AUG Red Dot Sight & Extended Mag";
$w['aug_elbit_silencer_mp'] = "AUG Red Dot Sight & Suppressor";
$w['aug_extclip_mp'] = "AUG Extended Mag";
$w['aug_extclip_silencer_mp'] = "AUG Extended Mag & Suppressor";
$w['aug_ft_mp'] = "AUG Flamethrower Equipped";
$w['aug_gl_mp'] = "AUG Grenade Launcher Equipped";
$w['aug_ir_mp'] = "AUG Infrared Scope";
$w['aug_ir_dualclip_mp'] = "AUG Infrared Scope & Dual Mag";
$w['aug_ir_extclip_mp'] = "AUG Infrared Scope & Extended Mag";
$w['aug_ir_silencer_mp'] = "AUG Infrared Scope & Suppressor";
$w['aug_mk_mp'] = "AUG Masterkey Equipped";
$w['aug_reflex_mp'] = "AUG Reflex Sight";
$w['aug_reflex_dualclip_mp'] = "AUG Reflex Sight & Dual Mag";
$w['aug_reflex_extclip_mp'] = "AUG Reflex Sight & Extended Mag";
$w['aug_reflex_silencer_mp'] = "AUG Reflex Sight & Suppressor";
$w['aug_silencer_mp'] = "AUG Suppressor";

//FN-FAL
$w['fnfal_mp'] = "FN-FAL";
$w['fnfal_acog_mp'] = "FN-FAL ACOG Sight";
$w['fnfal_acog_dualclip_mp'] = "FN-FAL ACOG Sight & Dual Mag";
$w['fnfal_acog_extclip_mp'] = "FN-FAL ACOG Sight & Extended Mag";
$w['fnfal_acog_silencer_mp'] = "FN-FAL ACOG Sight & Suppressor";
$w['fnfal_dualclip_mp'] = "FN-FAL Dual Mag";
$w['fnfal_dualclip_silencer_mp'] = "FN-FAL Dual Mag & Suppressor";
$w['fnfal_elbit_mp'] = "FN-FAL Red Dot Sight";
$w['fnfal_elbit_dualclip_mp'] = "FN-FAL Red Dot Sight & Dual Mag";
$w['fnfal_elbit_extclip_mp'] = "FN-FAL Red Dot Sight & Extended Mag";
$w['fnfal_elbit_silencer_mp'] = "FN-FAL Red Dot Sight & Suppressor";
$w['fnfal_extclip_mp'] = "FN-FAL Extended Mag";
$w['fnfal_extclip_silencer_mp'] = "FN-FAL Extended Mag & Suppressor";
$w['fnfal_ft_mp'] = "FN-FAL Flamethrower Equipped";
$w['fnfal_gl_mp'] = "FN-FAL Grenade Launcher Equipped";
$w['fnfal_ir_mp'] = "FN-FAL Infrared Scope";
$w['fnfal_ir_dualclip_mp'] = "FN-FAL Infrared Scope & Dual Mag";
$w['fnfal_ir_extclip_mp'] = "FN-FAL Infrared Scope & Extended Mag";
$w['fnfal_ir_silencer_mp'] = "FN-FAL Infrared Scope & Suppressor";
$w['fnfal_mk_mp'] = "FN-FAL Masterkey Equipped";
$w['fnfal_reflex_mp'] = "FN-FAL Reflex Sight";
$w['fnfal_reflex_dualclip_mp'] = "FN-FAL Reflex Sight & Dual Mag";
$w['fnfal_reflex_extclip_mp'] = "FN-FAL Reflex Sight & Extended Mag";
$w['fnfal_reflex_silencer_mp'] = "FN-FAL Reflex Sight & Suppressor";
$w['fnfal_silencer_mp'] = "FN-FAL Suppressor";

//AK47
$w['ak47_mp'] = "AK47";
$w['ak47_acog_mp'] = "AK47 ACOG Sight";
$w['ak47_acog_dualclip_mp'] = "AK47 ACOG Sight & Dual Mag";
$w['ak47_acog_extclip_mp'] = "AK47 ACOG Sight & Extended Mag";
$w['ak47_acog_silencer_mp'] = "AK47 ACOG Sight & Suppressor";
$w['ak47_dualclip_mp'] = "AK47 Dual Mag";
$w['ak47_dualclip_silencer_mp'] = "AK47 Dual Mag & Suppressor";
$w['ak47_elbit_mp'] = "AK47 Red Dot Sight";
$w['ak47_elbit_dualclip_mp'] = "AK47 Red Dot Sight & Dual Mag";
$w['ak47_elbit_extclip_mp'] = "AK47 Red Dot Sight & Extended Mag";
$w['ak47_elbit_silencer_mp'] = "AK47 Red Dot Sight & Suppressor";
$w['ak47_extclip_mp'] = "AK47 Extended Mag";
$w['ak47_extclip_silencer_mp'] = "AK47 Extended Mag & Suppressor";
$w['ak47_ft_mp'] = "AK47 Flamethrower Equipped";
$w['ak47_gl_mp'] = "AK47 Grenade Launcher Equipped";
$w['ak47_ir_mp'] = "AK47 Infrared Scope";
$w['ak47_ir_dualclip_mp'] = "AK47 Infrared Scope & Dual Mag";
$w['ak47_ir_extclip_mp'] = "AK47 Infrared Scope & Extended Mag";
$w['ak47_ir_silencer_mp'] = "AK47 Infrared Scope & Suppressor";
$w['ak47_mk_mp'] = "AK47 Masterkey Equipped";
$w['ak47_reflex_mp'] = "AK47 Reflex Sight";
$w['ak47_reflex_dualclip_mp'] = "AK47 Reflex Sight & Dual Mag";
$w['ak47_reflex_extclip_mp'] = "AK47 Reflex Sight & Extended Mag";
$w['ak47_reflex_silencer_mp'] = "AK47 Reflex Sight & Suppressor";
$w['ak47_silencer_mp'] = "AK47 Suppressor";

//COMMANDO
$w['commando_mp'] = "Commando";
$w['commando_acog_mp'] = "Commando ACOG Sight";
$w['commando_acog_dualclip_mp'] = "Commando ACOG Sight & Dual Mag";
$w['commando_acog_extclip_mp'] = "Commando ACOG Sight & Extended Mag";
$w['commando_acog_silencer_mp'] = "Commando ACOG Sight & Suppressor";
$w['commando_dualclip_mp'] = "Commando Dual Mag";
$w['commando_dualclip_silencer_mp'] = "Commando Dual Mag & Suppressor";
$w['commando_elbit_mp'] = "Commando Red Dot Sight";
$w['commando_elbit_dualclip_mp'] = "Commando Red Dot Sight & Dual Mag";
$w['commando_elbit_extclip_mp'] = "Commando Red Dot Sight & Extended Mag";
$w['commando_elbit_silencer_mp'] = "Commando Red Dot Sight & Suppressor";
$w['commando_extclip_mp'] = "Commando Extended Mag";
$w['commando_extclip_silencer_mp'] = "Commando Extended Mag & Suppressor";
$w['commando_ft_mp'] = "Commando Flamethrower Equipped";
$w['commando_gl_mp'] = "Commando Grenade Launcher Equipped";
$w['commando_ir_mp'] = "Commando Infrared Scope";
$w['commando_ir_dualclip_mp'] = "Commando Infrared Scope & Dual Mag";
$w['commando_ir_extclip_mp'] = "Commando Infrared Scope & Extended Mag";
$w['commando_ir_silencer_mp'] = "Commando Infrared Scope & Suppressor";
$w['commando_mk_mp'] = "Commando Masterkey Equipped";
$w['commando_reflex_mp'] = "Commando Reflex Sight";
$w['commando_reflex_dualclip_mp'] = "Commando Reflex Sight & Dual Mag";
$w['commando_reflex_extclip_mp'] = "Commando Reflex Sight & Extended Mag";
$w['commando_reflex_silencer_mp'] = "Commando Reflex Sight & Suppressor";
$w['commando_silencer_mp'] = "Commando Suppressor";

//G11
$w['g11_mp'] = "G11";
$w['g11_lps_mp'] = "G11 Low Powered Scope";
$w['g11_vzoom_mp'] = "G11 Variable Zoom";

//*********************
//Shotguns
//*********************

//OLYMPIA
$w['rottweil72_mp'] = "Olympia";

//STAKEOUT
$w['ithaca_mp'] = "Stakeout";
$w['ithaca_grip_mp'] = "Stakeout Grip";

//SPAS-12
$w['spas_mp'] = "SPAS-12";
$w['spas_silencer_mp'] = "SPAS-12 Suppressor";

//HS10
$w['hs10_mp'] = "HS10";
$w['hs10dw_mp'] = "HS10 Dual Wield";

//*********************
//Light Machine Guns
//*********************

//HK21
$w['hk21_mp'] = "HK21";
$w['hk21_acog_grip_mp'] = "HK21 ACOG Sight & Grip";
$w['hk21_acog_mp'] = "HK21 ACOG Sight";
$w['hk21_acog_dualclip_mp'] = "HK21 ACOG Sight & Dual Mag";
$w['hk21_acog_extclip_mp'] = "HK21 ACOG Sight & Extended Mag";
$w['hk21_dualclip_mp'] = "HK21 Dual Mag";
$w['hk21_elbit_mp'] = "HK21 Red Dot Sight";
$w['hk21_elbit_dualclip_mp'] = "HK21 Red Dot Sight & Dual Mag";
$w['hk21_elbit_extclip_mp'] = "HK21 Red Dot Sight & Extended Mag";
$w['hk21_elbit_grip_mp'] = "HK21 Red Dot Sight & Grip";
$w['hk21_extclip_mp'] = "HK21 Extended Mag";
$w['hk21_grip_mp'] = "HK21 Grip";
$w['hk21_grip_extclip_mp'] = "HK21 Grip & Extended Mag";
$w['hk21_ir_grip_mp'] = "HK21 Infrared Scope & Grip";
$w['hk21_ir_mp'] = "HK21 Infrared Scope";
$w['hk21_reflex_mp'] = "HK21 Reflex Sight";
$w['hk21_reflex_extclip_mp'] = "HK21 Reflex Sight & Extended Mag";
$w['hk21_reflex_grip_mp'] = "HK21 Reflex Sight & Grip";

//RPK
$w['rpk_mp'] = "RPK";
$w['rpk_acog_grip_mp'] = "RPK ACOG Sight & Grip";
$w['rpk_acog_mp'] = "RPK ACOG Sight";
$w['rpk_acog_dualclip_mp'] = "RPK ACOG Sight & Dual Mag";
$w['rpk_acog_extclip_mp'] = "RPK ACOG Sight & Extended Mag";
$w['rpk_dualclip_mp'] = "RPK Dual Mag";
$w['rpk_elbit_mp'] = "RPK Red Dot Sight";
$w['rpk_elbit_dualclip_mp'] = "RPK Red Dot Sight & Dual Mag";
$w['rpk_elbit_extclip_mp'] = "RPK Red Dot Sight & Extended Mag";
$w['rpk_elbit_grip_mp'] = "RPK Red Dot Sight & Grip";
$w['rpk_extclip_mp'] = "RPK Extended Mag";
$w['rpk_grip_mp'] = "RPK Grip";
$w['rpk_grip_extclip_mp'] = "RPK Grip & Extended Mag";
$w['rpk_ir_grip_mp'] = "RPK Infrared Scope & Grip";
$w['rpk_ir_mp'] = "RPK Infrared Scope";
$w['rpk_ir_dualclip_mp'] = "RPK Infrared Scope & Dual Mag";
$w['rpk_reflex_mp'] = "RPK Reflex Sight";
$w['rpk_reflex_dualclip_mp'] = "RPK Reflex Sight & Dual Mag";
$w['rpk_reflex_extclip_mp'] = "RPK Reflex Sight & Extended Mag";
$w['rpk_reflex_grip_mp'] = "RPK Reflex Sight & Grip";

//M60
$w['m60_mp'] = "M60";
$w['m60_acog_grip_mp'] = "M60 ACOG Sight & Grip";
$w['m60_acog_mp'] = "M60 ACOG Sight";
$w['m60_acog_dualclip_mp'] = "M60 ACOG Sight & Dual Mag";
$w['m60_acog_extclip_mp'] = "M60 ACOG Sight & Extended Mag";
$w['m60_dualclip_mp'] = "M60 Dual Mag";
$w['m60_elbit_mp'] = "M60 Red Dot Sight";
$w['m60_elbit_dualclip_mp'] = "M60 Red Dot Sight & Dual Mag";
$w['m60_elbit_extclip_mp'] = "M60 Red Dot Sight & Extended Mag";
$w['m60_elbit_grip_mp'] = "M60 Red Dot Sight & Grip";
$w['m60_extclip_mp'] = "M60 Extended Mag";
$w['m60_grip_mp'] = "M60 Grip";
$w['m60_grip_extclip_mp'] = "M60 Grip & Extended Mag";
$w['m60_ir_grip_mp'] = "M60 Infrared Scope & Grip";
$w['m60_ir_mp'] = "M60 Infrared Scope";
$w['m60_reflex_mp'] = "M60 Reflex Sight";
$w['m60_reflex_extclip_mp'] = "M60 Reflex Sight & Extended Mag";
$w['m60_reflex_grip_mp'] = "M60 Reflex Sight & Grip";

//STONER63
$w['stoner63_mp'] = "Stoner63";
$w['stoner63_acog_grip_mp'] = "Stoner63 ACOG Sight & Grip";
$w['stoner63_acog_mp'] = "Stoner63 ACOG Sight";
$w['stoner63_acog_dualclip_mp'] = "Stoner63 ACOG Sight & Dual Mag";
$w['stoner63_acog_extclip_mp'] = "Stoner63 ACOG Sight & Extended Mag";
$w['stoner63_dualclip_mp'] = "Stoner63 Dual Mag";
$w['stoner63_elbit_mp'] = "Stoner63 Red Dot Sight";
$w['stoner63_elbit_dualclip_mp'] = "Stoner63 Red Dot Sight & Dual Mag";
$w['stoner63_elbit_extclip_mp'] = "Stoner63 Red Dot Sight & Extended Mag";
$w['stoner63_elbit_grip_mp'] = "Stoner63 Red Dot Sight & Grip";
$w['stoner63_extclip_mp'] = "Stoner63 Extended Mag";
$w['stoner63_grip_mp'] = "Stoner63 Grip";
$w['stoner63_grip_extclip_mp'] = "Stoner63 Grip & Extended Mag";
$w['stoner63_ir_grip_mp'] = "Stoner63 Infrared Scope & Grip";
$w['stoner63_ir_mp'] = "Stoner63 Infrared Scope";
$w['stoner63_ir_extclip_mp'] = "Stoner63 Infrared Scope & Dual Mag";
$w['stoner63_reflex_mp'] = "Stoner63 Reflex Sight";
$w['stoner63_reflex_extclip_mp'] = "Stoner63 Reflex Sight & Extended Mag";
$w['stoner63_reflex_grip_mp'] = "Stoner63 Reflex Sight & Grip";

//*********************
//Sniper Rifles
//*********************

//DRAGUNOV
$w['dragunov_mp'] = "Dragunov";
$w['dragunov_acog_mp'] = "Dragunov ACOG Sight";
$w['dragunov_acog_extclip_mp'] = "Dragunov ACOG Sight & Extended Mag";
$w['dragunov_acog_silencer_mp'] = "Dragunov ACOG Sight & Suppressor";
$w['dragunov_extclip_mp'] = "Dragunov Extended Mag";
$w['dragunov_extclip_silencer_mp'] = "Dragunov Extended Mag & Suppressor";
$w['dragunov_ir_mp'] = "Dragunov Infrared Scope";
$w['dragunov_ir_extclip_mp'] = "Dragunov Infrared Scope & Extended Mag";
$w['dragunov_ir_silencer_mp'] = "Dragunov Infrared Scope & Suppressor";
$w['dragunov_silencer_mp'] = "Dragunov Suppressor";
$w['dragunov_vzoom_mp'] = "Dragunov Variable Zoom";
$w['dragunov_vzoom_extclip_mp'] = "Dragunov Variable Zoom & Extended Mag";
$w['dragunov_vzoom_silencer_mp'] = "Dragunov Variable Zoom & Suppressor";

//WA2000
$w['wa2000_mp'] = "WA2000";
$w['wa2000_acog_mp'] = "WA2000 ACOG Sight";
$w['wa2000_acog_extclip_mp'] = "WA2000 ACOG Sight & Extended Mag";
$w['wa2000_acog_silencer_mp'] = "WA2000 ACOG Sight & Suppressor";
$w['wa2000_extclip_mp'] = "WA2000 Extended Mag";
$w['wa2000_extclip_silencer_mp'] = "WA2000 Extended Mag & Suppressor";
$w['wa2000_ir_mp'] = "WA2000 Infrared Scope";
$w['wa2000_ir_extclip_mp'] = "WA2000 Infrared Scope & Extended Mag";
$w['wa2000_ir_silencer_mp'] = "WA2000 Infrared Scope & Suppressor";
$w['wa2000_silencer_mp'] = "WA2000 Suppressor";
$w['wa2000_vzoom_mp'] = "WA2000 Variable Zoom";
$w['wa2000_vzoom_extclip_mp'] = "WA2000 Variable Zoom & Extended Mag";
$w['wa2000_vzoom_silencer_mp'] = "WA2000 Variable Zoom & Suppressor";

//L96A1
$w['l96a1_mp'] = "L96A1";
$w['l96a1_acog_mp'] = "L96A1 ACOG Sight";
$w['l96a1_acog_extclip_mp'] = "L96A1 ACOG Sight & Extended Mag";
$w['l96a1_acog_silencer_mp'] = "L96A1 ACOG Sight & Suppressor";
$w['l96a1_extclip_mp'] = "L96A1 Extended Mag";
$w['l96a1_extclip_silencer_mp'] = "L96A1 Extended Mag & Suppressor";
$w['l96a1_ir_mp'] = "L96A1 Infrared Scope";
$w['l96a1_ir_extclip_mp'] = "L96A1 Infrared Scope & Extended Mag";
$w['l96a1_ir_silencer_mp'] = "L96A1 Infrared Scope & Suppressor";
$w['l96a1_silencer_mp'] = "L96A1 Suppressor";
$w['l96a1_vzoom_mp'] = "L96A1 Variable Zoom";
$w['l96a1_vzoom_extclip_mp'] = "L96A1 Variable Zoom & Extended Mag";
$w['l96a1_vzoom_silencer_mp'] = "L96A1 Variable Zoom & Suppressor";

//PSG1
$w['psg1_mp'] = "PSG1";
$w['psg1_acog_mp'] = "PSG1 ACOG Sight";
$w['psg1_acog_extclip_mp'] = "PSG1 ACOG Sight & Extended Mag";
$w['psg1_acog_silencer_mp'] = "PSG1 ACOG Sight & Suppressor";
$w['psg1_extclip_mp'] = "PSG1 Extended Mag";
$w['psg1_extclip_silencer_mp'] = "PSG1 Extended Mag & Suppressor";
$w['psg1_ir_mp'] = "PSG1 Infrared Scope";
$w['psg1_ir_extclip_mp'] = "PSG1 Infrared Scope & Extended Mag";
$w['psg1_ir_silencer_mp'] = "PSG1 Infrared Scope & Suppressor";
$w['psg1_silencer_mp'] = "PSG1 Suppressor";
$w['psg1_vzoom_mp'] = "PSG1 Variable Zoom";
$w['psg1_vzoom_extclip_mp'] = "PSG1 Variable Zoom & Extended Mag";
$w['psg1_vzoom_silencer_mp'] = "PSG1 Variable Zoom & Suppressor";

//*********************
//Pistols
//*********************

//ASP
$w['asp_mp'] = "M1911";
$w['aspdw_mp'] = "M1911 Dual Wield";
$w['asp_auto_mp'] = "M1911 Full Auto Upgrade";
$w['asp_extclip_mp'] = "M1911 Extended Mag";
$w['asp_silencer_mp'] = "M1911 Suppressor";
$w['asp_upgradesight_mp'] = "M1911 Upgraded Iron Sights";

//M1911
$w['m1911_mp'] = "M1911";
$w['m1911dw_mp'] = "M1911 Dual Wield";
$w['m1911_auto_mp'] = "M1911 Full Auto Upgrade";
$w['m1911_extclip_mp'] = "M1911 Extended Mag";
$w['m1911_silencer_mp'] = "M1911 Suppressor";
$w['m1911_upgradesight_mp'] = "M1911 Upgraded Iron Sights";

//MAKAROV
$w['makarov_mp'] = "M1911";
$w['makarovdw_mp'] = "M1911 Dual Wield";
$w['makarov_auto_mp'] = "M1911 Full Auto Upgrade";
$w['makarov_extclip_mp'] = "M1911 Extended Mag";
$w['makarov_silencer_mp'] = "M1911 Suppressor";
$w['makarov_upgradesight_mp'] = "M1911 Upgraded Iron Sights";

//PYTHON
$w['python_mp'] = "Python";
$w['pythondw_mp'] = "Python Dual Wield";
$w['python_acog_mp'] = "Python ACOG Sight";
$w['python_snub_mp'] = "Python Snub Nose";
$w['python_speed_mp'] = "Python Speed Reloader";

//CZ75
$w['cz75_mp'] = "CZ75";
$w['cz75dw_mp'] = "CZ75 Dual Wield";
$w['cz75_auto_mp'] = "CZ75 Full Auto Upgrade";
$w['cz75_extclip_mp'] = "CZ75 Extended Mag";
$w['cz75_silencer_mp'] = "CZ75 Suppressor";
$w['cz75_upgradesight_mp'] = "CZ75 Upgraded Iron Sights";

//*********************
//Launchers
//*********************

//M72 LAW
$w['m72_law_mp'] = "M72 Law";

//RPG
$w['rpg_mp'] = "RPG-7";

//STRELA-3
$w['strela_mp'] = "Strela-3";

//CHINA LAKE
$w['china_lake_mp'] = "China Lake";

//GRIM REAPER
$w['m202_flash_mp'] = "Grim Reaper";

//*********************
//Specials
//*********************

//BALLISTIC KNIFE
$w['knife_ballistic_mp'] = "Ballistic Knife";

//CROSSBOW
$w['crossbow_explosive_mp'] = "Crossbow Explosive";
$w['crossbow_mp'] = "Crossbow";
$w['explosive_bolt_mp'] = "Crossbow Explosive";

//*********************
//Lethal
//*********************

//FRAG
$w['frag_grenade_mp'] = "Frag Grenade";

//SEMTEX
$w['sticky_grenade_mp'] = "Semtex";

//TOMAHAWK
$w['hatchet_mp'] = "Tomahawk";

//*********************
//Tactical
//*********************

//WILLY PETE
$w['willy_pete_mp'] = "Willy Pete";

//NOVA GAS
$w['tabun_gas_mp'] = "Nova Gas";

//FLASHBANG
$w['flash_grenade_mp'] = "Flashbang";

//CONCUSSION
$w['concussion_grenade_mp'] = "Concussion Grenade";


//*********************
//Equipment
//*********************

//C4
$w['satchel_charge_mp'] = "C4 Explosive";

//CLAYMORE
$w['claymore_mp'] = "Claymore";

//*********************
//Killstreaks
//*********************
$w['rcbomb_mp'] = "RC-XD Car";
$w['napalm_mp'] = "Napalm Strike";
$w['auto_gun_turret_mp'] = "Sentry Gun";
$w['supplydrop_mp'] = "Care Package";
$w['mortar_mp'] = "Mortar Strike";
$w['cobra_20mm_comlink_mp'] = "Attack Helicopter";
$w['m220_tow_mp'] = "Valkyrie Rockets";   
$w['airstrike_mp'] = "Rolling Thunder";
$w['huey_minigun_gunner_mp'] = "Chopper Gunner";
$w['dog_bite_mp'] = "Attack Dogs";
$w['hind_minigun_pilot_firstperson_m'] = "Gunship";
$w['hind_rockets_firstperson_mp'] = "Gunship Rockets";

//*********************
//Care Package
//*********************
$w['minigun_mp'] = "Death Machine";
$w['tow_turret_mp'] = "SAM Turret";

//*********************
//Grenade Launchers
//*********************
$w['gl_ak74u_mp'] = "AK74U Grenade Launcher";
$w['gl_famas_mp'] = "Famas Grenade Launcher";
$w['gl_ak47_mp'] = "AK47 Grenade Launcher";
$w['gl_fnfal_mp'] = "FN-FAL Grenade Launcher";
$w['gl_m16_mp'] = "M16 Grenade Launcher";
$w['gl_aug_mp'] = "AUG Grenade Launcher";
$w['gl_enfield_mp'] = "Enfield Grenade Launcher";
$w['gl_commando_mp'] = "Commando Grenade Launcher";
$w['gl_galil_mp'] = "Galil Grenade Launcher";
$w['gl_m14_mp'] = "M14 Grenade Launcher";

//*********************
//Flame Throwers
//*********************
$w['ft_ak47_mp'] = "AK47 Flame Thrower";
$w['ft_aug_mp'] = "AUG Flame Thrower";
$w['ft_commando_mp'] = "Commando Flame Thrower";
$w['ft_enfield_mp'] = "Enfield Flame Thrower";
$w['ft_famas_mp'] = "Famas Flame Thrower";
$w['ft_fnfal_mp'] = "FN-FAL Flame Thrower";
$w['ft_galil_mp'] = "Galil Flame Thrower";
$w['ft_m14_mp'] = "M14 Flame Thrower";
$w['ft_m16_mp'] = "M16 Flame Thrower";

//*********************
//Masterkey
//*********************
$w['mk_ak47_mp'] = "AK47 Masterkey";
$w['mk_aug_mp'] = "AUG Masterkey";
$w['mk_commando_mp'] = "Commando Masterkey";
$w['mk_enfield_mp'] = "Enfield Masterkey";
$w['mk_famas_mp'] = "Famas Masterkey";
$w['mk_fnfal_mp'] = "FN-FAL Masterkey";
$w['mk_galil_mp'] = "Galil Masterkey";
$w['mk_m14_mp'] = "M14 Masterkey";
$w['mk_m16_mp'] = "M16 Masterkey";

//*********************
//Misc
//*********************
$w['mod_melee'] = "Knife";
$w['defaultweapon_mp'] = "Default Weapon";
$w['destructible_car_mp'] = "Vehicle Explosion";
$w['explodable_barrel_mp'] = "Barrel Explosion";
$w['briefcase_bomb_mp'] = "Briefcase Bomb";
$w['mod_falling'] = "Falling";

//$w['nightingale_mp'] = ""; ???

//No weapon? 
$w['none'] = "Bad luck...";

//*********************
// Map names
//*********************
// Stock Blackops Maps
$m['mp_array'] = "Array";
$m['mp_cracked'] = "Cracked";
$m['mp_crisis'] = "Crisis";
$m['mp_firingrange'] = "Firing Range";
$m['mp_duga'] = "Grid";
$m['mp_hanoi'] = "Hanoi";
$m['mp_cairo'] = "Havana";
$m['mp_havoc'] = "Jungle";
$m['mp_cosmodrome'] = "Launch";
$m['mp_nuked'] = "Nuketown";
$m['mp_radiation'] = "Radiation";
$m['mp_mountain'] = "Summit";
$m['mp_villa'] = "Villa";
$m['mp_russianbase'] = "WMD";
$m['mp_stadium'] = "Stadium";
$m['mp_kowloon'] = "Kowloon";
$m['mp_discovery'] = "Discovery";
$m['mp_berlinwall2'] = "Berlin Wall";
$m['mp_gridlock'] = "Convoy";
$m['mp_hotel'] = "Hotel";
$m['mp_outskirts'] = "Stockpile";
$m['mp_zoo'] = "Zoo";

//*********************
// Event names
//*********************

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