<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>XLRstats installation</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
body {
	background-color: #000000;
	margin-left: 15px;
	margin-top: 15px;
}
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
a:hover {
	color: #FF9900;
}
a:active {
	color: #CCCCCC;
}
.green {
	color: #00FF00;
}
.red {
	color: #FF4F4F;
}
-->
</style>
<style type="text/css">
<!--
blockquote {
	font-family: serif;
}
-->
</style>
</head>

<body>
<h1>XLRstats Installation Stage 1 (of 3)</h1>

<p>Welcome to the XLRstats installation. Good choice to pick the only Real Time 
  Stats solution for games!</p>
<p>You can successfully install XLRstats in 3 steps.</p>
<ol>
  <li>Read the README.TXT file (see below) and prepare the configs: </li>
  <ul>
    <li>modify config/statsconfig.php by opening it in a texteditor and modify 
      the settings to fit your situation. </li>
    <li>Make sure all files named *_awards_idents.php are writable by the webserver. 
      <em>(chmod 777 *_awards_idents.php)</em> <br />
      Don't alter this file by hand unless you know what you are doing!</li>
  </ul>
  <li> In this step the installation script will test if the needed award config 
    files are available and are writable by the installation script.</li>
  <li>The last step will try to identify your weapons and bodypart information 
    so it can award the proper medals.</li>
</ol>
<p>If you see <span class="green">green</span> text during steps 2. and 3. things 
  seem to be okay. If <span class="red">red</span> text is presented, read it 
  carefully and fix the problems before you continue. If all is well and done, 
  <strong>rename (or remove) the install directory so it can no longer be called 
  directly</strong>.</p>
<h2>README.TXT</h2>
<p><em>(You can find this file also in your main XLRstats directory)</em></p>
<hr size="1" noshade="noshade" />

<blockquote> 
  <?php 
error_reporting(0);
// file() loads the contents of file.txt into an array, $lines
// each line in the file becomes a seperate element of the array.
$lines = file('../README.TXT');
// now loop through the array to print the contents of the file
foreach ($lines as $line)
{
	echo htmlspecialchars($line) . '<br />';
}
?>
</blockquote>

<hr size="1" noshade="noshade" />
<p><a href="check.php">Continue with step 2.</a></p>
</body>
</html>
