<?php
/**
 * File: install.php
 * 
 * File per l'installazione
 *
 * @author KinG-InFeT <info@kinginfet.net>
 * @copyright GPL
 */
 
if(!(phpversion() >= '5.2.0')) {
	die('<h2 align="center">In questo server è installata una versione di PHP invferiore alla 5.2.0, quindi 0xSentinel non potrà essere installato causa futuri maltunzionamenti!<br />
		Si contatti l\'amministratore del server per aggiornare la versione di PHP installata sul server almeno alla 5.2.0</h2>');
}

if(!(is_writable('./config.php')))
	die("Il file config.php non ha i permessi di scrittura, impostarli a 777 per i server UNIX-Like");
	

if( isset($_GET['delete']) && $_GET['delete'] == 1 ){
	if( unlink("install.php") == FALSE ){
		die("<p align='center'><b>Unable to delete installation file</b><br>Please delete install.php manually for security reasons !</p>");
	}else{
		header("location: login.php");
	}
}	
?>
<html>
<head>
<title>0xSentinel Installation</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<body>
<br />
<h1 align="center">0xSentinel Installation</h1><br />
<table width="100%" border="0" align="center">
<?php
if( isset($_POST['install']) == FALSE ){
?>
<form method="POST">

<table align="center" border="0" width="35%">
		  <tbody><tr>
		  <td width="100%"><div>Database Settings</div></td>
		  </tr>
		  </tbody></table>	<table align="center" border="0" width="35%">
	<tbody><tr>
		<td><div align="left"><b>Host</b></div></td>
		<td><div align="right"><input name="host" type="text" width="150"></div></td>
	</tr>
	<tr>
		<td><div align="left"><b>Username</b></div></td>
		<td><div align="right"><input name="user" type="text" width="150"></div></td>
	</tr>
	<tr>
		<td><div align="left"><b>Password</b></div></td>
		<td><div align="right"><input name="pass" type="text" width="150"></div></td>
	</tr>
	<tr>
		<td><div align="left"><b>Database name</b></div></td>
		<td><div align="right"><input name="name" type="text" width="150"></div></td>
	</tr>
	</table>	
	<br>
	<table align="center" border="0" width="35%">
		  <tbody><tr>
		  <td width="100%"><div>General Settings</div></td>
		  </tr>
		  </tbody></table>	
	<table align="center" border="0" width="35%">
	<tbody><tr>
		<td><div align="left"><b>Admin username</b></div></td>
		<td><div align="right"><input name="admin_user" type="text" width="150"></div></td>
	</tr>
	<tr>
		<td><div align="left"><b>Admin password</b></div></td>
		<td><div align="right"><input name="admin_pass" type="password" width="150"></div></td>
	</tr>
	<tr>
		<td><div align="left"><b>Admin email</b></div><br></td>
		<td><div align="right"><input name="email" type="text" width="150"></div><br></td>
	</tr>
	<tr>
		<td></td>
		<td><div align="right"><input name="install" value="Install" type="submit"></div></td>
	</tr>
</form>
<?php
}else{
	$db_connect = @mysql_connect( $_POST['host'], $_POST['user'], $_POST['pass'] );
	$db_select  = @mysql_select_db( $_POST['name'] );
	
	if(!$db_connect){
		die("<b>Errore durante la connessione al database MySQL</b><br>".mysql_errno()." : ".mysql_error());
	} 
	elseif(!$db_select){
		die("<b>Errore durante la selezione del database MySQL</b><br>".mysql_errno()." : ".mysql_error());
	}

	if(!($fd = fopen( "config.php", "w+t" )))
		die("Errore durante l'apertura sul file config.php<br /> Prego di controllare i permessi sul file!");

	if( !fwrite( $fd, "<?php\n"
				 ."\t\$db_host = \"".$_POST['host']."\";\n"
				 ."\t\$db_user = \"".$_POST['user']."\";\n"
				 ."\t\$db_pass = \"".$_POST['pass']."\";\n"
				 ."\t\$db_name = \"".$_POST['name']."\";\n"
				 ."?>" ) ){
		die("Errore durante la scrittura del file config.php<br /> Prego di controllare i permessi sul file!");
	}

	fclose($fd); 
	
	$query_create = "CREATE TABLE `0xSentinel_rules` (
						`id` int(11) NOT NULL auto_increment,
						`type` TEXT NOT NULL,
						`regola` TEXT NOT NULL,
						`descrizione` TEXT NOT NULL,
						PRIMARY KEY  (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

	$query_insert = "INSERT INTO `0xSentinel_rules` (`id`, `type`, `regola`, `descrizione`) VALUES
(1, 'sql', '/select.+from.+(where)?.+/i', 'Blind SQL Injection'),
(2, 'xss', '/alert(.+)?((.+)?)/i', 'Cross Site Scripting'),
(3, 'sql', '/(''|&quot;)?.+or.+(''|&quot;)?.+/i', 'SQL Injection'),
(4, 'sql', '/(--|drop|alter|create|union|select|order|by|and)/i', 'SQL Injection'),
(5, 'sql', '/insert.+into.+value.+/i', 'SQL Injection'),
(6, 'sql', '/union.+(all).?+select.+from.+(where)?.+/i', 'SQL Injection'),
(7, 'lfi', '/(\\\.\\\.\\\/(.+)|\\\.\\\.\\\/|(.+)\\\/)/i', 'Local File Inclusion'),
(8, 'rfi', '/(http|https|ftp|webdav)\\\:\\\/\\\/(www\\\.)?.+(\\\.[A-Za-z]{1-4})?/i', 'Remote File Inclusion'),
(9, 'xss', '/(script|onclick|object|frame|iframe|frameset|img|applet|meta|style|form|onmouse|body|input|head|html)/i', 'Cross Site Scripting'),
(10, 'log_poisoning', '/(<|%3C)\\\?(php)?(.+)\\\?>/i', 'Log Poisoning'),
(11, 'lfi', '/(etc\\\/passwd|etc\\\/passwd|etc\\\/shadow|etc\\\/group|etc\\\/security\\\/passwd|etc\\\/security\\\/user)/i', 'Local File Inclusion'),
(12, 'sql', '/update.+set.+/i', 'SQL Injection'),
(13, 'sql', '/and.+[0-9]=[0-9]/i', 'SQL Injection'),
(14, 'sql', '/\\\/\\\*(.+)?(\\\*\\\/)?/', 'SQL Injection');";

	mysql_query($query_create) or die(mysql_error());
	mysql_query($query_insert) or die(mysql_error());
	
	$query_settings = "CREATE TABLE `0xSentinel_settings` (
				`active` smallint(5) unsigned NOT NULL default '1',
				`admin_user` TEXT NOT NULL,
				`admin_pass` TEXT NOT NULL,
				`email` TEXT NOT NULL,
				`filter_get` smallint(5) unsigned NOT NULL default '1',
				`filter_post` smallint(5) unsigned NOT NULL default '1',
				`filter_cookie` smallint(5) unsigned NOT NULL default '1',
				`filter_ip` smallint(5) unsigned NOT NULL default '1',				
				`email_notify` smallint(5) unsigned NOT NULL default '1'		
			  ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
			  
	$query_settings_insert = "INSERT INTO `0xSentinel_settings` 
						(`admin_user`, `admin_pass`, `email`) 
						VALUES 
						('".mysql_real_escape_string($_POST['admin_user'])."', '".md5($_POST['admin_pass'])."', '".mysql_real_escape_string($_POST['email'])."');";

	mysql_query($query_settings) or die(mysql_error());
	mysql_query($query_settings_insert) or die(mysql_error());
	
	
	$query_logs = "CREATE TABLE `0xSentinel_logs` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`pagina` TEXT NOT NULL ,
				`query_string` TEXT NOT NULL ,
				`type_attack` TEXT NOT NULL ,
				`referer` TEXT NOT NULL ,
				`ip` TEXT NOT NULL ,
				`data` TEXT NOT NULL,
				PRIMARY KEY  (`id`)
				) ENGINE = MYISAM DEFAULT CHARSET = latin1;";

	mysql_query($query_logs) or die(mysql_error());
	
	$query_ban_ip = "CREATE TABLE `0xSentinel_ban_ip` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`ip` TEXT NOT NULL ,
				`motivazione` TEXT NOT NULL ,
				`data` TEXT NOT NULL ,
				PRIMARY KEY  (`id`)
				) ENGINE = MYISAM DEFAULT CHARSET = latin1;";

	mysql_query($query_ban_ip) or die(mysql_error());	
	
	print "<h3 align='center'><b><font color='green'>Installation succesfully completed</font></b><br>Click <a href='?delete=1'>here</a> to delete installation file .</h3>";
}
?> 
</table>
</body>
</html>
