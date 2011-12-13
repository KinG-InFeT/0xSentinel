<?php
/*
 *
 * @project 0xSentinel
 * @author KinG-InFeT
 * @licence GNU/GPL
 *
 * @file banner.php
 *
 * @link http://0xproject.netsons.org#0xSentinel
 *
 */
 
include("config.php");
include_once("lib/mysql.class.php");
include_once("lib/layout.class.php");

$mysql = new MySQL();

$mysql->Open($db_host, $db_user, $db_pass, $db_name);
$active = $mysql->Query("SELECT * FROM 0xSentinel_settings");
$row    = mysql_fetch_array($active);

$image     = "images/banner.png";
$im        = ImageCreateFromPNG ($image);

			 imageAlphaBlending($im, TRUE);
			 imageSaveAlpha($im, TRUE);
			 
$txt_color = ImageColorAllocate ($im, 80, 80, 80);

if($row['active'] == 1)
	$color_status = ImageColorAllocate ($im, 80, 80, 80);
else
	$color_status = ImageColorAllocate ($im, 255, 0, 0);

$attack_blocked = intval(mysql_num_rows($mysql->Query("SELECT * FROM 0xSentinel_logs")));
$version        = VERSION;

ImageString($im, 2, 10, 25, "Version: $version", $txt_color);
ImageString($im, 2, 10, 37, "Status: ", $txt_color);
ImageString($im, 2, 70, 37, ($row['active'] ? "Online" : "Offline"), $color_status );
Imagestring($im, 2, 10, 49, "Attack Blocked: $attack_blocked", $txt_color);

header ("Content-type: image/png");
Imagepng($im);
ImageDestroy($im);
?> 
