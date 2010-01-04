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
global $text;

//*********************
// Ranks based on kills
//*********************

$rankname[0] = $text["private"];
$killsneeded[0] = 0;
$rankimage[0] = "pvt.gif";

$rankname[1] = $text["privatefc1"];
$killsneeded[1] = 10;
$rankimage[1] = "1_star/1-pvt.gif";  

$rankname[2] = $text["privatefc2"];
$killsneeded[2] = 20;
$rankimage[2] = "2_stars/2-pvt.gif";   

$rankname[3] = $text["lancecorporal"];
$killsneeded[3] = 40;
$rankimage[3] = "Lance-Corporal.gif";  

$rankname[4] = $text["lancecorporal1"];
$killsneeded[4] = 80;
$rankimage[4] = "1_star/1-Lance-Corporal.gif";  

$rankname[5] = $text["lancecorporal2"];
$killsneeded[5] = 160;
$rankimage[5] = "2_stars/2-Lance-Corporal.gif";    

$rankname[6] = $text["corporal"];
$killsneeded[6] = 300;
$rankimage[6] = "copral.gif";   

$rankname[7] = $text["corporal1"];
$killsneeded[7] = 400;
$rankimage[7] = "1_star/1-copral.gif";   

$rankname[8] = $text["corporal2"];
$killsneeded[8] = 600;
$rankimage[8] = "2_stars/2-copral.gif";   

$rankname[9] = $text["sergeant"];
$killsneeded[9] = 900;
$rankimage[9] = "Sergeant.gif";   

$rankname[10] = $text["sergeant1"];
$killsneeded[10] = 1300;
$rankimage[10] = "1_star/1-Sergeant.gif";   

$rankname[11] = $text["sergeant2"];
$killsneeded[11] = 1800;
$rankimage[11] = "2_stars/2-Sergeant.gif";   

$rankname[12] = $text["staffsergeant"];
$killsneeded[12] = 2400;
$rankimage[12] = "Staff-Sergeant.gif";  

$rankname[13] = $text["staffsergeant1"];
$killsneeded[13] = 3000;
$rankimage[13] = "1_star/1-Staff-Sergeant.gif";    

$rankname[14] = $text["staffsergeant2"];
$killsneeded[14] = 4000;
$rankimage[14] = "2_stars/2-Staff-Sergeant.gif";  

$rankname[15] = $text["gunnerysergeant"];
$killsneeded[15] = 5000;
$rankimage[15] = "Gunnery-Sergeant.gif";   

$rankname[16] = $text["gunnerysergeant1"];
$killsneeded[16] = 6000;
$rankimage[16] = "1_star/1-Gunnery-Sergeant.gif";   

$rankname[17] = $text["gunnerysergeant2"];
$killsneeded[17] = 7000;
$rankimage[17] = "2_stars/2-Gunnery-Sergeant.gif";   

$rankname[18] = $text["mastersergeant"];
$killsneeded[18] = 8000;
$rankimage[18] = "Master-Sergeant.gif";   

$rankname[19] = $text["mastersergeant1"];
$killsneeded[19] = 9000;
$rankimage[19] = "1_star/1-Master-Sergeant.gif";   

$rankname[20] = $text["mastersergeant2"];
$killsneeded[20] = 10000;
$rankimage[20] = "2_stars/2-Master-Sergeant.gif";   

$rankname[21] = $text["mastergunsgt"];
$killsneeded[21] = 11000;
$rankimage[21] = "Master-Gunnery-Sergeant.gif"; 

$rankname[22] = $text["mastergunsgt1"];
$killsneeded[22] = 12000;
$rankimage[22] = "1_star/1-Master-Gunnery-Sergeant.gif"; 

$rankname[23] = $text["mastergunsgt2"];
$killsneeded[23] = 13000;
$rankimage[23] = "2_stars/2-Master-Gunnery-Sergeant.gif"; 

$rankname[24] = $text["2ndlieutenant"];
$killsneeded[24] = 14000;
$rankimage[24] = "Second-Lieutenant.gif";   

$rankname[25] = $text["2ndlieutenant1"];
$killsneeded[25] = 15000;
$rankimage[25] = "1_star/1-Second-Lieutenant.gif";   

$rankname[26] = $text["2ndlieutenant2"];
$killsneeded[26] = 16000;
$rankimage[26] = "2_stars/2-Second-Lieutenant.gif";   

$rankname[27] = $text["1stlieutenant"];
$killsneeded[27] = 17000;
$rankimage[27] = "First-Lieutenant.gif";   

$rankname[28] = $text["1stlieutenant1"];
$killsneeded[28] = 18000;
$rankimage[28] = "1_star/1-First-Lieutenant.gif";   

$rankname[29] = $text["1stlieutenant2"];
$killsneeded[29] = 19000;
$rankimage[29] = "2_stars/2-First-Lieutenant.gif";   

$rankname[30] = $text["captain"];
$killsneeded[30] = 20000;
$rankimage[30] = "Captain.gif"; 

$rankname[31] = $text["captain1"];
$killsneeded[31] = 21000;
$rankimage[31] = "1_star/1-Captain.gif"; 

$rankname[32] = $text["captain2"];
$killsneeded[32] = 22000;
$rankimage[32] = "2_stars/2-Captain.gif"; 

$rankname[33] = $text["major"];
$killsneeded[33] = 23000;
$rankimage[33] = "Major.gif";   

$rankname[34] = $text["major1"];
$killsneeded[34] = 24000;
$rankimage[34] = "1_star/1-Major.gif";   

$rankname[35] = $text["major2"];
$killsneeded[35] = 25000;
$rankimage[35] = "2_stars/2-Major.gif";   

$rankname[36] = $text["ltcolonel"];
$killsneeded[36] = 26000;
$rankimage[36] = "Lieutenant-Colonel.gif";   

$rankname[37] = $text["ltcolonel1"];
$killsneeded[37] = 27000;
$rankimage[37] = "1_star/1-Lieutenant-Colonel.gif";   

$rankname[38] = $text["ltcolonel2"];
$killsneeded[38] = 28000;
$rankimage[38] = "2_stars/2-Lieutenant-Colonel.gif";   

$rankname[39] = $text["colonel"];
$killsneeded[39] = 29000;
$rankimage[39] = "Colonel.gif"; 

$rankname[40] = $text["colonel1"];
$killsneeded[40] = 30000;
$rankimage[40] = "1_star/1-Colonel.gif"; 

$rankname[41] = $text["colonel2"];
$killsneeded[41] = 31000;
$rankimage[41] = "2_stars/2-Colonel.gif"; 

$rankname[42] = $text["brigadiergeneral"];
$killsneeded[42] = 32000;
$rankimage[42] = "Brigadier-General.gif";   

$rankname[43] = $text["brigadiergeneral1"];
$killsneeded[43] = 33000;
$rankimage[43] = "1_star/1-Brigadier-General.gif";   

$rankname[44] = $text["brigadiergeneral2"];
$killsneeded[44] = 34000;
$rankimage[44] = "2_stars/2-Brigadier-General.gif";    

$rankname[45] = $text["majorgeneral"];
$killsneeded[45] = 35000;
$rankimage[45] = "Major-General.gif";   

$rankname[46] = $text["majorgeneral1"];
$killsneeded[46] = 36000;
$rankimage[46] = "1_star/1-Major-General.gif";   

$rankname[47] = $text["majorgeneral2"];
$killsneeded[47] = 38000;
$rankimage[47] = "2_stars/2-Major-General.gif";   

$rankname[48] = $text["lieutenantgeneral"];
$killsneeded[48] = 40000;
$rankimage[48] = "Lieutenant-General.gif";   

$rankname[49] = $text["lieutenantgeneral1"];
$killsneeded[49] = 43000;
$rankimage[49] = "1_star/1-Lieutenant-General.gif";   

$rankname[50] = $text["lieutenantgeneral2"];
$killsneeded[50] = 46000;
$rankimage[50] = "2_stars/2-Lieutenant-General.gif";   

$rankname[51] = $text["general"];
$killsneeded[51] = 49000;
$rankimage[51] = "General.gif"; 

$rankname[52] = $text["general1"];
$killsneeded[52] = 52000;
$rankimage[52] = "1_star/1-General.gif"; 

$rankname[53] = $text["general2"];
$killsneeded[53] = 54000;
$rankimage[53] = "2_stars/2-General.gif";     

$rankname[54] = $text["commander"];
$killsneeded[54] = 60000;
$rankimage[54] = "Commander.gif";   

?>
