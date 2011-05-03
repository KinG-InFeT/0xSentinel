<?php
/**
 * File: banip.class.php
 * 
 * Classe che gestisce gli strumenti di amministrazione del sistema di Ban IP
 *
 * @author KinG-InFeT <info@kinginfet.net>
 * @copyright GPL
 */

if (preg_match("/banip.class.php/", $_SERVER['PHP_SELF'])) die(htmlspecialchars($_SERVER['PHP_SELF']));

include_once("mysql.class.php");

class BanIP extends MySQL
{

	private function check_ip($ip) {
	
		if(filter_var($ip, FILTER_VALIDATE_IP))
			return TRUE;
		else
			return FALSE;
	}
	
	public function check_duplicate_ip($ip) {
	    global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$this->sql = $this->Query("SELECT ip FROM 0xSentinel_ban_ip WHERE ip = '".$this->mysql_parse($ip)."'");
		$this->check_duplicate = mysql_num_rows($this->sql);
		
		if($this->check_duplicate > 0)
		    return TRUE;
		else
		    return FALSE;	
	}
	
	public function add_ip() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		if(isset($_POST['add'])) {
		
			if($this->check_ip($_POST['ip']) == FALSE)
				die("<center><h3>Errore! IP inserito non valido!</h3><br /><a href='admin.php?action=add_ip'>Torna Indietro</a></center>");
            
            if($_POST['security'] != $_SESSION['token'])
                die("CSRF Attemp!");
            
            if($this->check_duplicate_ip($_POST['ip']) == TRUE)
                die("<center><h3>Errore! IP gi&agrave; presente del Database!</h3><br /><a href='admin.php?action=add_ip'>Torna Indietro</a></center>");
                
			$this->Query("INSERT INTO `0xSentinel_ban_ip` 
					(`ip`, `motivazione`, `data`) 
						VALUES 
					('".$this->str_parse($_POST['ip'])."', '".$this->str_parse(stripslashes($_POST['motivazione']))."', '".@date("d-m-y")."');") or die(mysql_error());

			header('Location: admin.php?action=ban_ip');
		}else{
			print '<table align="center">
				<form method="POST" action="admin.php?action=add_ip" />
				<tr><td>IP: </td></tr><tr><td> <input type="text" name="ip" /></td></tr>
				<tr><td>Motivazione:</td></tr><tr><td> <input type="text" name="motivazione" value="" /></td></tr>
				<input type="hidden" name="security" value="'.$_SESSION['token'].'" />
				<tr><td><input type="submit" name="add" value="Aggiungi" />
				</form></td></tr>
				</table>';
		}
	}
	
	public function ban_ip() {
		global $db_host, $db_user, $db_pass, $db_name;
		
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$lista = $this->Query("SELECT * FROM 0xSentinel_ban_ip");
		
		print "<table width='100%' align='center'>\n"
		."<tr>\n"
		."<td width='20%' style='border:1px solid #000;' align='center'><b>IP</b></td>\n"
		."<td width='20%' style='border:1px solid #000;' align='center'><b>Motivazioni</b></td>\n"
		."<td width='10%' style='border:1px solid #000;' align='center'><b>Data</b></td>\n"
		."<td width='20%' style='border:1px solid #000;' align='center'><b>#</b></td>\n"
		."</tr>";
		
		while($row = mysql_fetch_array($lista)) {
			print "<tr>\n"
			."<td width='20%' style='border:1px solid #000;' align='center'><b>".$row['ip']."</b></td>\n"
			."<td width='20%' style='border:1px solid #000;' align='center'><b>".$row['motivazione']."</b></td>\n"
			."<td width='10%' style='border:1px solid #000;' align='center'><b>".$row['data']."</b></td>\n"
			."<td width='20%' style='border:1px solid #000;' align='center'><b><a href='admin.php?action=delete_ip&id=".$row['id']."&security=".$_SESSION['token']."'><img src=\"images/delete.gif\" alt=\"Delete IP\" /></a></b></td>\n"
			."</tr>\n";
		}
		print "</table>";	
		print "\n<p align='right'><a href='admin.php?action=add_ip'><img src=\"images/add.png\" alt=\"Add IP\" /></a></p>\n";
	}
	
	public function delete_ip($id, $security) {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		if($security != $_SESSION['token'])
		    die("CSRF Attemp!");
		
		$check = $this->Query("DELETE FROM 0xSentinel_ban_ip WHERE id = '".intval( $id )."'");
		
		if($check == FALSE)
			die("<center><h3>Errore durante l'eliminazione del Log!</h3><br /><a href='admin.php?action=ban_ip'>Torna Indietro</a></center>");
		else 
			header('Location: admin.php?action=ban_ip');
	}	
		
}
?>
