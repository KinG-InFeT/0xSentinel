<?php
/**
 * File: admin.class.php
 * 
 * Classe che gestisce gli strumenti di amministrazione
 *
 * @author KinG-InFeT <info@kinginfet.net>
 * @copyright GPL
 */

if (preg_match("/admin.class.php/", $_SERVER['PHP_SELF'])) die(htmlspecialchars($_SERVER['PHP_SELF']));

include_once("mysql.class.php");

class Admin extends MySQL
{

	public function check_version() {
		$link = 'http://www.0xproject.hellospace.net/versions/0xSentinel.txt';
		$version_ufficial = file_get_contents($link);
		$version = VERSION;
		
		if ($version != $version_ufficial) {
			echo "<script language=\"JavaScript\">if(confirm('Uscita la versione " . $version_ufficial . ". Vuoi venire reindirizzato alla pagina di download?.'))
			{
				 location.href = 'http://www.0xproject.hellospace.net/#0xSentinel';
			}
			</script>";
		}
	}

	public function check_email($mail) {
		$mail = trim($mail);
		
		if(empty($mail))
			return FALSE;

		$num_at = count(explode( '@', $mail )) - 1;
		if($num_at != 1)
			return FALSE;

		if(strpos($mail,';') || strpos($mail,',') || strpos($mail,' ') || strpos($mail,'\''))
			return FALSE;

		if(!preg_match( '/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}$/', $mail))
			return FALSE;
			
		return TRUE;
	}

	public function Status() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		$settings = $this->Query("SELECT * FROM 0xSentinel_settings");
		$row      = mysql_fetch_array($settings);
		
		$active        = ($row['active']        == 1) ? "<img src=\"images/on.png\" />" : "<img src=\"images/off.png\" />";
		$filter_get    = ($row['filter_get']    == 1) ? "<img src=\"images/on.png\" />" : "<img src=\"images/off.png\" />";
		$filter_post   = ($row['filter_post']   == 1) ? "<img src=\"images/on.png\" />" : "<img src=\"images/off.png\" />";
		$filter_cookie = ($row['filter_cookie'] == 1) ? "<img src=\"images/on.png\" />" : "<img src=\"images/off.png\" />";
		$filter_ip     = ($row['filter_ip']     == 1) ? "<img src=\"images/on.png\" />" : "<img src=\"images/off.png\" />";
		$email_notify  = ($row['email_notify']  == 1) ? "<img src=\"images/on.png\" />" : "<img src=\"images/off.png\" />";
		
		print "\n <table width=\"35%\" border=\"0\" align=\"center\">"
		  . "\n <tr>"
		  . "\n   <td width=\"232\"><div align=\"left\">0xSentinel version </div><br></td>"
		  . "\n   <td width=\"164\"><div align=\"right\">v".VERSION."</div><br></td>"
		  . "\n  </tr>"
		  . "\n <tr>"
		  . "\n   <td width=\"232\"><div align=\"left\">0xSentinel Active? </div><br></td>"
		  . "\n   <td width=\"164\"><div align=\"right\">".$active."</div><br></td>"
		  . "\n  </tr>"
		  . "\n "
		  . "\n <tr>"
		  . "\n   <td><div align=\"left\">\$_GET object filter </div></td>"
		  . "\n   <td><div align=\"right\">".$filter_get."</div></td>"
		  . "\n </tr>"
		  . "\n <tr>"
		  . "\n   <td><div align=\"left\">\$_POST object filter </div></td>"
		  . "\n   <td><div align=\"right\">".$filter_post."</div></td>"
		  . "\n  </tr>"
		  . "\n <tr>"
		  . "\n   <td height=\"16\"><div align=\"left\">\$_COOKIE object filter </div></td>"
		  . "\n   <td><div align=\"right\">".$filter_cookie."</div></td>"
		  . "\n </tr>"
		  . "\n <tr>"
		  . "\n   <td height=\"16\"><div align=\"left\">Ban IP System </div></td>"
		  . "\n   <td><div align=\"right\">".$filter_ip."</div></td>"
		  . "\n </tr>"
		  . "\n <tr>"
		  . "\n   <td><div align=\"left\">Email notification </div></td>"
		  . "\n   <td><div align=\"right\">".$email_notify."</div></td>"
		  . "\n  </tr>"
		  . "\n <tr>"
		  . "\n   <td><div align=\"left\">Admin Email </div></td>"
		  . "\n   <td><div align=\"right\">".htmlspecialchars($row['email'])."</div></td>"
		  . "\n </tr>"
		  . "\n </table>";
		  $this->check_version();
	}
	
	public function Settings() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$ris = $this->Query("SELECT * FROM 0xSentinel_settings");		

		if(isset($_POST['edit_settings'])) {
		
			if($this->check_email($_POST['email']) == FALSE)
				die('<script>alert("Email Inserita non valida!\nInserire una email valida del tipo: 0xSentinel@email.it"); window.location="admin.php?action=Settings";</script>');
		
			$this->Query("UPDATE 0xSentinel_settings SET 
							active = '".$this->mysql_parse($_POST['active'])."',
							email = '".$this->mysql_parse($_POST['email'])."',							
							filter_get = '".$this->mysql_parse($_POST['get_filter'])."',
							filter_post = '".$this->mysql_parse($_POST['post_filter'])."',
							filter_cookie = '".$this->mysql_parse($_POST['cookie_filter'])."',
							filter_ip = '".$this->mysql_parse($_POST['filter_ip'])."',							
							email_notify = '".$this->mysql_parse($_POST['notify_email'])."'");

			header('Location: admin.php');
		}else{
			$row = mysql_fetch_array($ris);	
			$active        = ($row['active']        == 1) ? "<option value='1' selected>Attiva</option>\n<option value='0'>Disattiva</option>\n" : "<option value='0' selected>Disattiva</option>\n<option value='1'>Attiva</option>\n";
			$filter_get    = ($row['filter_get']    == 1) ? "<option value='1' selected>SI</option>\n<option value='0' >NO</option>\n" : "<option value='0' selected>NO</option>\n<option value='1' >SI</option>\n";
			$filter_post   = ($row['filter_post']   == 1) ? "<option value='1' selected>SI</option>\n<option value='0' >NO</option>\n" : "<option value='0' selected>NO</option>\n<option value='1' >SI</option>\n";
			$filter_cookie = ($row['filter_cookie'] == 1) ? "<option value='1' selected>SI</option>\n<option value='0' >NO</option>\n" : "<option value='0' selected>NO</option>\n<option value='1' >SI</option>\n";
			$filter_ip     = ($row['filter_ip']     == 1) ? "<option value='1' selected>SI</option>\n<option value='0' >NO</option>\n" : "<option value='0' selected>NO</option>\n<option value='1' >SI</option>\n";			
			$email_notify  = ($row['email_notify']  == 1) ? "<option value='1' selected>SI</option>\n<option value='0' >NO</option>\n" : "<option value='0' selected>NO</option>\n<option value='1' >SI</option>\n";
			
			print "<form name=\"edit_settings\" method=\"POST\">\n"
			  . "\n<table width=\"35%\" border=\"0\" align=\"center\" >\n"
			  . "\n<tr width=\"100%\">\n"
			  . "\n<td><div align=\"left\">0xSentinel Attivo/Disattivo</div></td>\n"
			  . "\n<td><div align=\"right\"><select class='textbox' name='active'>\n"
			  . "\n	".$active."\n"
			  . "\n</select></div></td>\n"
			  . "\n</tr>\n"
			  . "\n<tr>\n"
			  . "\n<td><div align=\"left\">\$_GET object filter </div></td>"
			  . "\n<td><div align=\"right\">"
			  . "\n<select class='textbox' name='get_filter'>"
			  . "\n	".$filter_get.""
			  . "\n</select>"
			  . "\n</div></td>"
			  . "\n</tr>"
			  . "\n<tr>"
			  . "\n<td><div align=\"left\">\$_POST object filter </div></td>"
			  . "\n<td><div align=\"right\">"
			  . "\n<select class='textbox' name='post_filter'>"
			  . "\n	".$filter_post.""
			  . "\n</select>"
			  . "\n</div></td>"
			  . "\n</tr>"
			  . "\n<tr>"
			  . "\n<td><div align=\"left\">\$_COOKIE object filter </div></td>"
			  . "\n<td><div align=\"right\">"
			  . "\n<select class='textbox' name='cookie_filter'>"
			  . "\n	".$filter_cookie.""
			  . "\n</select>	"
			  . "\n</div></td>"
			  . "\n</tr>"
			  . "\n<tr>"
			  . "\n<td><div align=\"left\">Ban IP System </div></td>"
			  . "\n<td><div align=\"right\">"
			  . "\n<select class='textbox' name='filter_ip'>"
			  . "\n	".$filter_ip.""
			  . "\n</select>		"
			  . "\n</div></td>"
			  . "\n</tr>"			  
			  . "\n<tr>"
			  . "\n<td><div align=\"left\">Email notification </div></td>"
			  . "\n<td><div align=\"right\">"
			  . "\n<select class='textbox' name='notify_email'>"
			  . "\n	".$email_notify.""
			  . "\n</select>		"
			  . "\n</div></td>"
			  . "\n</tr>"
			  . "\n<tr>"
			  . "\n<td><div align=\"left\">Administrator email </div><br></td>"
			  . "\n<td><div align=\"right\">"
			  . "\n<input type=\"text\" class=\"textbox\" name=\"email\" width=\"150px\" value=\"".htmlspecialchars($row['email'])."\">"
			  . "\n</div><br></td>"
			  . "\n</tr>"			  
			  . "\n<tr>"
			  . "\n<td><div align=\"left\"></div></td>"
			  . "\n<td><div align=\"right\">"
			  . "\n<input type=\"submit\" name=\"edit_settings\" value=\"Save\">"
			  . "\n</div></td>"
			  . "\n</tr>"
			  . "\n</table>"
			  . "\n</form>"
			 ."\n";
		}
	}
	
	public function rules() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$ris = $this->Query("SELECT * FROM 0xSentinel_rules");
		print "<table align='center'>\n"
			."<tr>\n"
				."<td style='border: 1px solid rgb(255,255,255)' align='center'>Tipo</td>\n"
				."<td style='border: 1px solid rgb(255,255,255)' align='center'>Regola</td>\n"
				."<td style='border: 1px solid rgb(255,255,255)' align='center'>Descrizione</td>\n"
				."<td style='border: 1px solid rgb(255,255,255)' align='center'>Opzioni</td>\n"
			."<tr>\n";
		while($row = mysql_fetch_array($ris)) {
			print "<tr>\n"
				."<td>".$row['type']."</td>\n"
				."<td>".$row['regola']."</td>\n"
				."<td>".$row['descrizione']."</td>\n"
				."<td><a href='admin.php?action=delete_rule&id=".$row['id']."'>[-Elimina-]</a> /~\ <a href='admin.php?action=edit_rule&id=".$row['id']."'>[-edita-]</a> </td>\n"
			. "\n<tr>\n";
		}
		print '</table>';
		print "\n<p align='right'><a href='admin.php?action=add_rule'>[-Add Rule-]</a></p>\n";
	}
	
	public function Logs() {
		global $db_host, $db_user, $db_pass, $db_name;	
		
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$lista = $this->Query("SELECT * FROM 0xSentinel_logs");
		
		print "<table width='100%' align='center'>\n"
		. "\n<tr>\n"
		. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>Pagina</b></td>\n"
		. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>Query</b></td>\n"
		. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>Type Attack</b></td>\n"
		. "\n<td width='10%' style='border:1px solid #000;' align='center'><b>Referer</b></td>\n"
		. "\n<td width='5%' style='border:1px solid #000;' align='center'><b>IP</b></td>\n"
		. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>Data/Ora</b></td>\n"
		. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>#</b></td>\n"		
		. "\n</tr>";
		
		while($row = mysql_fetch_array($lista)) {
			print "<tr>\n"
			. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>".$row['pagina']. "\n</b></td>\n"
			. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>".$row['query_string']. "\n</b></td>\n"
			. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>".$row['type_attack']. "\n</b></td>\n"
			. "\n<td width='10%' style='border:1px solid #000;' align='center'><b>".$row['referer']. "\n</b></td>\n"
			. "\n<td width='5%' style='border:1px solid #000;' align='center'><b>".$row['ip']. "\n</b></td>\n"
			. "\n<td width='20%' style='border:1px solid #000;' align='center'><b>".$row['data']. "\n</b></td>\n"
			. "\n<td width='20%' style='border:1px solid #000;' align='center'><b><a href='admin.php?action=delete_log&id=".$row['id']."'>[-Elimina-]</a></b></td>\n"			
			. "\n</tr>\n";
		}
		print "</table>";
	
	
	}
	public function add_rule() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		if(isset($_POST['add'])) {
				$this->Query("INSERT INTO `0xSentinel_rules` (`type`, `regola`, `descrizione`) VALUES ('".$this->str_parse($_POST['type'])."', '".$this->str_parse($_POST['regola'])."', '".$this->str_parse(stripslashes($_POST['descrizione']))."');");
				header('Location: admin.php?action=Rules');
		}else{
			print '<table align="center">
				<tr><td><form method="POST" action="admin.php?action=add_rule" />
				Type:</td></tr><tr><td> <select name="type">
						<option value="lfi">Local File Inclusion</option>
						<option value="sql">SQL Injection</option>
						<option value="log_poisoning">Log Poisoning</option>
						<option value="xss">Cross Site Script</option>
						<option value="rfi">Remote File Inclusion</option>						
					</select></td></tr><tr>
				<td>Regola:</td></tr><tr><td> <input type="text" name="regola" value="/Regex/i" size="40" /></td></tr><tr>
				<td>Descrizione:</td></tr><tr><td> <input type="text" name="descrizione" value="" size="40"/></td></tr><tr>
				<td></tr><tr><td><input type="submit" name="add" value="Aggiungi" />
				</form></td></tr>
				</table>';
		}				
	}
		
				
	
	public function delete_log($id) {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$check = $this->Query("DELETE FROM 0xSentinel_logs WHERE id = '".(int) $id."'");
		
		if($check == FALSE)
			die("<center><h3>Errore durante l'eliminazione del Log!</h3><br /><a href='admin.php?action=Rules'>Torna Indietro</a></center>");
		else 
			header('Location: admin.php?action=Logs');
	}
	
	public function delete_rule($id) {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$check = $this->Query("DELETE FROM 0xSentinel_rules WHERE id = '".(int) $id."'");
		
		if($check == FALSE)
			die("<center><h3>Errore durante l'eliminazione della Regola!</h3><br /><a href='admin.php?action=Rules'>Torna Indietro</a></center>");
		else 
			header('Location: admin.php?action=Rules');
	}
	
	public function edit_rule($id) {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$ris = $this->Query("SELECT * FROM 0xSentinel_rules WHERE id = '".(int) $id."'");
		$row = mysql_fetch_array($ris);
		
		if(isset($_POST['edit'])) {
				$this->Query("UPDATE 0xSentinel_rules SET 
									type = '".$this->str_parse($_POST['type'])."',
									regola = '".$this->str_parse($_POST['regola'])."',
									descrizione = '".$this->str_parse(stripslashes($_POST['descrizione']))."' WHERE id = '".(int) $_GET['id']."'");
									
				header('Location: admin.php?action=Rules');
		}else{
			print '<table align="center">
				<tr><td><form method="POST" action="admin.php?action=edit_rule&id='.(int) $_GET['id'].'" />
				Type: </td></tr><tr><td><input type="text" size="50" name="type" value="'.htmlspecialchars($row['type']).'" /></td></tr><tr>
				<td>Regola: </td></tr><tr><td><input type="text" size="100" name="regola" value="'.htmlspecialchars($row['regola']).'" /></td></tr><tr>
				<td>Descrizione:</td></tr><tr><td> <input type="text" size="80" name="descrizione" value="'.htmlspecialchars($row['descrizione']).'" /></td></tr><tr>
				<td></tr><tr><td><input type="submit" name="edit" value="Edita" />
				</form></td></tr>
				</table>';
		}
		
		
	}
			
}

?>
