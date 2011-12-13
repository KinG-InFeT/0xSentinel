<?php
/*
 *
 * @project 0xSentinel
 * @author KinG-InFeT
 * @licence GNU/GPL
 *
 * @file install.php
 *
 * @link http://0xproject.netsons.org#0xSentinel
 *
 */
 
if(!(phpversion() >= '5.2.0')) {
	die('<h2 align="center">In questo server è installata una versione di PHP invferiore alla 5.2.0, quindi 0xSentinel non potrà essere installato causa futuri maltunzionamenti!<br />
		Si contatti l\'amministratore del server per aggiornare la versione di PHP installata sul server almeno alla 5.2.0</h2>');
}

if(!(is_writable('./config.php')))
	die("Il file config.php non ha i permessi di scrittura, impostarli a 777 per i server UNIX-Like");
	

if( isset($_GET['delete']) && $_GET['delete'] == 1 ) {
	if( (unlink("install.php") == FALSE) || (unlink("rules.sql") == FALSE) ) {
		die("<p align='center'><b>Unable to delete installation file</b><br>Please delete install.php and rules.sql manually for security reasons !</p>");
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
	
	if(!$db_connect) {
		die("<b>Errore durante la connessione al database MySQL</b><br>".mysql_errno()." : ".mysql_error());
	} 
	elseif(!$db_select) {
		die("<b>Errore durante la selezione del database MySQL</b><br>".mysql_errno()." : ".mysql_error());
	}

	if(!($fd = fopen( "config.php", "w+t" )))
		die("Errore durante l'apertura sul file config.php<br /> Prego di controllare i permessi sul file!");

	if( !fwrite( $fd, "<?php\n"
				 ."\t\$db_host = \"".trim($_POST['host'])."\";\n"
				 ."\t\$db_user = \"".trim($_POST['user'])."\";\n"
				 ."\t\$db_pass = \"".trim($_POST['pass'])."\";\n"
				 ."\t\$db_name = \"".trim($_POST['name'])."\";\n"
				 ."?>" ) ) {
		die("Errore durante la scrittura del file config.php<br /> Prego di controllare i permessi sul file!");
	}

	fclose($fd); 
	
	$query_create = "CREATE TABLE `0xSentinel_rules` (
						`id` int(11) NOT NULL auto_increment,
						`type` TEXT NOT NULL,
						`regola` TEXT NOT NULL,
						`descrizione` TEXT NOT NULL,
						PRIMARY KEY  (`id`)
					);";
					
    $read_file = fopen("rules.sql","r");
    $dim_file  = filesize("rules.sql");
    $content   = fread($read_file,$dim_file);//contenuto
    fclose($read_file);

	mysql_query($query_create) or die(mysql_error());
	mysql_query($content)      or die(mysql_error());
	
	$query_settings = "CREATE TABLE `0xSentinel_settings` (
				`active` smallint(5) unsigned NOT NULL default 1,
				`admin_user` TEXT NOT NULL,
				`admin_pass` TEXT NOT NULL,
				`email` TEXT NOT NULL,
				`filter_get` smallint(5) unsigned NOT NULL default 1,
				`filter_post` smallint(5) unsigned NOT NULL default 1,
				`filter_cookie` smallint(5) unsigned NOT NULL default 1,
				`filter_session` smallint(5) unsigned NOT NULL default 1,
				`filter_ip` smallint(5) unsigned NOT NULL default 1,
				`filter_csrf` smallint(5) unsigned NOT NULL default 1,
				`filter_fpd` smallint(5) unsigned NOT NULL default 1,
				`filter_scanner` smallint(5) unsigned NOT NULL default 1,
				`email_notify` smallint(5) unsigned NOT NULL default 1
			  );";
			  
	$query_settings_insert = "INSERT INTO `0xSentinel_settings` 
						(`admin_user`, `admin_pass`, `email`) 
						VALUES 
						('".mysql_real_escape_string(trim($_POST['admin_user']))."', '".md5(trim($_POST['admin_pass']))."', '".mysql_real_escape_string(trim($_POST['email']))."');";

	mysql_query($query_settings)        or die(mysql_error());
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
				);";

	mysql_query($query_logs) or die(mysql_error());
	
	$query_ban_ip = "CREATE TABLE `0xSentinel_ban_ip` (
    	    			`id` INT NOT NULL AUTO_INCREMENT ,
    	    			`ip` TEXT NOT NULL ,
    	    			`motivazione` TEXT NOT NULL ,
          				`data` TEXT NOT NULL ,
				        PRIMARY KEY  (`id`)
				    );";

	mysql_query($query_ban_ip) or die(mysql_error());	
	
	print "\n<h3 align='center'><b><font color='green'>Installation succesfully completed</font></b>"
	    . "\n<br />Click <a href='?delete=1'>here</a> to delete installation file .</h3>";
}
?> 
</table>
</body>
</html>
