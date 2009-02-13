<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>XLRstats for B3 (www.xlr8or.com) - Help</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
@import url("style.css");
-->
</style>
</head>

<body>
<?php
$func = "help";

// load our configs
include("statsconfig.php");

// used functions
include("func-globallogic.php");

// Display header and simple navigationmenu
displayheader();
displayhomelink();
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="outertable">
  <tr>
    <td><strong>Help section of XLRstats.</strong></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="innertable">
      <tr>
        <td><p><strong><br>
          Introduction.</strong><br>
  XLRstats is a statistics generation and publication plugin for the BigBrotherBot,
      short B3. So it is not a standalone programm, it's a plugin for the platform
      and game independant administration facility for online games called B3
      (more information about B3 can be found at <a href="http://www.bigbrotherbot.com" target="_blank">www.bigbrotherbot.com</a>)
      As a gamer you should not have to worry about how this works exactly, you
      would only have to know how to interpret the statistics, what is in there,
      what's not and why it's not in there.</p>
          <p>XLRstats is a REAL-TIME statistics plugin. It keeps track of the
            actual status on our gameserver(s) right up to the point you press
            the link on the website or refresh the page!</p>
          <p><strong>The main page.</strong><br>
  At the main page you'll find the search facility, the top lists and the awardwinners
    The top lists contain the names off the die-hard (regularly playing) gamers
    that have achieved the highest rates for the list. For example, the 'top
    list - kills' contains the gamers with the highest killcount on our server.
    To win a spot in one of the toplists you need a minimum in rounds or kills
    before you are elligable for a spot. The exact number can be read in the
    bottom of each table, if extra information for the table is available you'll
    find it there. That goes for each table in the stats! Last but not least,
    the awards are a collection of highest counts for specific achievements.
    They speak for themselves.</p>
          <p><strong>The Player, Map and Weaponpages.</strong><br>
  If you click on a playername, a mapname or a weaponname you will see a page
    with all available stats for that specific player or item. In other words,
    a playerpage will show you the stats for that specific player. Same goes
    for mappages and weaponpages.</p>
          <p><strong>Available info.</strong><br>
  Most columns in the statstables speak for themselves. For example: kills shows
    you the number of kills made, and rounds the number of rounds played... simple
    as that. Two colums might need a little extra explanation though.</p>
          <p><strong>Ratio.</strong><br>
  The ratio is only available for players. It is the number of kills devided
    by the number of deaths. So if you kill 10 players, and get shot 10 times,
    your ratio is 1. Hence, a ratio higher than 1 is a good thing (more kills
    than deaths), and a ratio between 0 and 1 indicates that you need some practice
    (more deaths than kills).</p>
          <p><strong>Skill.</strong><br>
  Skill is a complicated thing. In XLRstats it indicates your actual level of
    how good you are. Our basic skillcalculation formula is taken from the scientific
    method used in more online competitions like chess and online tacticall games.
    Because this game is not exactly chess we had to modify it so it works for
    our game. We've added penalties and weaponmodifiers so there is a way to
    include them in the calculation. We also added a team-work factor in the
    calculation to award teamplay. Your skill increases when you kill, it decreases
    when you die. Keep the next things in mind when playing for skill:</p>
          <ul>
            <li>Extra skillpoints are received when:
                <ul>
                  <li>you kill a player with a better skill than yourself</li>
                  <li>you kill with a difficult weapon like a pistol, rifle or
                    by bashing an opponent</li>
                </ul>
            </li>
            <li>Extra skillpoints are deducted (you receive a skillpenalty) when:
                <ul>
                  <li>you kill a teammate</li>
                  <li>you fall from a roof</li>
                </ul>
            </li>
          </ul>
          <p>Basicly skill is calculated after each kill or death. After a bad
            day your skill would be down significantly, while on a good day your
            skill might go up to the point where you show up in the top list
            - skill. Common sence is the main thing, if you choose the team that
            has a hard time winning, you have better chances on improving your
            skill, because the skilled players are probably in the opposite team,
            and killing them gives you extra skillpoints! On the other hand,
            if you are number 1 on the skill ranking, you will not be able to
            earn extra skillpoints. Simply because there is no one better than
            you! You will have to defend your position without the possibility
            to receive extra points Choose your weapon carefully, killing with
            a thompson or MP-40 (typicall spraying weapons) will make you improve
            less on skill, while setting guns to semi will give you more skillpoints.
            More on weaponmodifiers in the next chapter.</p>
          <p><strong>Weaponmodifiers.</strong><br>
  As you might have read in the previous chapter we included a weapon modifier
    for each weapon. Based on the policy of the gameserver running the plugin,
    it multiplies skillimprovement or skilldeduction with a factor configurable
    in the plugin itself. Printing the different factors is not possible, simply
    because each serveradmin can set these modifiers in the config. With a default
    install it would be wise to switch an automatic rifle to semi (usually with
    the m-key ingame) simply because it would add more to your skill. Also a
    pistol and bashing an opponent gives better increase of skill.</p>
          <p><strong>Finally.</strong><br>
  Playing for stats is a fun addition to the game, if you keep skillfactors under
    consideration you'll improve not only in our stats, but also when playing
    on other servers. If you've read between the written lines, you'll know what
    the gamingcommunity is about. All negative behaviour has negative influence
    on your skill.</p>
          <p><a href="index.php">Back to the stats.</a><br>
            <br>
          </p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tiny"> The B3 bot is written by Thorn and can be found at <a href="http://www.bigbrotherbot.com/" target="_blank">www.bigbrotherbot.com</a>,
        the plugin is coded by ttlogic, this webfront is coded by both xlr8or
    and ttlogic. XLRstats is build at <a href="http://www.xlr8or.com/" target="_blank">www.xlr8or.com</a></td>
  </tr>
</table>
<?php
displayfooter();
?>
