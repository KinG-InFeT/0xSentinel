<?php
/**
 * File: mysql.class.php
 * 
 * Classe che gestisce tutte le connessioni del MySQL
 *
 * @author KinG-InFeT <king-infet@autistici.org>
 * @copyright GPL
 */

if (preg_match("/mysql.class.php/", $_SERVER['PHP_SELF'])) die(htmlspecialchars($_SERVER['PHP_SELF']));

class MySQL
{
	public $query = '';
	public $open;
	
	/**
	 * Connessione al Database con controllo errori
	 */
	public function Open($db_host, $db_user, $db_pass, $db_name) {
	
		// se i campi sono inseriti
		if(empty($db_host) || empty($db_user) || empty($db_name))
			die("Errore! Non si sono inseriti i dati per la connessione!");

		// connetto al' host
		$this->open = mysql_connect($db_host, $db_user, $db_pass) or die("<b>Errore durante la connessione al database MySQL</b><br>".mysql_errno()." : ".mysql_error());

		// seleziono il db
		mysql_select_db($db_name, $this->open) or	die("<b>Errore durante la selezione del database MySQL</b><br>".mysql_errno()." : ".mysql_error());

	}

	/**
	 * Esegue la query al database
	 */
	public function Query($query) {

		// eseguo la query
		$ok = mysql_query($query) or die("SQL Error: ".mysql_error());
		return $ok;
	}

	/**
	 * Chiude la connessione al Database
	 */
	public function Close() {
		mysql_close($this->open);
	}
	
	/**
	 * Purifica le stringhe per l'inserimento in Database (Anti SQL Injection)
	 */
	public function mysql_parse($stringa) {
		return mysql_real_escape_string($stringa);
	}
	
	/**
	 * Parser Generale (Anti XSS and SQL Injection)
	 */
	public function str_parse($string) {
		return mysql_real_escape_string(htmlspecialchars($string));
	}
	
}
?>
