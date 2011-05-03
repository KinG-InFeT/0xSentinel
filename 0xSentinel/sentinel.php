<?php
session_start();
/**
 * File: sentinel.php
 * 
 * La pagina più impostante XD
 *
 * @author KinG-InFeT <info@kinginfet.net>
 * @copyright GPL
 */

include("config.php");
include_once("lib/mysql.class.php");
include_once("lib/0xSentinel.class.php");

$sentinel = new Sentinel();
$mysql    = new MySQL();

$mysql->Open($db_host, $db_user, $db_pass, $db_name);
		
$ris = $mysql->Query("SELECT * FROM 0xSentinel_settings");

$row = mysql_fetch_array($ris);

if($row['active'] == 1) {

    if($row['filter_fpd'] == 1)
        $sentinel->check_FPD();

	if($row['filter_get'] == 1)
		$sentinel->check_GET();
	
	if($row['filter_post'] == 1)
		$sentinel->check_POST();
		
	if($row['filter_cookie'] == 1)
		$sentinel->check_COOKIE();
	
    if($row['filter_session'] == 1)
		$sentinel->check_SESSION();
		
	if($row['filter_ip'] == 1)
		$sentinel->check_ban_ip($_SERVER['REMOTE_ADDR']);
		
	if($row['filter_csrf'] == 1)
        $sentinel->check_CSRF(@$_SERVER['HTTP_REFERER']);    
    
    if($row['filter_scanner'] == 1)
        $sentinel->check_useragent();
}
?>
