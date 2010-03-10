<?php
error_reporting( E_ERROR ^ E_WARNING );

include( "settings.php" );
require_once("../func-globallogic.php");
require_once("../lib/geoip.inc");

session_start();
cleanglobals();

// If statsconfig.php exists, we won't enable multiconfig functionality
if (file_exists("../config/statsconfig.php"))
{
  $currentconfig = "../config/statsconfig.php";
  $currentconfignumber = 0;
}
elseif (file_exists("../config/statsconfig1.php"))
{
  $currentconfig = "../config/statsconfig1.php";
  $currentconfignumber = 1;
  // Was a config set in the url?
  if (isset($_GET['config'])) 
  {
    $currentconfignumber = escape_string($_GET['config']);
    $currentconfig = "../config/statsconfig".$currentconfignumber.".php";
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  if (isset($_SESSION['currentconfignumber']))
  {
    $currentconfignumber = $_SESSION['currentconfignumber'];
    $currentconfig = "../config/statsconfig".$currentconfignumber.".php";
  }
  // double check config number found point to an existing config file or fallback to config 1
  if (!file_exists($currentconfig)) 
  {
    $currentconfig = "config/statsconfig1.php";
    $currentconfignumber = 1;
  }
}
require_once($currentconfig);

// pop should hold the subdir depth of this file in relation to the xlrstats root.
$pop = 1;
include("../languages/languages.php");

displaysimpleheader(1);
opentablerow('100');
opentablecell('100');

  echo "<h1 align=\"center\">XLRstats - Signature Builder </h1>";

if( isset($_POST['submit']) )
{
	if( strlen($_POST['id']) == 0 ) 
		die( "Please enter a player ID" );
	
  $ptemp = explode("/", GetFileDir($_SERVER['PHP_SELF']));
  array_pop($ptemp);
  array_pop($ptemp);
  $link = "http://".$_SERVER['HTTP_HOST'].implode("/", $ptemp);

	extract( $_POST, EXTR_PREFIX_ALL, "in" );
	$in_id = stripslashes( $in_id ); 
	$player_id = $in_id;
	
	if ($currentconfignumber <> 0)
  {
  	$url = $link . "/sig/?config=" . $currentconfignumber . "&id=" . urlencode($player_id);
  	$stats_url = $link . "/index.php?func=player&config=" . $currentconfignumber . "&playerid=" . urlencode($player_id) ;
  }
  else
  {
  	$url = $link . "/sig/?id=" . urlencode($player_id);
    $stats_url = $link . "/index.php?func=player&playerid=" . urlencode($player_id) ;
  }

	if( strlen($in_b) > 0 )
		$url .= "&b=" . $in_b;
	
	if( strlen($in_c) > 0 || strlen($in_w) > 0 || strlen($in_h) > 0 )
	{
		$url .= "&s=";
		if( strlen($in_c) > 0 )
			$url .= "c" . $in_c;
		if( strlen($in_w) > 0 )
			$url .= "-w" . $in_w;
		if( strlen($in_h) > 0 )
			$url .= "-h" . $in_h;
	}
	
	echo "<b>URL:</b><br>&nbsp;&nbsp;" . $url . "<br><br>";

  echo "<b>Stats URL:</b><br>&nbsp;&nbsp;" . $stats_url . " (<a href=\"" . $stats_url . "\">link</a>)<br><br>";

	echo "<b>Forum Sig HTML-Code:</b><br>&nbsp;&nbsp;" . htmlspecialchars("<a href=\"" . $stats_url . "\"><img border=\"0\" src=\"" . $url . "&.png\"></a>") . "<br><br>";
	
	echo "<b>Forum Sig BB-Code:</b><br>&nbsp;&nbsp;" . htmlspecialchars("[url=" . $stats_url . "][img]" . $url . "&.png[/img][/url]") . "<br><br>";
	
	echo "<a href=\"" . $stats_url . "\"><img border=\"0\" src=\"" . $url . "\"></a><br>";

}

if( isset($_GET['id']) )
{
	if( strlen($_GET['id']) == 0 ) 
		die( "Please enter a player ID" );
	
	extract( $_GET, EXTR_PREFIX_ALL, "in" );
	$in_id = stripslashes( $in_id ); 
	$player_id = $in_id;
	
	$url = PLAYERSTATS_URL . "sig/?id=" . urlencode($player_id);
	$stats_url = PLAYERSTATS_URL . "index.php?func=player&playerid=" . urlencode($player_id) . "&config=${currentconfignumber}" ;

	if( strlen($in_b) > 0 )
		$url .= "&b=" . $in_b;
	
/*	if( strlen($in_c) > 0 || strlen($in_w) > 0 || strlen($in_h) > 0 )
	{
		$url .= "&s=";
		if( strlen($in_c) > 0 )
			$url .= "c" . $in_c;
		if( strlen($in_w) > 0 )
			$url .= "-w" . $in_w;
		if( strlen($in_h) > 0 )
			$url .= "-h" . $in_h;
	}*/
	
	echo "<b>URL:</b><br>&nbsp;&nbsp;" . $url . "<br><br>";
	echo "<b>Stats URL:</b><br>&nbsp;&nbsp;" . $stats_url . " (<a href=\"" . $stats_url . "\">link</a>)<br><br>";
	
	echo "<b>Forum Sig HTML-Code:</b><br>&nbsp;&nbsp;" . htmlspecialchars("<a href=\"" . $stats_url . "\"><img border=\"0\" src=\"" . $url . "\"></a>") . "<br><br>";
	
	echo "<b>Forum Sig BB-Code:</b><br>&nbsp;&nbsp;" . htmlspecialchars("[url=" . $stats_url . "][img]" . $url . "[/img][/url]") . "<br><br>";
	
	echo "<a href=\"" . $stats_url . "\"><img border=\"0\" src=\"" . $url . "\"></a><br>";

}



?>
<form method="post" action="build.php">
  <p><span class="style1">Player ID:</span><br>
    <input name="id" type="text" id="id" value="<?php $in_id ?>">
  </p>
<!-- 
  <p><span class="style1">Background Image: (optional)</span><br>
    <input name="b" type="text" id="b" size="100" value="<?php $in_b ?>">
</p>

  <p><span class="style1">Color: (optional)</span><br>
    <select name="c" id="c">
      <option value="1" <?php ($in_c==1)?"selected":""?> >1</option>
      <option value="2" <?php ($in_c==2)?"selected":""?> >2</option>
      <option value="3" <?php ($in_c==3)?"selected":""?> >3</option>
      <option value="4" <?php ($in_c==4)?"selected":""?> >4</option>
    </select> 
  </p>

  <p><span class="style1">Width-Height: (max 500x200)</span><br>
    <input name="w" type="text" id="w" size="6" value="<?php $in_w ?>">

    <input name="h" type="text" id="h" size="6" value="<?php $in_h ?>">
</p>
-->
  <p>
    <input type="submit" name="submit" value="Build">
</p>
</form>

<?php
closetablecell();
closetablerow();
displaysimplefooter(1);
?>
