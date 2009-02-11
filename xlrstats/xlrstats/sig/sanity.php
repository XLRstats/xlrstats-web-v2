<?php
// © Nemon 2K5
// Email: nemon@blueyonder.co.uk
// Web: terrorfaction.com

$ver = phpversion();

// imagecolorallocatealpha requires 4.3.2
if( version_compare($ver, "4.3.2", "<") ) die( "This script requires a newer version of PHP than is installed on this server." );

if( !function_exists('imagecreate') ) die( "This script requires PHP GD2 extension." );
?>
