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

function displayadminheader()
{
  global $currentconfignumber; 

?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>XLRstats Administration Panel</title>
  <link href="../templates/admin/admin.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="../lib/tooltip/boxover.css" media="screen" />
  <script type="text/JavaScript" src="../lib/jquery-1.2.6.min.js"></script>
  <script type="text/JavaScript" src="../lib/tooltip/boxover.js"></script>
  <!-- Tooltip -->
  <script type="text/JavaScript">
  
  </script>
  <!-- Configpicker -->
  <script type="text/JavaScript">
    <!--\
    function XLR_configPicker(targ,selObj,restore){ //v3.0
      eval(targ+".location='"+"?config="+selObj.options[selObj.selectedIndex].value+"'");
      if (restore) selObj.selectedIndex=0;
    }
    function XLR_reloadPage(init) {  //reloads the window if Nav4 resized
      if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
        document.XLR_pgW=innerWidth; document.XLR_pgH=innerHeight; onresize=XLR_reloadPage; }}
      else if (innerWidth!=document.XLR_pgW || innerHeight!=document.XLR_pgH) location.reload();
    }
    XLR_reloadPage(true);
    //-->
    </script>
  <!-- Confirm Delete -->
  <script type="text/JavaScript">
    $(function() {
     $("a.delete-link").click(function() {
         return confirm("This will reset selected player's skill points to default value of 1000! Do you wish to continue");
     });
    });
  </script>

  </head>

  <body>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top" class="outertable"><table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td width="300" align="left" valign="middle" class="top"><a href="http://www.xlrstats.com" target="_blank"><img src="../templates/admin/admin-logo.png" width="295" height="90" border="0"/></a></td>
          <td width="70%" align="right" valign="bottom" class="topright">XLRstats Administration Panel</td>
        </tr>
      </table>
        <table class="topline" width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3"><img src="../images/spacer.gif" width="1" height="10" /></td>
          </tr>
          <tr>
            <td width="10">&nbsp;</td>
            <td align="left" class="link1"><a href="index2.php">Admin Home</a> | <a href="../index.php">Stats Home</a></td>
            <td align="right">
              <?php configpicker($cpath="../config") ?>
            </td>
          </tr>
          <tr>
            <td colspan="3"><img src="../images/spacer.gif" width="1" height="15" /></td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="10" cellspacing="0" class="midtable">
        <tr>
          <td>
<?php
}

function getservername()
{
  global $servernames;
  global $currentconfignumber;
  global $myserver;

  $myserver = $servernames[$currentconfignumber-1];
  
  echo "<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
            <tr>
              <td width=\"150\" align=\"left\" class=\"greytitle\">&nbsp;<img style=\"vertical-align: bottom;\" src=\"../templates/admin/admin-info.png\" width=\"16\" height=\"16\" />&nbsp;Server Name</td>
              <td align=\"left\" class=\"statstable\">$myserver</td>
            </tr>
          </table>
        ";
}

function xlrstatsversion($pop=1)
{
  $versionfile = abs_pathlink($pop) . "version.txt";
  if ( file_exists($versionfile) )
  {
    $lines = file($versionfile);
    $c = explode(":", $lines[0]);
    $version = trim($c[1]);
    $d = explode(":", $lines[1]);
    $date = trim($d[1]);
  }
  else
    $version = "Unknown Version";

  echo "<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
              <tr>
                <td width=\"150\" align=\"left\" class=\"greytitle\">&nbsp;<img src=\"../templates/admin/admin-info.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" />&nbsp;XLRstats Version</td>
                <td align=\"left\" class=\"statstable\">$version ( $date ) - ".checkupdate()."</td>
              </tr>
            </table>
        ";
}

function short_serverstats()
{
  global $b3_status_url;
  global $game;
  global $t;
  global $coddb;
  global $bp_head;

  $shortversion = "Unknown Server Version";

  if(@simplexml_load_file($b3_status_url)) //do we have a valid xml file?
  {
    $xml=new simpleXMLElement($b3_status_url,NULL,TRUE);

    foreach($xml->Game->Data as $serverdata)
    {
      if ($serverdata['Name'] == "shortversion")
        $shortversion = $serverdata['Value'];
    }
  }

  if ($game == 'cod1') $gamename = "Call of Duty";
  if ($game == 'coduo') $gamename = "Call of Duty: United Offensive";
  if ($game == 'cod2') $gamename = "Call of Duty 2";
  if ($game == 'cod4') $gamename = "Call of Duty 4: Modern Warfare";
  if ($game == 'codwaw') $gamename = "Call of Duty: World at War";
  if ($game == 'urt') $gamename = "Urban Terror";
  if ($game == 'q3a') $gamename = "Quake3";    
  if ($game == 'wop') $gamename = "World of Padman";
  if ($game == 'smg') $gamename = "Smokin' Guns";
  if (!isset($game)) $gamename = "Unknown Game";

  //find number of total players
  $query = " SELECT count( id ) AS players FROM ${t['b3_clients']} WHERE 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $players = $row['players'];

  //find number of registered players
  $query = " SELECT count( id ) AS players FROM ${t['b3_clients']} WHERE (group_bits > 0)";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $registered_players = $row['players'];

  //find total number of rounds
  $query = "SELECT SUM( rounds ) AS rounds FROM ${t['maps']} WHERE 1 ";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $rounds = $row['rounds'];

  //find total kills
  $query = "SELECT SUM( kills ) AS kills FROM ${t['players']} WHERE 1";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $kills = $row['kills'];

  //find total headshots
  $query = "SELECT SUM(kills) as kills FROM ${t['playerbody']} WHERE bodypart_id IN $bp_head";
  $result = $coddb->sql_query($query);
  $row = $coddb->sql_fetchrow($result);
  $headshots = $row['kills'];

			//find total time played*************** (TODO)

  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td><table width=\"180\" border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
                  <tr>
                    <td align=\"left\" class=\"admintab\">&nbsp;<img src=\"../templates/admin/admin_chart.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" />&nbsp;Short Server Stats</td>
                    <td align=\"left\"><img src=\"../templates/admin/admin-tab-right.png\" alt=\"\" width=\"6\" height=\"27\" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"5\" class=\"statstable\">
                  <tr>
                    <td align=\"left\"><span class=\"greyboldtxt\">Game</span></td>
                    <td align=\"left\">:<span class=\"bordotxt\"> $gamename</span></td>
                  </tr>
                  <tr>
                    <td align=\"left\"><span class=\"greyboldtxt\">Game Version</span></td>
                    <td align=\"left\">: <span class=\"bordotxt\">$shortversion</span></td>
                  </tr>
                  <tr>
                    <td class=\"greytitle\" colspan=\"2\" align=\"left\"><img src=\"../images/spacer.gif\" alt=\"\" width=\"1\" height=\"1\" /></td>
                  </tr>
                  <tr>
                    <td width=\"200\" align=\"left\"><span class=\"greyboldtxt\">Total Number of Players</span></td>
                    <td align=\"left\">: <span class=\"bordotxt\">$players</span></td>
                  </tr>
                  <tr>
                    <td align=\"left\"><span class=\"greyboldtxt\">Total Registered Players</span></td>
                    <td align=\"left\">: <span class=\"bordotxt\">$registered_players</span></td>
                  </tr>
                  <tr>
                    <td align=\"left\"><span class=\"greyboldtxt\">Number of Rounds Played</span></td>
                    <td align=\"left\">: <span class=\"bordotxt\">$rounds</span></td>
                  </tr>
                  <tr>
                    <td align=\"left\"><span class=\"greyboldtxt\">Total Kills</span></td>
                    <td align=\"left\">: <span class=\"bordotxt\">$kills</span></td>
                  </tr>
                  <tr>
                    <td align=\"left\" class=\"greyboldtxt\">Total Headshots</td>
                    <td align=\"left\">: <span class=\"bordotxt\">$headshots</span></td>
                  </tr>
                  <!-- <tr>
                    <td align=\"left\"><span class=\"greyboldtxt\">Total Time Played</span></td>
                    <td align=\"left\">: <span class=\"bordotxt\">TODO</span></td>
                  </tr> -->
                </table></td>
              </tr>
            </table>
  ";

}

function tasks_menu()
{
  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td><table width=\"200\" border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
                  <tr>
                    <td align=\"left\" valign=\"middle\" class=\"admintab\">&nbsp;<img src=\"../templates/admin/admin-tasks.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" />&nbsp;Tasks</td>
                    <td align=\"left\"><img src=\"../templates/admin/admin-tab-right.png\" alt=\"\" width=\"6\" height=\"27\" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"statstable\">
                  <tr>
                    <td align=\"left\"><img src=\"../templates/admin/admin-settings.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" />&nbsp;<span class=\"link1\"><a href=\"index2.php?func=settings\">Change XLRstats Settings for This Server</a></span></td>
                  </tr>
                  <tr>
                    <td align=\"left\"><img src=\"../templates/admin/admin-players.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" /><span class=\"link1\"><a href=\"index2.php?func=players\">&nbsp;Player Specific Tasks</a></span></td>
                  </tr>
                  <tr>
                    <td align=\"left\"><img src=\"../templates/admin/admin-award.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" />&nbsp;<span class=\"link1\"><a href=\"index2.php?func=awards\">Refresh Awards</a></span></td>
                  </tr>
                  <tr>
                    <td align=\"left\"><img src=\"../templates/admin/admin-delete.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" />&nbsp;<span class=\"link1\"><a href=\"index2.php?func=deleteserver\">Delete This Server</a></span></td>
                  </tr>
                  <tr>
                    <td align=\"left\"><img src=\"../templates/admin/admin_database_remove.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" />&nbsp;<span class=\"link1\"><a href=\"index2.php?func=resetdb\">Empty Database</a></span></td>
                  </tr>
                </table></td>
              </tr>
            </table>
  ";
}

function server_settings()
{
  global $game;
  global $public_ip;
  global $b3_status_url;
  global $mysiteurl;
  global $mysitelinkname;
  global $template;
  global $sig;
  global $statstitle;
  global $teambased;
  global $actionbased;
  global $toplist_max;
  global $maplist_max;
  global $weaplist_max;
  global $separatorline;
  global $toplist_block;
  global $user_length;
  global $minkills;
  global $minrounds;
  global $exclude_ban;
  global $ShowRatioGraph;
  global $MaxKillRatio;
  global $maxdays;
  global $map_minkills;
  global $map_minrounds;
  global $weap_minkills;
  global $aliashide_level;
  global $limitplayerstats;
  global $enemies_max;
  global $showclansearch;
  global $use_localtime;
  global $useppllist;
  global $pll_noteams;
  global $stylepicker;
  global $disable_configpicker;
  global $use_geoip;
  global $geoip_path;
  global $debug;
  global $award_cache_time;
  
  echo "<div align=\"left\" class=\"smalltxt_bold\">TIP: Click on \"Question Marks\" for explanations.</div><p>";

  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
              <td><table border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
                <tr>
                  <td class=\"admintab\">&nbsp;<img style=\"vertical-align: bottom;\" src=\"../templates/admin/admin-settings.png\" width=\"16\" height=\"16\" />&nbsp;Basic XLRstats Settings&nbsp;</td>
                  <td align=\"left\"><img src=\"../templates/admin/admin-tab-right.png\" alt=\"\" width=\"6\" height=\"27\" /></td>
                </tr>
              </table></td>
            </tr>
            <form action=\"index2.php?func=save\" method=\"POST\">
              <tr>
                <td valign=\"top\"><table class=\"statstable\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                  <tr>
                    <td><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>What game? (urt, cod1, coduo, cod2, cod4, codwaw, wop, smg)</span>] requireclick=[on]\" /></td>
                        <td width=\"25%\" class=\"smalltxt_bold\">Game Name:</td>";

  $gamelist = array( 
                     "urt" => "Urban Terror",
                     "cod1" => "Call of Duty",
                     "coduo" => "Call of Duty UO",
                     "cod2" => "Call of Duty 2",
                     "cod4" => "Call of Duty 4: MW",
                     "codwaw" => "Call of Duty: WaW",
                     "wop" => "World of Padman",
                     "smg" => "Smokin' Guns"
                    );

  echo "<td width=\"25%\" class=\"smalltxt\"><label>
        <select name=\"game\" class=\"smalltxt\" id=\"game\">\n";

  //display gamelist and select current game
  foreach ($gamelist as $key => $value)
  {
    if ($game == $key)
      echo "<option value=\"$key\" selected=\"selected\">$value</option>\n";
    else
      echo "<option value=\"$key\">$value</option>\n";
  }

  echo "                  </select>
                        </label></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>You must have php version 4.3.2 or newer with php4-gd extension installed!</span>] requireclick=[on]\" /></td>
                        <td width=\"25%\" class=\"smalltxt\"><strong class=\"fontNormal\">Do you want to use Signature Module?:</strong></td>
                        <td width=\"25%\" class=\"smalltxt\"><label>
                          <input type=\"radio\" name=\"sig\" value=\"1\" id=\"sig_1\"".(($sig==1)? "checked=\"checked\"" : '')." />
                          Yes</label>
                          <label>
                            <input name=\"sig\" type=\"radio\" class=\"smalltxt\" id=\"sig_0\" value=\"0\"".(($sig==0)? "checked=\"checked\"" : '')." />
                            No</label></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter the public IP of the server</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><strong class=\"fontNormal\">Public IP:</strong></td>
                        <td class=\"smalltxt\"><label>
                          <input name=\"public_ip\" type=\"text\" class=\"smalltxt\" id=\"public_ip\" value=\"$public_ip\"/>
                        </label></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter title of the statistics pages.</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt\"><strong>Title of the statistics pages:</strong></td>
                        <td class=\"smalltxt\"><input name=\"statstitle\" type=\"text\" class=\"smalltxt\" id=\"statstitle\" value=\"$statstitle\"/></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>This is the path where B3 stores the status.xml file. May be an absolute path or an URL. (Use forward slashes / only!) ie.: /var/www/status/status.xml or http://www.yourwebsite.com/status/urt1.xml</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><strong class=\"fontNormal\">B3 Status URL:</strong></td>
                        <td class=\"smalltxt\"><label>
                          <input name=\"b3_status_url\" type=\"text\" class=\"smalltxt\" id=\"b3_status_url\" value=\"$b3_status_url\"/>
                        </label></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Does this server run teambased games? (For teamkill and teamdeath awards)</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><strong>Teambased games?</strong></td>
                        <td class=\"smalltxt\"><p>
                          <label>
                            <input name=\"teambased\" type=\"radio\" id=\"teambased_1\" value=\"1\"".(($teambased==1)? "checked=\"checked\"" : '')." />
                            Yes</label>
                          <label>
                            <input type=\"radio\" name=\"teambased\" value=\"0\" id=\"teambased_0\"".(($teambased==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          <br />
                        </p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>URL (without the http:// part!) . Leave blank if you dont want a link to a homepage included.</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><strong class=\"fontNormal\">URL to Your Website:</strong></td>
                        <td class=\"smalltxt\"><label>
                          <input name=\"mysiteurl\" type=\"text\" class=\"smalltxt\" id=\"mysiteurl\" value=\"$mysiteurl\"/>
                        </label></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Does this server run action based games like Search and Destroy, Capture the Flag etc? (For Action Stats)</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><strong>Actionbased games?</strong></td>
                        <td class=\"smalltxt\"><p>
                          <label>
                            <input name=\"actionbased\" type=\"radio\" id=\"actionbased_1\" value=\"1\"".(($actionbased==1)? "checked=\"checked\"" : '')." />
                            Yes</label>
                          <label>
                            <input type=\"radio\" name=\"actionbased\" value=\"0\" id=\"actionbased_0\"".(($actionbased==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          <br />
                        </p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Short name that appears in navigation to describe the link back to your site</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><strong class=\"fontNormal\">Link Name to Your Website:</strong></td>
                        <td class=\"smalltxt\"><label>
                          <input name=\"mysitelinkname\" type=\"text\" class=\"smalltxt\" id=\"mysitelinkname\" value=\"$mysitelinkname\"/>
                        </label></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want to use GeoIP information in playerpages?</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><strong>Use GeoIP?</strong></td>
                        <td class=\"smalltxt\"><p>
                          <label>
                            <input name=\"use_geoip\" type=\"radio\" id=\"use_geoip_1\" value=\"1\"".(($use_geoip==1)? "checked=\"checked\"" : '')." />
                            Yes</label>
                          <label>
                            <input type=\"radio\" name=\"use_geoip\" value=\"0\" id=\"use_geoip_0\"".(($use_geoip==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          <br />
                          </p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Which template do you want to use?</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\">Template</td>
                        <td class=\"smalltxt\"><label>
                          <select name=\"template\" class=\"smalltxt\" id=\"template\">";

  list_templates($template);

  echo "                  </select>
                        </label></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter GeoIP path here if you want to use GeoIP</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><strong>GeoIP Path</strong></td>
                        <td class=\"smalltxt\"><label>
                          <input name=\"geoip_path\" type=\"text\" class=\"smalltxt\" id=\"geoip_path\" value=\"$geoip_path\"/>
                          </label></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td valign=\"top\">&nbsp;</td>
              </tr>
              <tr>
                <td valign=\"top\"><table border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
                  <tr>
                    <td class=\"admintab\">&nbsp;<img src=\"../templates/admin/admin-settings.png\" alt=\"\" width=\"16\" height=\"16\" style=\"vertical-align: bottom;\" />&nbsp;Adanced XLRstats Settings&nbsp;</td>
                    <td align=\"left\"><img src=\"../templates/admin/admin-tab-right.png\" alt=\"\" width=\"6\" height=\"27\" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td valign=\"top\"><table class=\"statstable\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                  <tr>
                    <td><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter the number of players you want to list under 'Top Skill', 'Top Kills' and 'Top Ratio' sections</span>] requireclick=[on]\" /></td>
                        <td width=\"25%\" class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Number of Players to list in Top Lists</strong></span></td>
                        <td width=\"25%\" class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"toplist_max\" type=\"text\" class=\"smalltxt\" id=\"toplist_max\" value=\"$toplist_max\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter minimum amount of rounds before a player is included in the mainpage player statistics and awards</span>] requireclick=[on]\" /></td>
                        <td width=\"25%\" class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Minimum Map Rounds</strong></span></td>
                        <td width=\"25%\" ><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"map_minrounds\" type=\"text\" class=\"smalltxt\" id=\"map_minrounds\" value=\"$minrounds\" />
                          </label>
                        </span></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter the number of maps you want to list under 'Top Maps' section</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Number of Maps to list in Top Maps Lists</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"maplist_max\" type=\"text\" class=\"smalltxt\" id=\"maplist_max\" value=\"$maplist_max\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter minimum kills before a player is displayed on weapon-page</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Minimum Weapon Kills</strong></span></td>
                        <td><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"weap_minkills\" type=\"text\" class=\"smalltxt\" id=\"weap_minkills\" value=\"$weap_minkills\" />
                          </label>
                        </span></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter the number of weapons you want to list under 'Top Weapons' section</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Number of Weapons to list in Top Weapons Lists</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"weaplist_max\" type=\"text\" class=\"smalltxt\" id=\"weaplist_max\" value=\"$weaplist_max\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Minimum grouplevel to hide aliases on playerpages, this will show aliases for players with a lower level. Disable aliases by setting it to 0</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Alias Hide Level</strong></span></td>
                        <td><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"aliashide_level\" type=\"text\" class=\"smalltxt\" id=\"aliashide_level\" value=\"$aliashide_level\" />
                          </label>
                        </span></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want to draw a 1 pixel separator line in the toplist between rows?</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Separator Line</strong></span></td>
                        <td class=\"smalltxt\"><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input name=\"separatorline\" type=\"radio\" id=\"SeparatorLine_1\" value=\"1\"".(($separatorline==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <input type=\"radio\" name=\"separatorline\" value=\"0\" id=\"SeparatorLine_0\"".(($separatorline==0)? "checked=\"checked\"" : '')." />
                          No</span><span class=\"smalltxt_bold\"><br />
                          </span></p></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want to limit playerspecific stats for unregistered players</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Limit Player Stats</strong></span></td>
                        <td><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input name=\"limitplayerstats\" type=\"radio\" id=\"limitplayerstats_1\" value=\"1\"".(($limitplayerstats==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <label>
                            <input type=\"radio\" name=\"limitplayerstats\" value=\"0\" id=\"limitplayerstats_0\"".(($limitplayerstats==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          </span><span class=\"smalltxt_bold\"><br />
                          </span></p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter number of players in block.php an inclusion file for websites</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Number of Players in block.php</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"toplist_block\" type=\"text\" class=\"smalltxt\" id=\"toplist_block\" value=\"$toplist_block\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter number of worst enemies in personal playerpages</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Enemies Maximum</strong></span></td>
                        <td><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"enemies_max\" type=\"text\" class=\"smalltxt\" id=\"enemies_max\" value=\"$enemies_max\" />
                          </label>
                        </span></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter number of characters in username (block) before breaking off</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Number of characters in username</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"user_length\" type=\"text\" class=\"smalltxt\" id=\"user_length\" value=\"$user_length\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want a Clan search filter on the index page?</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Clan Search</strong></span></td>
                        <td><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input name=\"showclansearch\" type=\"radio\" id=\"showclansearch_1\" value=\"1\"".(($showclansearch==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <label>
                            <input type=\"radio\" name=\"showclansearch\" value=\"0\" id=\"showclansearch_0\"".(($showclansearch==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          </span><span class=\"smalltxt_bold\"><br />
                          </span></p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter minimum amount of kills before a player is included in the mainpage player statistics and awards</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Minimum Kills</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"minkills\" type=\"text\" class=\"smalltxt\" id=\"minkills\" value=\"$minkills\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want to display times for your local timezone?</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Use Localtime</strong></span></td>
                        <td><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input name=\"use_localtime\" type=\"radio\" id=\"use_localtime_1\" value=\"1\"".(($use_localtime==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <label>
                            <input type=\"radio\" name=\"use_localtime\" value=\"0\" id=\"use_localtime_0\"".(($use_localtime==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          </span><span class=\"smalltxt_bold\"><br />
                          </span></p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter minimum amount of rounds before a player is included in the mainpage player statistics and awards</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Minimum Rounds</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"minrounds\" type=\"text\" class=\"smalltxt\" id=\"minrounds\" value=\"$minrounds\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want to display current player list?</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Show Current Player List?</strong></span></td>
                        <td><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input name=\"useppllist\" type=\"radio\" id=\"useppllist_1\" value=\"1\"".(($useppllist==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <label>
                            <input type=\"radio\" name=\"useppllist\" value=\"0\" id=\"useppllist_0\"".(($useppllist==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          </span><span class=\"smalltxt_bold\"><br />
                          </span></p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want to exclude currently banned player from top lists and ranking?</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Exclude Banned Player?</strong></span></td>
                        <td class=\"smalltxt\"><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input name=\"exclude_ban\" type=\"radio\" id=\"exlude_ban_1\" value=\"1\"".(($exclude_ban==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <label>
                            <input type=\"radio\" name=\"exclude_ban\" value=\"0\" id=\"exlude_ban_0\"".(($exclude_ban==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          </span><span class=\"smalltxt_bold\"><br />
                          </span></p></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want to display teams in current player list?</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Show Teams?</strong></span></td>
                        <td><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input name=\"pll_noteams\" type=\"radio\" id=\"pll_noteams_1\" value=\"1\"".(($pll_noteams==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <label>
                            <input name=\"pll_noteams\" type=\"radio\" id=\"pll_noteams_0\" value=\"0\"".(($pll_noteams==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          </span><span class=\"smalltxt_bold\"><br />
                          </span></p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Select how you want to display the ratio bar</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Ratio Graph</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <select name=\"ShowRatioGraph\" class=\"smalltxt\" id=\"ShowRatioGraph\">";

  $ratio_graph_options = array("Values Only", "Inline Bar", "Double Bar", "Simple Inline Bar");

  //list ratio graph options
  foreach ($ratio_graph_options as $key => $value)
  {
    if ($ShowRatioGraph == $key)
      echo "<option value=\"$key\" selected=\"selected\">$value</option>\n";
    else
      echo "<option value=\"$key\">$value</option>\n";
  }

  echo "                   </select>
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Do you want to display stylepicker?</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Show Stylepicker?</strong></span></td>
                        <td><span class=\"smalltxt_bold\">
                          <label>
                            <select name=\"stylepicker\" class=\"smalltxt\" id=\"stylepicker\">";

  $stylepicker_options = array(
                               "0" => "No",
                               "left" => "Show at Left",
                               "right" => "Show at Right",
                               "footer" => "Show at Footer"
                              );

  //list stylepicker options
  foreach ($stylepicker_options as $key => $value)
  {
    if ($stylepicker == $key)
      echo "<option value=\"$key\" selected=\"selected\">$value</option>\n";
    else
      echo "<option value=\"$key\">$value</option>\n";
  }

  echo "                    </select>
                          </label>
                        </span></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>For the ratio bar - leave at 0 for automatic detection of the maximum ratio</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Maximum Kill Ratio</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"MaxKillRatio\" type=\"text\" class=\"smalltxt\" id=\"MaxKillRatio\" value=\"$MaxKillRatio\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Disable the config selector, even though we have set up multi configs (ie if we want to deeplink to each config/server from our homepage)</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Disable Config Selector?</strong></span></td>
                        <td><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input type=\"radio\" name=\"disable_configpicker\" value=\"1\" id=\"disable_configpicker_1\"".(($disable_configpicker==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <label>
                            <input name=\"disable_configpicker\" type=\"radio\" id=\"disable_configpicker_0\" value=\"0\"".(($disable_configpicker==0)? "checked=\"checked\"" : '')." />
                            No</label>
                          </span><span class=\"smalltxt_bold\"><br />
                          </span></p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter number of days a player is still displayed if he/she hasn't played anymore</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Maximum Days</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"maxdays\" type=\"text\" class=\"smalltxt\" id=\"maxdays\" value=\"$maxdays\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Selecting 'Yes' will enable all php-error reporting and phpinfo to show for debugging purposes. If you find that your XLRstats is okay, set it to 0. If you need support make sure you set this to 1 before posting requests in the support forums.</span>] requireclick=[on]\" /></td>
                        <td class=\"fontNormal\"><span class=\"smalltxt_bold\"><strong>Show Debuggin Info?</strong></span></td>
                        <td><p>
                          <label>
                            <span class=\"smalltxt\">
                            <input name=\"debug\" type=\"radio\" id=\"debug_1\" value=\"1\"".(($debug==1)? "checked=\"checked\"" : '')." />
                            Yes</span></label>
                          <span class=\"smalltxt\">
                          <input type=\"radio\" name=\"debug\" value=\"0\" id=\"debug_0\"".(($debug==0)? "checked=\"checked\"" : '')." />
                          No</span></p></td>
                        </tr>
                      <tr align=\"left\">
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>Enter minimum kills before a player is displayed on map-page</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\"><span class=\"smalltxt_bold\"><strong>Minimum Map Kills</strong></span></td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"map_minkills\" type=\"text\" class=\"smalltxt\" id=\"map_minkills\" value=\"$map_minkills\" />
                          </label>
                        </span></td>
                        <td width=\"5\"><img src=\"../templates/admin/tip.png\" style=\"vertical-align: top; cursor:pointer;\" title=\"cssbody=[admin-bdy] header=[] body=[<span class=admin-txt>How long (in seconds) to cache awards, lower = slower.</span>] requireclick=[on]\" /></td>
                        <td class=\"smalltxt_bold\">Award Cache Time (second)</td>
                        <td class=\"smalltxt\"><span class=\"smalltxt_bold\">
                          <label>
                            <input name=\"award_cache_time\" type=\"text\" class=\"smalltxt\" id=\"award_cache_time\" value=\"$award_cache_time\" />
                          </label>
                        </span></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\">
                  <tr>
                    <td>&nbsp;</td>
                    <td width=\"80\" align=\"center\" valign=\"middle\">&nbsp;</td>
                    <td width=\"80\" align=\"center\" valign=\"middle\"><a href=\"#\">
                      <label>
                        <input name=\"save\" type=\"submit\" class=\"line1\" id=\"save\" value=\"Save\" />
                      </label>
                    </a></td>
                  </tr>
                </table></td>
              </tr>
            </form>
          </table>
  ";
  
}

function save_server_settings()
{
  global $currentconfignumber;
  global $myserver;

  $game = $_POST['game'];
  $public_ip = $_POST['public_ip'];
  $b3_status_url = $_POST['b3_status_url'];
  $mysiteurl = $_POST['mysiteurl'];
  $mysitelinkname = $_POST['mysitelinkname'];
  $template = $_POST['template'];
  $sig = $_POST['sig'];
  $statstitle = $_POST['statstitle'];
  $teambased = $_POST['teambased'];
  $actionbased = $_POST['actionbased'];
  $use_geoip = $_POST['use_geoip'];
  $geoip_path = $_POST['geoip_path'];

  $toplist_max = $_POST['toplist_max'];
  $maplist_max = $_POST['maplist_max'];
  $weaplist_max = $_POST['weaplist_max'];
  $separatorline = $_POST['separatorline'];
  $toplist_block = $_POST['toplist_block'];
  $user_length = $_POST['user_length'];
  $minkills = $_POST['minkills'];
  $minrounds = $_POST['minrounds'];
  $exclude_ban = $_POST['exclude_ban'];
  $ShowRatioGraph = $_POST['ShowRatioGraph'];
  $MaxKillRatio = $_POST['MaxKillRatio'];
  $maxdays = $_POST['maxdays'];
  $map_minkills = $_POST['map_minkills'];
  $map_minrounds = $_POST['map_minrounds'];
  $weap_minkills = $_POST['weap_minkills'];
  $aliashide_level = $_POST['aliashide_level'];
  $limitplayerstats = $_POST['limitplayerstats'];
  $enemies_max = $_POST['enemies_max'];
  $showclansearch = $_POST['showclansearch'];
  $use_localtime = $_POST['use_localtime'];
  $useppllist = $_POST['useppllist'];
  $pll_noteams = $_POST['pll_noteams'];
  $stylepicker = $_POST['stylepicker'];
  $disable_configpicker = $_POST['disable_configpicker'];
  $debug = $_POST['debug'];
  $award_cache_time = $_POST['award_cache_time'];


    $file_path = "../config/statsconfig$currentconfignumber.php";
    array_pop($_POST); //get rid of the last value "yes" created by Yes button
    foreach($_POST as $key=>$value)
    {
      $target_vars [] = "$".$key; //variables we'll look for and eventually change in statsconfig.php
      $source_vars [] = $value;  //our new values
    }

    if(!$configfile = file_get_contents($file_path))  //send the contents of the config file into a string
      die("Cannot open statsconfig$currentconfignumber.php! Make sure file exists and/or readable by the webserver");

    for($i=0; $i<count($target_vars); $i++)
    {
      $startpoint = strpos($configfile, $target_vars[$i]);  //find starting position of the target_var 
      $temp_str = substr($configfile, $startpoint); //create a temporary string starting with our target_var
      $endpoint = strpos($temp_str, ";"); //find the ending position of our target_var's currently assigned value, that's the length of our target
      $output = substr($configfile, $startpoint,  $endpoint);  //this is our target line we'll replace soon
      $replacement = "$target_vars[$i] = \"$source_vars[$i]\"";

      if(!$fp = fopen($file_path, "w+"))
        die("Cannot create file statsconfig$currentconfignumber.php! Make sure \"config\" directory is writable!");
      $configfile = str_replace($output, $replacement, $configfile); //we replace the target lines
      fwrite($fp, $configfile);
      fclose($fp);
    }

    //successfull save message
    echo "<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"success\">
          <tr>
            <td width=\"50\" align=\"left\" valign=\"middle\"><img src=\"../../xlrstats-dev/templates/admin/admin-accepted.png\" width=\"48\" height=\"48\" style=\"vertical-align:middle\" /></td>
            <td align=\"left\" valign=\"middle\">XLRstats Settings for ".((isset($myserver)) ? $myserver : "your server")." changed successfully!</td>
            </tr>
          <tr>
            <td align=\"left\" valign=\"middle\">&nbsp;</td>
            <td align=\"left\" valign=\"middle\">
              <input name=\"adminhome\" type=\"submit\" id=\"adminhome\" value=\"Admin Home\" onclick=\"window.location.href='index2.php'\"/>
              </td>
            </tr>
        </table>
        ";

}

function list_players()
{
  global $t;
  global $coddb;

  echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
              <td align=\"left\">This is a simple tool for  XLRstats specific player settings. 
          If you're looking for a better solution  to adminster your playercrowd  via a web panel, 
          use our <span class=\"link1\"><a href=\"http://www.bigbrotherbot.com/forums/downloads/?sa=view;down=11\" target=\"_blank\" class=\"players\">Echelon Web Investigation Tool
          </a></span><br /><br />
          <div align =\"left\" class=\"info\"><img src=\"../../xlrstats-dev/templates/admin/admin-lightbulb.png\" width=\"32\" height=\"32\" style=\"vertical-align:middle\" />
          Note that reset button will only reset the player's skill to 1000 while all other information remains intact!</div>
           <br /><br />
           </td>
            </tr>
            <tr>
              <td><table border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\">
                <tr>
                  <td class=\"admintab\">&nbsp;<img style=\"vertical-align: bottom;\" src=\"../templates/admin/admin-players.png\" width=\"16\" height=\"16\" />&nbsp;Player Specific Tasks&nbsp;</td>
                  <td align=\"left\"><img src=\"../templates/admin/admin-tab-right.png\" alt=\"\" width=\"6\" height=\"27\" /></td>
                </tr>
              </table></td>
            </tr>
             <tr>
                <td valign=\"top\"><table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"statstable\">
                  <tr>
                    <td align=\"left\">
                      <form id=\"form2\" name=\"form2\" method=\"POST\" action=\"index2.php?func=players\">
                      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
                       <tr>
                       <td>
                        Filter by Player Name 
                        <label>
                          <input type=\"text\" name=\"playername\" id=\"playername\" />
                        </label>
                        <label>
                          <input type=\"submit\" name=\"filter\" id=\"filter\" value=\"Filter\" />
                        </label>
  ";

  //display "list all" button if filter is used
  if(isset($_POST['playername']))
  {
    if($_POST['playername'] != "")
    {
      echo "<label><input type=\"button\" name=\"listall\" id=\"listall\" value=\"List All\" onclick=\"window.location.href='index2.php?func=players'\"/></label>";
    }
  }

  echo "</td>
           </tr>
         </table>
       </form></td>
     </tr>";

  $playername = "";
  if(isset($_POST['playername']))
    $playername = $_POST['playername'];

  //for pagination
  $pagenumber = 1;
  if(isset($_GET['pagenumber']))
    $pagenumber = escape_string($_GET['pagenumber']);

  $rowsPerPage = 20;
  $offset = ($pagenumber-1)*$rowsPerPage;

  //get a list of players in xlr_playerstats table
  $query = "SELECT ${t['players']}.id, ${t['b3_clients']}.id AS dbID, ${t['b3_clients']}.ip, ${t['b3_clients']}.name, ${t['b3_clients']}.group_bits, ${t['b3_clients']}.connections, ${t['b3_clients']}.time_add, ${t['b3_clients']}.time_edit, ${t['players']}.hide
            FROM ${t['b3_clients']}, ${t['players']}
            WHERE (${t['b3_clients']}.id = ${t['players']}.client_id) AND ${t['b3_clients']}.name LIKE '%$playername%'
            ORDER BY ${t['players']}.id ASC";

  $result1 = $coddb->sql_query($query);
  $numRows = $coddb->sql_numrows($result1);
  $query .= " LIMIT $offset, $rowsPerPage";

  $result = $coddb->sql_query($query);

  //display a warning message if player list is empty
  if(!$row = $coddb->sql_fetchrow($result))
  {
    if(isset($_POST['filter'])) //if filtering result is empty
    {
      echo "<td><table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"alert\">
              <tr>
                <td width=\"50\" align=\"center\" valign=\"middle\"><img src=\"../templates/admin/admin-warning.png\" width=\"48\" height=\"48\" /></td>
                <td align=\"left\">No Player Name Containing the Key Word \"$playername\" Found!</td>
              </tr></table></td>"; 
      return;
    }
    else //default empty message
    {
      echo "<td><table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"alert\">
              <tr>
                <td width=\"50\" align=\"center\" valign=\"middle\"><img src=\"../templates/admin/admin-warning.png\" width=\"48\" height=\"48\" /></td>
                <td align=\"left\">No Players Found in Database!</td>
              </tr></table></td>"; 
      return;
    }
  }

  echo "<tr>
         <td><table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" class=\"players\">
           <tr class=\"smalltxt_bold\">
             <th scope=\"col\">ID</th>
             <th scope=\"col\">dbID</th>
             <th scope=\"col\">Name</th>
             <th scope=\"col\">Level</th>
             <th scope=\"col\">Connections</th>
             <th scope=\"col\">First Seen</th>
             <th scope=\"col\">Last Seen</th>
             <th scope=\"col\">Status</th>
             <th scope=\"col\">Reset</th>
           </tr>
  ";

  $result2 = $coddb->sql_query($query);

  while ($row = $coddb->sql_fetchrow($result2))
  {
    $id = $row['id'];
    $dbid = $row['dbID'];
    $ip = $row['ip'];
    $name = $row['name'];
    $level = $row['group_bits'];
    $connections = $row['connections'];
    $firstseen = $row['time_add'];
    $lastseen = $row['time_edit'];
    $status = $row['hide'];

    /*
    $query = "SELECT name FROM ${t['b3_groups']} WHERE id = $level";
    $result = $coddb->sql_query($query);
    $row = $coddb->sql_fetchrow($result);
    $level = $row['name'];
    */

    echo "<tr>
           <td align=\"left\">$id</td>
           <td align=\"left\">$dbid</td>
           <td align=\"left\">$name</td>
           <td align=\"left\">".client_level($level)."</td>
           <td align=\"center\">$connections</td>
           <td align=\"left\">".date('l, d/m/Y (H:i)',$firstseen)."</td>
           <td align=\"left\">".date('l, d/m/Y (H:i)',$lastseen)."</td>";

    if($status == 1)
      echo "<td align=\"center\" valign=\"middle\"><a href=\"index2.php?func=showhidestats&id=$id&action=show\"><img style=\"border:none\" src=\"../templates/admin/admin-hidden.png\"/ title=\"Click to Show Stats for $name\"></a></td>";
    if($status == 0)
      echo "<td align=\"center\" valign=\"middle\"><a href=\"index2.php?func=showhidestats&id=$id&action=hide\"><img style=\"border:none\" src=\"../templates/admin/admin-accept.png\" title=\"Click to Hide Stats for $name\"/></a></td>";

    echo "<td align=\"center\" valign=\"middle\"><a href=\"index2.php?func=resetskill&id=$id\" class=\"delete-link\"><img style=\"border:none\" src=\"../templates/admin/admin-cross.png\"/ title=\"Click to Reset Skill Points for $name\"></a></td>
         </tr>
    ";
  }

  echo "</table>
         <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">";

  nextprevButtons($numRows, $rowsPerPage, "index2.php?func=players"); //print next-prev butons

  echo "</table></td>
          </tr>
           </table></td>
            </tr>
         </table>";

}

function show_hide_playerstats()
{
  global $db_db;
  global $t;

  $action = $_GET['action'];
  $id = $_GET['id'];

  if($action == "show")
  {
    $query = "UPDATE $db_db.${t['players']} SET hide = 0 WHERE ${t['players']}.id = $id LIMIT 1";
    if (!mysql_query($query))
      die (mysql_error());
  }

  if($action == "hide")
  {
    $query = "UPDATE $db_db.${t['players']} SET hide = 1 WHERE ${t['players']}.id = $id LIMIT 1";
    if (!mysql_query($query))
      die (mysql_error());
  }

  echo "<script>";
  echo "window.location = \"index2.php?func=players\"";
  echo "</script>";
}

function reset_player_skill()
{
  global $db_db;
  global $t;

  $id = $_GET['id'];

  $query = "UPDATE $db_db.${t['players']} SET skill = 1000 WHERE ${t['players']}.id = $id LIMIT 1";
  if (!mysql_query($query))
    die (mysql_error());
  
  echo "<script>";
  echo "window.location = \"index2.php?func=players\"";
  echo "</script>";
}

function client_level($level)
{
  switch($level)
  {
    case 0:
    return "<span style=\"color: #999999;\">Not registered</span>";
    break;

    case 1:
    return "<span style=\"color: #04B404;\">Registered</span>";
    break;

    case 2:
    return "<span style=\"color: #4B8A08;\">Registered+</span>";
    break;

    case 8:
    return "<span style=\"text-decoration: underline; color: #868A08;\">Moderator</span>";
    break;

    case 16:
    return "<span style=\"text-decoration: underline; color: #6268F7;\">Admin</span>";
    break;

    case 32:
    return "<span style=\"text-decoration: underline; font-weight: bold; color: #0174DF;\">Full Admin</span>";
    break;

    case 64:
    return "<span style=\"text-decoration: underline; font-weight: bold; color: #DF0101;\">Senior Admin</span>";
    break;

    case 128:
    return "<span style=\"text-decoration: underline; font-weight: bold; color: #B404AE;\">GOD</span>";
    break;

    default:
    return $level;
    break;
  }
}

function delete_server()
{
  global $myserver;
  global $currentconfignumber;

  $config_dir = "../config";

  //check if we have only one or multiple config files
  $numberofconfigs = countConfigfiles($config_dir);
  
  //if we have only one config
  if($numberofconfigs == 1)
  {
    if(!isset($_POST['yes']))
    {
      echo "<table width=\"100%\" align =\"left\" class=\"alert\">
             <tr>
               <td align=\"left\" width=\"60\" valign=\"top\"><img src=\"../../xlrstats-dev/templates/admin/admin-warning.png\" style=\"vertical-align:middle\" /></td>
               <td align=\"left\">You have only one server configured. If you delete it, the admin panel will not function until you start installer and set up at least one server again. <p>Do you wish to continue?</td>
             </tr>
             <tr>
              <form action=\"index2.php?func=deleteserver\" method=\"POST\">
              <td>&nbsp;</td>
              <td align=\"left\"><input type=\"submit\" name=\"yes\" id=\"yes\" value=\"Yes\" />&nbsp;<input type=\"button\" name=\"no\" id=\"no\" value=\"Cancel\" onclick=\"window.location.href='index2.php'\" /></td>
             </tr></form>
            </table>";
    }
    else //if confirmed delete file
    {
      $configfile = "statsconfig.php";
      fileDelete($config_dir,$configfile);
    }
  }

  //if we have multiple config files
  if($numberofconfigs > 1)
  {
    if(!isset($_POST['yes']))
    {
      echo "<table width=\"100%\" align =\"left\" class=\"alert\">
             <tr>
               <td align=\"left\" width=\"60\" valign=\"top\"><img src=\"../../xlrstats-dev/templates/admin/admin-warning.png\" style=\"vertical-align:middle\" /></td>
               <td align=\"left\">This will delete the configuration file of your server \"$myserver\". <p>Do you wish to continue?</td>
             </tr>
             <tr>
              <form action=\"index2.php?func=deleteserver\" method=\"POST\">
              <td>&nbsp;</td>
              <td align=\"left\"><input type=\"submit\" name=\"yes\" id=\"yes\" value=\"Yes\" />&nbsp;<input type=\"button\" name=\"no\" id=\"no\" value=\"Cancel\" onclick=\"window.location.href='index2.php'\" /></td>
             </tr></form>
            </table>";
    }
    else //if confirmed delete file
    {
      $configfile = "statsconfig".$currentconfignumber.".php";
      fileDelete($config_dir,$configfile);

      //check how many config files we have left
      $numberofconfigsleft = countConfigfiles($config_dir);

      //if we have 1 config file left, rename it to statsconfig.php
      if($numberofconfigsleft == 1)
      {
        if(@!($dp = opendir($config_dir)))
          die("Cannot open $config_dir.");

        while($file = readdir($dp))
        if(preg_match("/^statsconfig/i", $file))
          $config_files[] = $file;
        closedir($dp);

        $confignumber = trim(preg_replace("/[^0-9]/", "", $config_files[0])); //take out the number of the config file left
        rename($config_dir."/statsconfig".$confignumber.".php", $config_dir."/statsconfig.php");
      }
      else //if we have more than 1 config files left
      {
        if(@!($dp = opendir($config_dir)))
          die("Cannot open $config_dir.");

        while($file = readdir($dp))
        if(preg_match("/^statsconfig/i", $file))
          $config_files[] = $file;
        closedir($dp);

        natsort($config_files);

        for($i=1; $i<=count($config_files); $i++)
        {
          rename($config_dir."/".$config_files[$i-1], $config_dir."/statsconfig".$i.".php");
        }
      }

      //proceed to create awards with new config files
      echo "<table><td><img src=\"../images/spacer.gif\" width=\"1\" height=\"10\" /></td></table>
            <table width=\"100%\" align =\"left\" class=\"alert\">
             <tr>
               <td width=\"100%\" align=\"left\">Your configuration files changed! Please click \"Create Awards\" button to recreate awards for new configuration files</td>
             </tr>
             <tr>
              <form action=\"index2.php?func=awards\" method=\"POST\">
              <td align=\"center\"><input type=\"submit\" name=\"create\" id=\"create\" value=\"Create Awards\" /></td>
             </tr></form>
            </table>";
    }
  }
}

function resetDatabase()
{
  global $db_db;

  if(!isset($_POST['yes']))
  {
    echo "<table width=\"100%\" align =\"left\" class=\"alert\">
         <tr>
           <td align=\"left\" width=\"60\" valign=\"top\"><img src=\"../../xlrstats-dev/templates/admin/admin-warning.png\" style=\"vertical-align:middle\" /></td>
           <td align=\"left\">This will reset all stats tables in your database. We strongly recommend backing up your database first <p>Do you wish to continue?</td>
         </tr>
         <tr>
          <form action=\"index2.php?func=resetdb\" method=\"POST\">
          <td>&nbsp;</td>
          <td align=\"left\"><input type=\"submit\" name=\"yes\" id=\"yes\" value=\"Yes\" />&nbsp;<input type=\"button\" name=\"no\" id=\"no\" value=\"Cancel\" onclick=\"window.location.href='index2.php'\" /></td>
         </tr></form>
        </table>";
  }
  else
  {
    echo "<table width=\"100%\" align =\"left\" class=\"success\">";
 
    //get table names
    $query = "SHOW TABLES FROM $db_db";

    if(!mysql_query($query))
      die (mysql_error());
    else
      $result = mysql_query($query);

    while($row = @mysql_fetch_assoc($result)) 
    { 
      $tables[] = $row['Tables_in_' . $db_db]; 
    }

    //keep table names starting with "xlr_" only and empty them
    $xlr_tables = preg_grep("/^xlr_/", $tables);
    foreach($xlr_tables as $table_name)
    {
      $query = "TRUNCATE " . $table_name;
      if (!mysql_query($query))
        die (mysql_error());

      echo "<tr><td width=\"20\"><img src=\"../../xlrstats-dev/templates/admin/admin-accept.png\" style=\"vertical-align:middle\" /><td align=\"left\">Table $table_name Reset Successfully!</td></tr>";
    }
    echo "<td>&nbsp;</td>
          <td align=\"left\" valign=\"middle\">
           <br /><input name=\"adminhome\" type=\"submit\" id=\"adminhome\" value=\"Admin Home\" onclick=\"window.location.href='index2.php'\"/>
          </td></table>";
  }
}

function countConfigfiles($directory)
{
  if(@!($dp = opendir($directory)))
  die("Cannot open $directory.");

  while($file = readdir($dp))
  if(preg_match("/^statsconfig/i", $file))
    $config_files[] = $file;
  closedir($dp);

  $numberofconfigs = count($config_files);
  return $numberofconfigs;
}

function fileDelete($filepath,$filename)
{
  $success = false;
  if (file_exists($filepath."/".$filename )&& $filename != "" && $filename != "n/a") 
  {
    unlink ($filepath."/".$filename);
    $success = true;
  }
  if($success == true)
  {
    echo "<table width=\"100%\" align =\"left\" class=\"success\">
            <tr>
              <td align=\"left\" width=\"60\" valign=\"top\"><img src=\"../../xlrstats-dev/templates/admin/admin-accepted.png\" style=\"vertical-align:middle\" /></td>
              <td align=\"left\">$filename deleted successfully!</td>
            </tr>
          </table>";
  }
  else
  {
    echo "<table width=\"100%\" align =\"left\" class=\"alert\">
            <tr>
              <td align=\"left\" width=\"60\" valign=\"top\"><img src=\"../../xlrstats-dev/templates/admin/admin-warning.png\" style=\"vertical-align:middle\" /></td>
              <td align=\"left\">Cannot delete $filename. Make sure $filename exists and \"$filepath\" directory is writable</td>
            </tr>
          </table>";
  }
}

function list_templates($template)
{
  $dir = '../templates';
  $templatelist = scandir($dir);
  sort($templatelist);
  foreach ($templatelist as $key=>$value) 
  {
    if (preg_match('/^[.]/', $value)) unset($templatelist[$key]);
  }
 
  $key = array_search('site.png', $templatelist);
  unset($templatelist[$key]);
  $key = array_search('loader.css', $templatelist);
  unset($templatelist[$key]);
  $key = array_search('holidaypack', $templatelist);
  unset($templatelist[$key]);
  $key = array_search('admin', $templatelist);
  unset($templatelist[$key]);

  foreach ($templatelist as $value)
  {
    if ($template == $value)
      echo "<option value=\"$value\" selected=\"selected\">$value</option>";
    else
      echo "<option value=\"$value\">$value</option>";
  }
}

function displayadminfooter()
{
?>
    </td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="footer">
          <td width="85" height="30" class="tiny"><a href="http://www.xlr8or.com" class="footer" target="_blank"><img src="../images/ico/xlr8or.png" border="0" align="absbottom" title="Visit the Creator of XLRstats"></a></td>
  <td width="85" height="30" class="tiny"><a href="http://www.bigbrotherbot.com" class="footer" target="_blank"><a href="http://www.bigbrotherbot.com" class="footer" target="_blank"><img src="../images/ico/b3.png" border="0" align="absbottom" title="BigBrotherBot Automated Game Administration" /></a></td>
  <td width="85" height="30" class="tiny"><a href="http://www.cback.de" class="footer" target="_blank"><img src="../images/ico/ctracker.png" border="0" align="absbottom" title="Cracker Tracker Anti Injection and Worm Protection Software"></a></td>
  <td align="right" class="tiny">&nbsp;&copy; 2005-2010&nbsp;<a href="http://www.xlr8or.com/" target="_blank" class="footer">www.xlr8or.com</a> </td>
        </table></td>
    </tr>
  </table>
  </body>
  </html>
<?php
}
?>