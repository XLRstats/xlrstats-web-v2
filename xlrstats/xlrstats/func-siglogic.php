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

//**************************************************************************************
//
//  Functions for the general statistics (i.e. not player, weapon or map specific)
//  These are generally used on the "index" page
//
//**************************************************************************************


function get_user_image( $image_url, $width, $height, $cache_life )
{
	$image = false; 
	$cached_files = array();
	$flag_cached = false;
	$flag_outdated = false;
	$flag_downloaded = false;
	$flag_unlinkerr = false;
	
	$image_hash = md5( $image_url );
	$hash_len = strlen( $image_hash );

	// Find cached copys of this remote file.
	$dir = opendir( CACHE_PATH );
	while( $file = readdir($dir) )
	{
		if( strncmp($file, $image_hash, $hash_len-1) == 0 )
		{
			$cached_file = $file;
			$flag_cached = true;
			
			// Get timestamp.		
			list( , $cache_time ) = explode( "_", $cached_file );
			$cache_time = intval($cache_time);
			
			// Is this cached file out of date?
			if( $cache_time != 0 && $cache_time < (time() - (60*$cache_life)) )
				$flag_outdated = true;
				
			break;
		}
	}
	closedir($dir);
	
	// Force recache?
	$flag_recache = (isset($_GET['recache']) && $_SERVER['HTTP_REFERER'] == "") ? true:false;
		
	// Attempt to get the remote image and cache it.
	if( !$flag_cached || $flag_outdated || $flag_recache )
	{ 
		$file_in = @fopen( $image_url, "r" );
		if( $file_in ) 
		{
			while( !feof($file_in) )
			{	
				if( strlen($image_data) > IMAGE_MAX_SIZE ){	fclose( $file_in );	die( "Abuse detected." );	}
				$image_data .= fread( $file_in, 40000 );
			}
			fclose( $file_in );
			
			if( ($image = @imagecreatefromstring($image_data)) != false ) $flag_downloaded = true;			
		}
	}
			
	if( $flag_downloaded )
	{
		if( $flag_cached )
			$flag_unlinkerr != @unlink( CACHE_PATH . $cached_file );
			
		if( !$flag_unlinkerr )
			imagejpeg( $image, CACHE_PATH . $image_hash . "_" . (($cache_life) ? time() : "0000000000") . ".jpg", 100 );		
	}
	else if( $flag_cached )
	{
		// We have a local cached file and we didnt get a new one... rename it
		$image = @imagecreatefromjpeg( CACHE_PATH . $cached_file );
		if( $flag_outdated ) 
		{ 
			$old_name = CACHE_PATH . $cached_file;
			$new_name = CACHE_PATH . $image_hash . "_" . time() . ".jpg";
			@rename( $old_name, $new_name );
		}				
	}
	
	// Whaaa???
	if( $image == false ) die( "Unable to get image." );
	
	$image_width = imagesx( $image );
	$image_height = imagesy( $image );
	$resized_image = imagecreatetruecolor( $width, $height );
	imagecopyresampled( $resized_image, $image, 0, 0, 0, 0, $width, $height, $image_width, $image_height ); 		
	imagedestroy( $image );
	return $resized_image;
}

// Selects an image at random from the backdrop folder and resizes it to our desired dimensions.
function get_stock_backdrop( $width, $height )
{
	// If a user_template hasnt been set, set one at random.
	$dir = opendir( BACKDROP_FOLDER );
	if( !$dir )	die( "Unable to open backdrop folder, please ensure this folder exists and is writable." );
	while( $file = readdir($dir) )
	{
		if( $file{0} != "." )
			$backdrops[] = $file;
	}
	closedir($dir);
			
	$backdrop_file = BACKDROP_FOLDER . $backdrops[ rand(0,count($backdrops)-1) ];
	if( $width != 0 && $height != 0 )
	{
		$image = imagecreatetruecolor( $width, $height );
		$bd = imagecreatefromjpeg( $backdrop_file );
		imagecopyresampled( $image, $bd, 0, 0, 0, 0, $width, $height, imagesx($bd), imagesy($bd) );
		imagedestroy($bd);
		return $image;
	}
		
	return imagecreatefromjpeg( $backdrop_file );		
}

function write_line( $image, $size, $angle, &$x, &$y, $color, $font, $text, $spacing )
{
	$font_box = imagettfbbox( $size, 0, $font, "H" );
	$font_height = $font_box[1] - $font_box[7];
	imagettftext( $image, $size, 0, $x, $y, $color, $font, $text  );
	$y += $font_height + $spacing;
}

function get_text_metrics( $font, $size, $angle, $text )
{
	$bbox = imagettfbbox( $size, $angle, $font, $text );
	$w = $bbox[2]+$bbox[6];
	$h = $bbox[3]+$bbox[7];
	
	return array( $w, $h );
}

// MQ aware slashing functions for GPC inputs
function addslashes_gpc( $data )
{
	if( !get_magic_quotes_gpc() )
		return addslashes( $data );
	return $data;
}

function stripslashes_gpc( $data )
{
	if( get_magic_quotes_gpc() )
		return stripslashes( $data );
	return $data;
}

?>
