<?php 
// Set flag that this is a parent file
define( '_XLREXEC', 1 );

include('../../func-globallogic.php');

// If statsconfig.php exists, we won't enable multiconfig functionality
if (file_exists("../../config/statsconfig.php"))
{
  $currentconfig = "../../config/statsconfig.php";
  $currentconfignumber = 0;
}
elseif (file_exists("../../config/statsconfig1.php"))
{
  $currentconfig = "../../config/statsconfig1.php";
  $currentconfignumber = 1;
  // Was a config set in the url?
  if (isset($_GET['config'])) 
  {
    $currentconfignumber = escape_string($_GET['config']);
    $currentconfig = "../../config/statsconfig".$currentconfignumber.".php";
    $_SESSION['currentconfignumber'] = $currentconfignumber;
  }
  if (isset($_SESSION['currentconfignumber']))
  {
    $currentconfignumber = $_SESSION['currentconfignumber'];
    $currentconfig = "../../config/statsconfig".$currentconfignumber.".php";
  }
}

echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
        \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
	<title>Player Worldmap</title> 
  <style type=\"text/css\">
  <!--
  body {
  	margin-left: 0px;
  	margin-top: 0px;
  	margin-right: 0px;
  	margin-bottom: 0px;
  	background-color: #333333;
  }
  -->
  </style>
</head>
</head>
<body>
<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width=\"550\" height=\"300\" id=\"zoom_map\" align=\"top\">
	<param name=\"movie\" value=\"world.swf?data_file=playergeodata.php?config=$currentconfignumber\" />
	<param name=\"quality\" value=\"high\" />
	<param name=\"bgcolor\" value=\"#FFFFFF\" />
	<embed src=\"world.swf?data_file=playergeodata.php?config=$currentconfignumber\" quality=\"high\" bgcolor=\"#FFFFFF\" width=\"550\" height=\"300\" name=\"Clickable World Map\" align=\"top\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\">
	</embed>
</object>
</body>
</html>
";
?>
