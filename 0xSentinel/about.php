<?php
/*
 *
 * @project 0xSentinel
 * @author KinG-InFeT
 * @licence GNU/GPL
 *
 * @file about.php
 *
 * @link http://0xproject.netsons.org#0xSentinel
 *
 */

include("config.php");
include_once("lib/layout.class.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel='StyleSheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>0xSentinel - v<?php echo VERSION; ?> About</title>
<style type="text/css">
</style>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body><br /><br />
<table width="513" border="0" align="center">
  <tr>
    <td width="2" rowspan="3">&nbsp;</td>
    <td width="493"></td>
    <td width="10" rowspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><div>About 0xSentinel - v<?php echo VERSION; ?></div>
      <p><br />
      0xSentinel è un sistema di sicurezza universale per applicazioni web in PHP .<br />
	  Il software è un vero CMS con la quale è possibile scegliere cosa fare dei dati di ingresso del sito bloccandoli, 
	  notificandoli e loggandoli tramite l'apposito sistema progettato e brevettato per il Web Hacking e gli attacchi degli Hackers
	  sulle nostre piattaforme.
<?php
echo "<br /><br />\n"
	."0xSentinel nella sua release attuale è in grado di protegge una qualsiasi applicazione in PHP dai seguenti tipi di attacchi:<br />\n"
	."<br />\n"
	."<li>Scanning/crawling di software come Acunetix o simili</li>\n"
	."<li>Blind SQL Injection</li>\n"
	."<li>SQL Injection</li>\n"
	."<li>RFI (Remote File Inclusion)</li>\n"
	."<li>LFI (Local File Inclusion)</li>\n"
	."<li>Log Poisoning</li>\n"
	."<li>RCE (Remote Code Execution)</li>\n"
	."<li>Directory Traversal</li>\n"
	."<li>Full Path Disclosure</li>\n"
	."<li>XSS (Cross Site Scripting)</li>\n"
	."<li>CSRF (Cross Site Request Forgery)</li>\n"
	."<li>Blocco Script in PERL (Exploit)</li>\n"
	."<br /><br />\n";
?>
    </tr>
  <tr>
    <td height="38" align='right'><em><a href='http://0xproject.netsons.org/#0xSentinel'>0xSentinel</a> - Copyleft 2010 By <a href="http://www.kinginfet.net/">KinG-InFeT</a></em></td>
  </tr>
</table>
</body>
</html>
