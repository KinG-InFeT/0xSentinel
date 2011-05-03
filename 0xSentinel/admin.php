<?php
/**
 * File: admin.php
 * 
 * Pagina di amministrazione e gestione del CMS
 *
 * @author KinG-InFeT <info@kinginfet.net>
 * @copyright GPL
 */

session_start();

include_once("config.php");
include_once("lib/layout.class.php");
include_once("lib/admin.class.php");
include_once("lib/banip.class.php");

$layout = new layout();

$layout->header();

$mysql = new MySQL();

$mysql->Open($db_host, $db_user, $db_pass, $db_name);

$ris = $mysql->Query("SELECT admin_pass FROM 0xSentinel_settings");
$row = mysql_fetch_array($ris);

if(!($_SESSION['0xSentinel']['admin'] == $row['admin_pass'])) {
	die(header('Location: login.php'));
}

$layout->admin_menu();

$admin  = new Admin();
$ban_ip = new BanIP();

@$mode  = $_GET['action'];

switch($mode) {

	/**
	 * Pagine amministrative
	 */
	case 'Status':
		$admin->Status();
	break;
	
	case 'Settings':
		$admin->Settings();
	break;
	
	case 'Rules':
		$admin->Rules();
	break;
	
	case 'Logs':
		$admin->Logs();
	break;
	
	/**
	 * Strumenti per la gestione
	 */
	case 'add_rule':
		$admin->add_rule();
	break;
	
	case 'delete_log':
		$admin->delete_log($_GET['id']);
	break;
	
	case 'delete_rule':
		$admin->delete_rule($_GET['id']);
	break;
	
	case 'edit_rule':
		$admin->edit_rule($_GET['id']);
	break;
	
	/**
	 * Strumenti Gestione Sistema Ban IP
	 */
	case 'ban_ip':
		$ban_ip->ban_ip();
	break;
	
	case 'add_ip':
		$ban_ip->add_ip();
	break;
	
	case 'delete_ip':
		$ban_ip->delete_ip($_GET['id']);
	break;
	
	case 'Logout':
		session_destroy();
		header('Location: index.php');
	break;
	
	default:
		header('Location: admin.php?action=Status');
	break;
}


$layout->footer();
?>
