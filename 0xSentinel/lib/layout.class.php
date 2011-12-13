<?php
/**
 * File: layout.class.php
 * 
 * Classe che gestisce l'intero layout grafico
 *
 * @author KinG-InFeT <king-infet@autistici.org>
 * @copyright GPL
 */

define("VERSION","1.0.1");

if (preg_match("/layout.class.php/", $_SERVER['PHP_SELF'])) die(htmlspecialchars($_SERVER['PHP_SELF']));

class layout 
{

	/**
	 * Logo
	 */	
	public function logo() {
		print "\n<h1 align='center'>0xSentinel - Web Security System</h1>";
	}
	
	/**
	 * Header delle pagine
	 */	
	public function header() {
		include("config.php");
		print "<html>\n"
		."<head>\n"
		."<title>0xSentinel - v".VERSION."</title>\n"
		."<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n"
		."<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\" />\n"
		."</head>\n"
		."<body>\n";
	}
	
	/**
	 * menu normale senza login
	 */	
	public function menu() {
		print "<hr />\n<table class=\"menu\" width='auto'>\n"
			."<tr align='center'>\n"
				."<td width='500'><a href = 'login.php'>[-Login-]</a></td>\n"
				."<td width='500'><a href = 'about.php'>[-About-]</a></td>\n"
				."<td width='501'><a href = '?act=banner'>[-Banner-]</a></td>\n"
			."</tr>\n"
		."</table>\n<hr />\n";
	}
	
	/**
	 * Form di login
	 */	
	public function login() {
		print "<center>\n<form method='POST' action='".htmlspecialchars($_SERVER['PHP_SELF'])."' />\n"
			."Username: <input type='text' name='username' /><br />\n"
			."Password: <input type='password' name='password' /><br /><br />\n"
			."<input type='submit' value='Login' />\n"
			."</form>\n</center>\n";
	}
		
	/**
	 * Menu amministrativo
	 */		
	public function admin_menu() {
		print "<table class=\"menu\" width='auto'>\n"
			."<tr align='center'>\n"
				."<td width='501'><a href = 'admin.php?action=Status'>[-Status-]</a></td>\n"
				."<td width='501'><a href = 'admin.php?action=Settings'>[-Settings-]</a></td>\n"
				."<td width='501'><a href = 'admin.php?action=Rules'>[-Rules-]</a></td>\n"
				."<td width='501'><a href = 'admin.php?action=ban_ip'>[-Ban IP-]</a></td>\n"
				."<td width='501'><a href = 'admin.php?action=Logs'>[-Logs-]</a></td>\n"
				."<td width='501'><a href = 'index.php?act=banner'>[-Banner-]</a></td>\n"
				."<td width='501'><a href = 'admin.php?action=Logout&security=".$_SESSION['token']."'>[-Logout-]</a></td>\n"
			."</tr>\n"
		."</table>\n<br />\n<br />\n";
	}

	/**
	 * Footer delle pagine :D
	 */	
	public function footer() {
		print "<br /><br />\n<hr />\n<br />\n"
		."<p class='footer'>Powered By <a href='http://0xproject.netsons.org/#0xSentinel'>0xSentinel - v".VERSION."</a></p>\n"
		."</body>\n"
		."</html>\n";
	}

}
