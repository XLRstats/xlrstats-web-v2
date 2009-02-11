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
// Ranks based on kills
//*********************

$rankname[0] = "Private";
$killsneeded[0] = 0;
$rankimage[0] = "pvt.gif";

$rankname[1] = "Private First Class I";
$killsneeded[1] = 10;
$rankimage[1] = "1_star/1-pvt.gif";  

$rankname[2] = "Private First Class II";
$killsneeded[2] = 20;
$rankimage[2] = "2_stars/2-pvt.gif";   

$rankname[3] = "Lance Corporal";
$killsneeded[3] = 40;
$rankimage[3] = "Lance-Corporal.gif";  

$rankname[4] = "Lance Corporal I";
$killsneeded[4] = 80;
$rankimage[4] = "1_star/1-Lance-Corporal.gif";  

$rankname[5] = "Lance Corporal II";
$killsneeded[5] = 160;
$rankimage[5] = "2_stars/2-Lance-Corporal.gif";    

$rankname[6] = "Corporal";
$killsneeded[6] = 300;
$rankimage[6] = "copral.gif";   

$rankname[7] = "Corporal I";
$killsneeded[7] = 400;
$rankimage[7] = "1_star/1-copral.gif";   

$rankname[8] = "Corporal II";
$killsneeded[8] = 600;
$rankimage[8] = "2_stars/2-Lance-Corporal.gif";   

$rankname[9] = "Sergeant";
$killsneeded[9] = 900;
$rankimage[9] = "Sergeant.gif";   

$rankname[10] = "Sergeant I";
$killsneeded[10] = 1300;
$rankimage[10] = "1_star/1-Sergeant.gif";   

$rankname[11] = "Sergeant II";
$killsneeded[11] = 1800;
$rankimage[11] = "2_stars/2-Sergeant.gif";   

$rankname[12] = "Staff Sergeant";
$killsneeded[12] = 2400;
$rankimage[12] = "Staff-Sergeant.gif";  

$rankname[13] = "Staff Sergeant I";
$killsneeded[13] = 3000;
$rankimage[13] = "1_star/1-Staff-Sergeant.gif";    

$rankname[14] = "Staff Sergeant II";
$killsneeded[14] = 4000;
$rankimage[14] = "2_stars/2-Staff-Sergeant.gif";  

$rankname[15] = "Gunnery Sergeant";
$killsneeded[15] = 5000;
$rankimage[15] = "1_star/1-Staff-Sergeant.gif";   

$rankname[16] = "Gunnery Sergeant I";
$killsneeded[16] = 6000;
$rankimage[16] = "1_star/1-Staff-Sergeant.gif";   

$rankname[17] = "Gunnery Sergeant II";
$killsneeded[17] = 7000;
$rankimage[17] = "2_stars/2-Staff-Sergeant.gif";   

$rankname[18] = "Master Sergeant";
$killsneeded[18] = 8000;
$rankimage[18] = "Master-Sergeant.gif";   

$rankname[19] = "Master Sergeant I";
$killsneeded[19] = 9000;
$rankimage[19] = "1_star/1-Master-Sergeant.gif";   

$rankname[20] = "Master Sergeant II";
$killsneeded[20] = 10000;
$rankimage[20] = "2_stars/2-Master-Sergeant.gif";   

$rankname[21] = "Master Gunnery Sergeant";
$killsneeded[21] = 11000;
$rankimage[21] = "Master-Gunnery-Sergeant.gif"; 

$rankname[22] = "Master Gunnery Sergeant I";
$killsneeded[22] = 12000;
$rankimage[22] = "1_star/1-Master-Gunnery-Sergeant.gif"; 

$rankname[23] = "Master Gunnery Sergeant II";
$killsneeded[23] = 13000;
$rankimage[23] = "2_stars/2-Master-Gunnery-Sergeant.gif"; 

$rankname[24] = "2nd Lieutenant";
$killsneeded[24] = 14000;
$rankimage[24] = "Second-Lieutenant.gif";   

$rankname[25] = "2nd Lieutenant I";
$killsneeded[25] = 15000;
$rankimage[25] = "1_star/1-Second-Lieutenant.gif";   

$rankname[26] = "2nd Lieutenant II";
$killsneeded[26] = 16000;
$rankimage[26] = "2_stars/2-Second-Lieutenant.gif";   

$rankname[27] = "1st Lieutenant";
$killsneeded[27] = 17000;
$rankimage[27] = "First-Lieutenant.gif";   

$rankname[28] = "1st Lieutenant I";
$killsneeded[28] = 18000;
$rankimage[28] = "1_star/1-First-Lieutenant.gif";   

$rankname[29] = "1st Lieutenant II";
$killsneeded[29] = 19000;
$rankimage[29] = "2_stars/2-First-Lieutenant.gif";   

$rankname[30] = "Captain";
$killsneeded[30] = 20000;
$rankimage[30] = "Captain.gif"; 

$rankname[31] = "Captain I";
$killsneeded[31] = 21000;
$rankimage[31] = "1_star/1-Captain.gif"; 

$rankname[32] = "Captain II";
$killsneeded[32] = 22000;
$rankimage[32] = "2_stars/2-Captain.gif"; 

$rankname[33] = "Major";
$killsneeded[33] = 23000;
$rankimage[33] = "Major.gif";   

$rankname[34] = "Major I";
$killsneeded[34] = 24000;
$rankimage[34] = "1_star/1-Major.gif";   

$rankname[35] = "Major II";
$killsneeded[35] = 25000;
$rankimage[35] = "2_stars/2-Major.gif";   

$rankname[36] = "Lt. Colonel";
$killsneeded[36] = 26000;
$rankimage[36] = "Lieutenant-Colonel.gif";   

$rankname[37] = "Lt. Colonel I";
$killsneeded[37] = 27000;
$rankimage[37] = "1_star/1-Lieutenant-Colonel.gif";   

$rankname[38] = "Lt. Colonel II";
$killsneeded[38] = 28000;
$rankimage[38] = "2_stars/2-Lieutenant-Colonel.gif";   

$rankname[39] = "Colonel";
$killsneeded[39] = 29000;
$rankimage[39] = "Colonel.gif"; 

$rankname[40] = "Colonel I";
$killsneeded[40] = 30000;
$rankimage[40] = "1_star/1-Colonel.gif"; 

$rankname[41] = "Colonel II";
$killsneeded[41] = 31000;
$rankimage[41] = "2_stars/2-Colonel.gif"; 

$rankname[42] = "Brigadier General";
$killsneeded[42] = 32000;
$rankimage[42] = "Brigadier-General.gif";   

$rankname[43] = "Brigadier General I";
$killsneeded[43] = 33000;
$rankimage[43] = "1_star/1-Brigadier-General.gif";   

$rankname[44] = "Brigadier General II";
$killsneeded[44] = 34000;
$rankimage[44] = "2_stars/2-Brigadier-General.gif";    

$rankname[45] = "Major General";
$killsneeded[45] = 35000;
$rankimage[45] = "Major-General.gif";   

$rankname[46] = "Major General I";
$killsneeded[46] = 36000;
$rankimage[46] = "1_star/1-Major-General.gif";   

$rankname[47] = "Major General II";
$killsneeded[47] = 38000;
$rankimage[47] = "2_stars/2-Major-General.gif";   

$rankname[48] = "Lieutenant General";
$killsneeded[48] = 40000;
$rankimage[48] = "Lieutenant-General.gif";   

$rankname[49] = "Lieutenant General I";
$killsneeded[49] = 43000;
$rankimage[49] = "1_star/1-Lieutenant-General.gif";   

$rankname[50] = "Lieutenant General II";
$killsneeded[50] = 46000;
$rankimage[50] = "2_stars/2-Lieutenant-General.gif";   

$rankname[51] = "General";
$killsneeded[51] = 49000;
$rankimage[51] = "General.gif"; 

$rankname[52] = "General I";
$killsneeded[52] = 52000;
$rankimage[52] = "1_star/1-General.gif"; 

$rankname[53] = "General II";
$killsneeded[53] = 54000;
$rankimage[53] = "2_stars/2-General.gif";     

$rankname[54] = "Commander";
$killsneeded[54] = 60000;
$rankimage[54] = "Commander.gif";   

?>
