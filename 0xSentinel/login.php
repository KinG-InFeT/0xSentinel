<?php
/**
 * File: login.php
 * 
 * Pagina per il Login all'amministrazione
 *
 * @author KinG-InFeT <info@kinginfet.net>
 * @copyright GPL
 */

session_start();

if(file_exists("./install.php"))
	header('Location: index.php');

include("config.php");
include_once("lib/mysql.class.php");
include_once("lib/layout.class.php");

$layout = new layout();

$layout->header();

$mysql = new MySQL();

$mysql->Open($db_host, $db_user, $db_pass, $db_name);

$ris = $mysql->Query("SELECT admin_user, admin_pass FROM 0xSentinel_settings");
$row = mysql_fetch_array($ris);

if(@$_SESSION['0xSentinel']['admin'] == $row['admin_pass']) {
	die(header('Location: admin.php'));
}

if(!empty($_POST['username']) && !empty($_POST['password'])) {

	$user = $_POST['username'];
	$pass = md5($_POST['password']);
	
	if(($user == $row['admin_user']) && ($pass == $row['admin_pass'])) {
	
		$_SESSION['0xSentinel']['admin'] = $row['admin_pass'];
		header('Location: admin.php');
		
	}else{	
		print '<script>alert("Dati inseriti Errati"); window.location="login.php";</script>';
	}
}else{
	$layout->logo();
	$layout->login();
}

$layout->footer();
?>
