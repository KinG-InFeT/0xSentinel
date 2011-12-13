<?php
/**
 * File: 0xSentinel.class.php
 * 
 * La classe che gestisce l'intero sistema di sicurezza
 *
 * @author KinG-InFeT <king-infet@autistici.org>
 * @copyright GPL
 */

if (preg_match("/0xSentinel.class.php/", $_SERVER['PHP_SELF'])) die(htmlspecialchars($_SERVER['PHP_SELF']));

include_once("mysql.class.php");

class Sentinel extends MySQL
{
	private $regole = array();
	
	public function email_notification($page, $query, $ref, $IP, $date, $time, $UA, $descrizione ) {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$ris = $this->Query("SELECT * FROM 0xSentinel_settings");
		$row = mysql_fetch_array($ris);
			
		$email_contenuto = "<html>"
		  . "\n <head>"
		  . "\n <title>0xSentinel REPORT</title>"
		  . "\n <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">"
		  . "\n <meta name=\"robots\" content=\"index,follow\">"
		  . "\n <style type=\"text/css\">"
		  . "\n <!--"
		  . "\nhtml, body {"
		  . "\nbackground: #000000;"
		  . "\ncolor: #FFFFFF;"
		  . "\nfont-size: 11px;"
		  . "\nmargin: 0px;"
		  . "\npadding: 20px;"
		  . "\ntext-align: left;"
		  . "\nfont-family: monospace;"
		  . "\n} "
		  . "\n .testo {"
		  . "\n  FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #505050; FONT-STYLE: normal; FONT-FAMILY: Verdana, sans-serif"
		  . "\n }"
		  . "\n .commento {"
		  . "\n  FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #9e9e9e; FONT-STYLE: italic; FONT-FAMILY: Verdana, sans-serif"
		  . "\n }"
		  . "\n.pic {"
		  . "\n  FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #505050; FONT-STYLE: normal; FONT-FAMILY: Verdana,  sans-serif; "
		  . "\n } "
		  . "\n H3 { FONT-WEIGHT: bold; FONT-SIZE:12px; COLOR:#505050; margin: 0px; padding: 0px }"
		  . "\n H3.normal { COLOR:#4579ae }"
		  . "\n"
		  . "\n table.col {"
		  . "\n width:100%; border:1px solid #c9d9ec;"
		  . "\n }"
		  . "\n table.col1 {"
		  . "\n width:100%; border:1px solid #6ea7c5;"
		  . "\n } "
		  . "\n table.col2 {"
		  . "\n width:100%; border:1px solid #6ea7c5;"
		  . "\n } "
		  . "\n.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #505050; FONT-STYLE: normal; FONT-FAMILY:   Verdana, sans-serif; }"
		  . "\n -->"
		  . "\n </style>"
		  . "\n </head>"
		  . "\n <body >"
		  . "\n <center>"
		  . "\n"
		  . "\n <!-- Header -->"
		  . "\n"
		  . "\n <table border=\"0\" width=\"596\" cellpadding=\"0\" cellspacing=\"0\" class=\"testo\">"
		  . "\n  <tr><td align=\"right\" valign=\"bottom\"><h3 class=\"normal\">".htmlspecialchars($page)." -0xSentinel REPORT-</h3></td>"
		  . "\n  </tr>"
		  . "\n  <tr><td bgcolor=\"#134b83\" height=\"1\"></td></tr>"
		  . "\n </table> "
		  . "\n<font color=\"red\">"
		  . "\n <table width=\"596\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"testo\">"
		  . "\n         <tr><td><h3 class=\"normal\">&nbsp;</h3></td></tr>"
		  . "\n         "
		  . "\n         <tr><td>"
		  . "\n         <table width=\"595\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\" bgcolor=\"#F7F7F7\" style=\"border:1px solid #E1E1E1;\">"
		  . "\n              <tr><td colspan=\"2\" class=\"testo\"><p>On ".$date." ".$time." was detected an hacking attempt on  ".htmlspecialchars($page)." :</p>"
		  . "\n                <p>Type: ".$descrizione."</p></td></tr>"
		  . "\n         </table>"
		  . "\n         <tr><td height=\"10\"><br></td></tr>"
		  . "\n         <tr><td bgcolor=\"#134b83\" height=\"1\">"
		  . "\n </td></tr>"
		  . "\n"
		  . "\n"
		  . "\n</td></tr>"
		  . "\n </table>        "
		  . "\n"
		  . "\n <table width=\"596\" bgcolor=\"#ffffff\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\" class=\"testo\">"
		  . "\n  <tr >"
		  . "\n    <td width=\"100\" height=\"13\">&nbsp;</td>"
		  . "\n    </tr>"
		  . "\n  <tr bgcolor=\"#E1E1E1\">"
		  . "\n    <td height=\"20\" colspan=\"2\"><b>DETAILS</b><b></b></td>"
		  . "\n    </tr>"
		  . "\n  <tr>"
		  . "\n    <td><table class=\"col\">"
		  . "\n      <tr>"
		  . "\n        <td class=\"testo\"><div align=\"right\"><strong>Address</strong></div></td>"
		  . "\n      </tr>"
		  . "\n    </table></td>"
		  . "\n    <td width=\"490\">".$IP."</td>"
		  . "\n    </tr>"
		  . "\n  <tr>"
		  . "\n    <td><table class=\"col\">"
		  . "\n      <tr>"
		  . "\n        <td class=\"style2\"><div align=\"right\">Query String</div></td>"
		  . "\n      </tr>"
		  . "\n    </table></td>"
		  . "\n    <td>".htmlspecialchars(rawurlencode($query))."</td>"
		  . "\n    </tr>"
		  . "\n  <tr>"
		  . "\n    <td><table class=\"col\">"
		  . "\n      <tr>"
		  . "\n        <td class=\"style2\"><div align=\"right\">HTTP Referer</div></td>"
		  . "\n      </tr>"
		  . "\n    </table></td>"
		  . "\n    <td>".@$referer."</td>"
		  . "\n    </tr>"
		  . "\n  <tr>"
		  . "\n    <td><table class=\"col\">"
		  . "\n      <tr>"
		  . "\n        <td class=\"style2\"><div align=\"right\">Agent</div></td>"
		  . "\n      </tr>"
		  . "\n    </table></td>"
		  . "\n    <td>".htmlspecialchars($UA)."</td>"
		  . "\n    </tr>"
		  . "\n </table>"
		  . "\n <br>"
		  . "\n</font>"
		  . "\n"
		  . "\n <!-- Footer -->"
		  . "\n <table border=\"0\" width=\"600\" cellpadding=\"0\" cellspacing=\"0\" class=\"testo\">"
		  . "\n  <tr><td rowspan=\"2\" width=\"10\"><td bgcolor=\"#E1E1E1\" height=\"1\"></td><td rowspan=\"2\" width=\"10\"></tr>"
		  . "\n  <tr>"
		  . "\n    <td height=\"25\" align=\"center\" class=\"shiny\"><em><a href=\"http://0xproject.netsons.org/#0xSentinel\">0xSentinel</a> - Copyleft 2010 By <a href=\"mailto:king-infet@autistici.org\">KinG-InFeT</a></em></td>"
		  . "\n  </tr>"
		  . "\n"
		  . "\n </table>"
		  . "\n </center>"
		  . "\n </body>"
		  . "\n </html>";
		 
	    $to      = $row['email'];
	    $from    = $row['email'];
	    $oggetto = "0xSentinel REPORT !!! SYSTEM LOCKED !!!";
	    
	    $headers  = "MIME-Version: 1.0";
	    $headers .= "\r\nContent-type: text/html; charset=iso-8859-1";
	    $headers .= "\r\nFrom: $from";
		
		if($row['email_notify'] == 1) {
			@mail($to, $oggetto, $email_contenuto, $headers);
		}
 	}

	public function blocca($page, $query, $ref, $IP) {
    	global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$ris = $this->Query("SELECT email FROM 0xSentinel_settings");
		$row = mysql_fetch_row($ris);
		
		$block = "<html>"
				. "\n<head>"
				. "\n<link rel='StyleSheet' type='text/css'>"
				. "\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />"
				. "\n<title>!!! 0xSentinel Attacks Blocker !!!</title>"
				. "\n<style type=\"text/css\">"
				. "\na:visited, a:link, a:active {"
				. "\n\ttext-decoration: none;"
				. "\n\tcolor: #5588aa;"
				. "\n}"
				. "\na:hover {"
				. "\n\tcolor: #ff6000;"
				. "\n\ttext-decoration: underline;"
				. "\n}"
				. "\nbody {"
				. "\n\tbackground: #000000;"
				. "\n\tfont-size: 11px;"
				. "\n\tcolor: #FFFFFF;"
				. "\n\tmargin: 0px;"
				. "\n\tpadding: 20px;"
				. "\n\ttext-align: left;"
				. "\n\tfont-family: monospace;"
				. "\n}"
				. "\n</style>"
				. "\n</head>"
				. "\n<body>"
				. "\n<br/><br/>"
				. "\n<table width=\"80%\" border=\"0\" align=\"center\">"
				. "\n<tr>"
				. "\n<td valign=\"top\"><div align=\"center\"><font color=\"#FF0000\">!!! 0xSentinel Attacks Blocker !!!</font><br /><img src=\"/0xSentinel/images/logo.png\"></div>"
				. "\n<p>"
				. "	\n<br/>"
				. "	\nAlcuni dati che hai inviato a questo sito sono stati classificati come pericolosi dal sistema di sicurezza 0xSentinel, <br />"
				. "\ndi conseguenza il sistema ha bloccato questi dati malevoli ed a avvertito l'amministratore con il report di vari dati della persona attaccante compreso l'IP .<br />"
				. "\nDi seguito trovi le informazioni così come sono state inviate all'amministratore :"
				. "\n</p> "
				. "\n<p>"
				. "\n<font color=\"#FF0000\">#IP: ".$IP."<br />#Pagina di attacco: ".htmlspecialchars($page)."<br /> #Stringa di attacco: ?".htmlspecialchars(rawurldecode($query))."<br /> #Referer: ".htmlspecialchars($ref)."<br /> </font>"
				. "\n</p>"
				. "\n</td>"
				. "\n</tr>"
				. "\n</td>"
		        . "\n    <td><br />Se pensi che il sistema di sicurezza 0xSentinel ha bloccato un Falso Positivo, contatta <a href=\"meilto:".$row[0]."\">l'ammministratore</a> del sito e provvederà al fix delle regole</td>"
         	    . "\n    </tr>"
				. "\n<tr> "
				. "\n<td height=\"38\" align='right'><em><a href=\"http://0xproject.netsons.org/#0xSentinel\">0xSentinel</a> By <a href=\"http://www.kinginfet.net/\">KinG-InFeT</a></em></td>"
				. "\n</tr>"
				. "\n</table>"
				. "\n</body>"
				. "\n</html>";
		die($block);
	}
	
	public function check_type_attack($regola) {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$regola = $this->mysql_parse($regola);
		
		if(($regola == 'scanner' ) || 
		   ($regola == 'perl'     ) || 
		   ($regola == 'cookie'   ) ||
		   ($regola == 'csrf'     ) ||
		   ($regola == 'session'  ) ||
		   ($regola == 'fpd'      )
		  ) {
		
			if($regola == 'scanner')
				$type = "Scanning/Crawling Attack";
				
			if($regola == 'perl')
				$type = "Exploit in PERL";
			
			if($regola == 'cookie')
			    $type = "\$_COOKIE Attack";
			    
			if($regola == 'session')
			    $type = "\$_SESSION Attack";
			
			if($regola == 'csrf')
			    $type = "Cross Site Request Forgery";
			    
			if($regola == 'fpd')
			    $type = "Full Path Disclosure Attack";
			    
		}else{
				
			$sql  = $this->Query("SELECT type,descrizione FROM 0xSentinel_rules WHERE regola = '{$regola}'");
			$row  = mysql_fetch_array($sql);
			$type = htmlspecialchars(stripslashes(strtolower($row['type']))); 
			
			switch($type) {
				case 'sql':
					$type = $row['descrizione'];
				break;
				
				case 'xss':
					$type = $row['descrizione'];
				break;
				
				case 'lfi':
					$type = $row['descrizione'];
				break;
				
				case 'rfi':
					$type = $row['descrizione'];
				break;
				
				case 'log_poisoning':
					$type = $row['descrizione'];
				break;
				
				default:
				 	$type = "Sconosciuto";	
				break;
			}
		}
		return $type;
	}
	
	private function logga($page, $query, $ref, $IP, $cattivo) {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$pagina       = $this->str_parse($page);
		$query_string = $this->str_parse(rawurldecode($query));
		$referer      = $this->str_parse($ref);
		$ip           = $IP;
		$type_attack  = $this->str_parse($this->check_type_attack($cattivo));
		$ora          = date("H:i:s");
		$data         = date("d-m-y");
		
		$this->Query("INSERT INTO 0xSentinel_logs (pagina, query_string, type_attack, referer, ip, data) VALUES ('{$pagina}', '{$query_string}', '{$type_attack}', '{$referer}', '{$ip}', 'Il {$data} alle ore {$ora}')");
		$this->Close();
		$this->email_notification($pagina, $query_string, $referer, $ip, $data, $ora, $_SERVER['HTTP_USER_AGENT'], $type_attack);
	}
	
	public function check_FPD() {
				
		foreach($_GET as $request) 
		{
            if(is_array($request))
            {
				$this->logga($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], "fpd");
				$this->blocca($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR']);
			}
		}
	}
	
	public function check_GET() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$rules = $this->Query("SELECT * FROM 0xSentinel_rules");
			
		while ($row = mysql_fetch_array ($rules))
			$this->regole[] =  $row['regola'];
				
		foreach($_GET as $request)
		{
			foreach($this->regole as $regex)
			{
				if (preg_match("{$regex}", rawurldecode($request)))
				{
					$this->logga($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $regex);
					$this->blocca($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR']);
				}
			}
		}		
	}
	
	public function check_POST() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$rules = $this->Query("SELECT * FROM 0xSentinel_rules");
			
		while ($row = mysql_fetch_array ($rules))
			$this->regole[] =  $row['regola'];
				
		foreach($_POST as $request)
		{
			foreach($this->regole as $regex)
			{
				if (preg_match("{$regex}", rawurldecode($request)))
				{
					$this->logga($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $regex);
					$this->blocca($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR']);
				}
			}
		}		
	}
	
	public function check_COOKIE() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$rules = $this->Query("SELECT * FROM 0xSentinel_rules");
			
		while ($row = mysql_fetch_array ($rules))
			$this->regole[] =  $row['regola'];
				
		foreach($_COOKIE as $request)
		{
			foreach($this->regole as $regex)
			{
				if (preg_match("{$regex}", (string) $request))
				{
					$this->logga($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], "cookie");
					$this->blocca($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR']);
				}
			}
		}		
	}
	
	public function check_SESSION() {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$rules = $this->Query("SELECT * FROM 0xSentinel_rules");
			
		while ($row = mysql_fetch_array ($rules))
			$this->regole[] =  $row['regola'];
				
		foreach($_SESSION as $request)
		{
			foreach($this->regole as $regex)
			{
				if (preg_match("{$regex}", (string) $request))
				{
					$this->logga($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], "session");
					$this->blocca($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR']);
				}
			}
		}		
	}
	
	public function check_CSRF($http_referer) {
                $post = join($_REQUEST);
                if($post != "" && $http_referer != "") {
                        if(preg_match("/www\./i",$_SERVER['HTTP_HOST'])) {
                                $exp  = explode("www.",$_SERVER['HTTP_HOST']);
                                $host = $exp[1];
                        }else{
                        	$host = $_SERVER['HTTP_HOST'];
                        }
                        
                        if(!preg_match('/(http|https):\/\/(www\.)?'.$host.'/i',$_SERVER['HTTP_REFERER']) 
                        && !preg_match('/(http|https):\/\/'.$_SERVER['SERVER_ADDR'].'/i',$_SERVER['HTTP_REFERER'])) 
                        {
                        	$this->logga($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], "csrf");
							$this->blocca($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR']);  
                        }
                }
        }
	
	public function check_useragent() {
		//Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; .NET CLR 1.1.4322) UA di acunetix 5.0 e 6.0
		if(preg_match('/(acunetix|scanner|\.NET CLR 1\.1\.4322|WVS|PTX|Nikto)/i',$_SERVER['HTTP_USER_AGENT'])) {
			$regola = "scanner";
			$this->logga($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $regola);
			exit(0);
		}
			
		if(preg_match('/libwww-perl/i',$_SERVER['HTTP_USER_AGENT'])) {
			$regola = "perl";
			$this->logga($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], @$_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $regola);	
			exit(0);
		}
	}
	
	public function check_ban_ip($ip) {
		global $db_host, $db_user, $db_pass, $db_name;
	
		$this->Open($db_host, $db_user, $db_pass, $db_name);
		
		$ip_banned = $this->Query("SELECT * FROM 0xSentinel_ban_ip");
		
		$block = "<html>"
				. "\n<head>"
				. "\n<link rel='StyleSheet' type='text/css'>"
				. "\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />"
				. "\n<title>!!! 0xSentinel Ban IP System Activated !!!</title>"
				. "\n<style type=\"text/css\">"
				. "\na:visited, a:link, a:active {"
				. "\n\ttext-decoration: none;"
				. "\n\tcolor: #5588aa;"
				. "\n}"
				. "\na:hover {"
				. "\n\tcolor: #ff6000;"
				. "\n\ttext-decoration: underline;"
				. "\n}"
				. "\nbody {"
				. "\n\tbackground: #000000;"
				. "\n\tfont-size: 11px;"
				. "\n\tcolor: #FFFFFF;"
				. "\n\tmargin: 0px;"
				. "\n\tpadding: 20px;"
				. "\n\ttext-align: left;"
				. "\n\tfont-family: monospace;"
				. "\n}"
				. "\n</style>"
				. "\n</head>"
				. "\n<body>"
				. "\n<br/><br/>"
				. "\n<table width=\"80%\" border=\"0\" align=\"center\">"
				. "\n<tr>"
				. "\n<td valign=\"top\"><div align=\"center\"><font color=\"#FF0000\">!!! 0xSentinel Ban IP System Activated !!!</font><br /><img src=\"/0xSentinel/images/logo.png\"></div>"
				. "\n<p>"
				. "	\n<br/>"
				. "	\nIl tuo IP ".$ip." è stato Bannato da questo sito! <br />"
				. "\nSe credi che tu non abbia effettuato attacchi al sito puoi mandare una email all'amministratore del sito in questione.<br />"
				. "\n</p> "
				. "\n</td>"
				. "\n</tr>"
				. "\n<tr> "
				. "\n<td height=\"38\" align='right'><em><a href=\"http://0xproject.netsons.org/#0xSentinel\">0xSentinel</a> By <a href=\"http://www.kinginfet.net/\">KinG-InFeT</a></em></td>"
				. "\n</tr>"
				. "\n</table>"
				. "\n</body>"
				. "\n</html>";
							
		while ($row = mysql_fetch_array ($ip_banned)) 
		{
			if($row['ip'] == $ip) 
			{
				die($block);
			}
		}//end while :P
	}
}
?>
