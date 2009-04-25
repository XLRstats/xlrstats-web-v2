<?php

if( $width > IMAGE_MAX_WIDTH || $width < IMAGE_MIN_WIDTH ) $width = IMAGE_DEF_WIDTH;
if( $height > IMAGE_MAX_HEIGHT || $height < IMAGE_MIN_HEIGHT ) $height = IMAGE_DEF_HEIGHT;
	
if( $backdrop_url != "" )
	$image = get_user_image( $backdrop_url, $width, $height, CACHE_LIFE );
else
	$image = get_stock_backdrop( $width, $height );
	
$image_width = imagesx( $image );
$image_height = imagesy( $image );

// Create some colors
switch( $color_scheme_id )
{
	case 1: default:
		$color_header_shade = imagecolorallocatealpha( $image, 0, 0, 0, 0 );
		$color_header_border = imagecolorallocate( $image, 0, 0, 0 );
		$color_header_text = imagecolorallocate( $image, 255, 255, 255 );
		$color_stats_shade = imagecolorallocatealpha( $image, 0, 0, 0, 50 );
		$color_stats_border = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_stats_text = imagecolorallocate( $image, 255, 255, 255 );
		$color_hb_shade = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_hb_border = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_hb_text = imagecolorallocate( $image, 255, 255, 255 );
		$color_image_border = imagecolorallocate( $image, 0, 0, 0 );
		break;
		
	case 2:
		$color_header_shade = imagecolorallocatealpha( $image, 255, 255, 255, 0 );
		$color_header_border = imagecolorallocate( $image, 0, 0, 0 );
		$color_header_text = imagecolorallocate( $image, 0, 0, 0 );
		$color_stats_shade = imagecolorallocatealpha( $image, 255, 255, 255, 50 );
		$color_stats_border = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_stats_text = imagecolorallocate( $image, 0, 0, 0 );
		$color_hb_shade = imagecolorallocatealpha( $image, 255, 255, 255, 127 );
		$color_hb_border = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_hb_text = imagecolorallocate( $image, 255, 255, 255 );
		$color_image_border = imagecolorallocate( $image, 0, 0, 0 );
		break;
	
	case 3:
		$color_header_shade = imagecolorallocatealpha( $image, 0, 0, 0, 0 );
		$color_header_border = imagecolorallocate( $image, 0, 0, 0 );
		$color_header_text = imagecolorallocate( $image, 255, 255, 255 );
		$color_stats_shade = imagecolorallocatealpha( $image, 255, 255, 255, 50 );
		$color_stats_border = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_stats_text = imagecolorallocate( $image, 0, 0, 0 );
		$color_hb_shade = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_hb_border = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_hb_text = imagecolorallocate( $image, 255, 255, 255 );
		$color_image_border = imagecolorallocate( $image, 0, 0, 0 );
		break;
		
	case 4:
		$color_header_shade = imagecolorallocatealpha( $image, 255, 255, 255, 0 );
		$color_header_border = imagecolorallocate( $image, 0, 0, 0 );
		$color_header_text = imagecolorallocate( $image, 0, 0, 0);
		$color_stats_shade = imagecolorallocatealpha( $image, 0, 0, 0, 50 );
		$color_stats_border = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_stats_text = imagecolorallocate( $image, 255, 255, 255 );
		$color_hb_shade = imagecolorallocatealpha( $image, 255, 255, 255, 127 );
		$color_hb_border = imagecolorallocatealpha( $image, 0, 0, 0, 127 );
		$color_hb_text = imagecolorallocate( $image, 255, 255, 255 );
		$color_image_border = imagecolorallocate( $image, 0, 0, 0 );
		break;
}
		
// 1px border
imagerectangle( $image, 			0, 0, $image_width-1, $image_height-1, $color_image_border );

// Header
imagefilledrectangle( $image, 0, 0, $image_width-1, 20, $color_header_shade  );
imagerectangle( $image, 			0, 0, $image_width-1, 20, $color_header_border );

$text = $player['rank'];
//$text = " ";

list( $tw ) = get_text_metrics( "./fonts/lucon.ttf", 10, 0, $text );
imagettftext( $image, 10, 0, 5, 15, $color_header_text, "./fonts/lucon.ttf", $text );
$x = 5 + $tw;
$y = 15;


$name = $player['name'];
$namelen = strlen($name);

function iscolor( $text, $pos )
{
	if( ($pos+8) >= strlen($text)  ) return false;
	
	if( $text{$pos} == "`" && $text{$pos+1} == "#" )
	{
		$c1 = substr( $text, $pos+2, 2 );
		$c2 = substr( $text, $pos+4, 2 );
		$c3 = substr( $text, $pos+6, 2 );
		$ret = array( hexdec($c1), hexdec($c2), hexdec($c3) );
		return $ret;
	}
	return false;
}

$col = $color_header_text;
for( $i = 0; $i < $namelen; ++$i )
{
	while( ($c = iscolor($name,$i)) )
	{
		$col = imagecolorallocate( $image, $c[0], $c[1], $c[2] );
		$i+=8;		
	}
		
	if( $i >= $namelen )break;
	$char = $name{$i};	
	list( $cw ) = get_text_metrics( "./fonts/lucon.ttf", 10, 0, $char );	
	imagettftext( $image, 10, 0, $x, $y, $col, "./fonts/lucon.ttf", $char );
	$x+= $cw + 1;	
}

$box = imagettfbbox( 10, 0, "./fonts/lucon.ttf", SITE_NAME );
imagettftext( $image, 10, 0, $image_width - ($box[2]+7), 15, $color_header_text, "./fonts/lucon.ttf", SITE_NAME );

$icon = imagecreatefromjpeg( GAME_ICON );
imagecopy( $image, $icon, ($image_width - ($box[2]+5)) - 21, 2, 0, 0, 17, 17 );
imagedestroy( $icon );

// Stats Box 1
imagefilledrectangle( $image, 5, 24, 130, 95, $color_stats_shade );
imagerectangle( $image, 			5, 24, 130, 95, $color_stats_border );

$font = "./fonts/lucon.ttf";
$font_size = 7;
$font_spacing = 3;
$x = 10; $y = 36;

if (is_numeric($player['skill']))
  $player['skill'] = number_format($player['skill']);
if (is_numeric($player['kills']))
  $player['kills'] = number_format($player['kills']);
if (is_numeric($player['deaths']))
  $player['deaths'] = number_format($player['deaths']);
if (is_numeric($player['ratio']))
  $player['ratio'] = number_format($player['ratio'], 2);
if (is_numeric($player['winstreak']))
  $player['winstreak'] = number_format($player['winstreak']);
if (is_numeric($player['losestreak']))
  $player['losestreak'] = number_format($player['losestreak']);

write_line( $image, $font_size, 0, $x, $y, $color_stats_text, $font, "Skill: " . $player['skill'], $font_spacing  );
write_line( $image, $font_size, 0, $x, $y, $color_stats_text, $font, "Kills: " . $player['kills'], $font_spacing  );
write_line( $image, $font_size, 0, $x, $y, $color_stats_text, $font, "Deaths: " . $player['deaths'], $font_spacing  );
write_line( $image, $font_size, 0, $x, $y, $color_stats_text, $font, "Ratio: " . $player['ratio'], $font_spacing  );
write_line( $image, $font_size, 0, $x, $y, $color_stats_text, $font, "Kill Streak: " . $player['winstreak'], $font_spacing  );
write_line( $image, $font_size, 0, $x, $y, $color_stats_text, $font, "Death Streak: " . $player['losestreak'], $font_spacing  );
//write_line( $image, $font_size, 0, $x, $y, $color_stats_text, $font, "Connections: " . number_format($player['connections']), $font_spacing  );


// Hosted by box.
define( "HOSTED_BY", "XLRstats" );
{
  $font = "./fonts/gunplay.ttf";
  $font_size = 11;

	$box = imagettfbbox( $font_size, 0, $font, HOSTED_BY );
	$text_width = $box[0] + $box[4] ;
	$text_height = $box[1] - $box[5] ;
	imagefilledrectangle( $image, $image_width - ($text_width+14), $image_height - ($text_height + 6) , $image_width-1, $image_height-1, $color_hb_shade );
	imagerectangle( $image,	$image_width - ($text_width+14), $image_height - ($text_height + 6),  $image_width-1, $image_height-1, $color_hb_border );
	imagettftext( $image, $font_size, 0, $image_width - ($text_width+10), $image_height - (($text_height/2)-2), $color_hb_text, $font, HOSTED_BY );
}
?>
