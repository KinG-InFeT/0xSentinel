<?php
/**
 * File: index.php
 * 
 * Home Page del CMS
 *
 * @author KinG-InFeT <info@kinginfet.net>
 * @copyright GPL
 */

session_start();
include("config.php");
include("lib/layout.class.php");
$layout = new layout();

$layout->header();

if(isSet($_SESSION['0xSentinel']['admin']))
	$layout->admin_menu();
else
	$layout->menu();
	
switch(@$_GET['act']) {

	case 'banner':
		print "\n<div align=\"center\">"
		    . "\n<img src=\"/0xSentinel/banner.php\" />"
		    . "\n<br /><br />"
		    . "\n<p>Per aggiungere il banner dinamico al vostro portale, basta copiare ed incollare il seguente codice HTML:</p>"
		    . "\n<br />"
		    . "\n<textarea cols=\"50\" rows=\"6\">"
		    . "\n<a href=\"/0xSentinel/about.php\" target=\"_blank\"><img border=\"0\" src=\"/0xSentinel/banner.php\" alt=\"0xSentinel Dinamic Banner\" title=\"0xSentinel Dinamic Banner\"></a>"
		    . "\n</textarea>"
		    . "\n</div>";
	break;
	
	default:

		print "\n<br /><br />"
			. "\n0xSentinel nella sua release attuale è in grado di protegge una qualsiasi applicazione in PHP dai seguenti tipi di attacchi:<br />"
			. "\n<br />"
        	. "<li>Scanning/crawling di software come Acunetix o simili</li>\n"
        	. "<li>Blind SQL Injection</li>\n"
        	. "<li>SQL Injection</li>\n"
        	. "<li>RFI (Remote File Inclusion)</li>\n"
        	. "<li>LFI (Local File Inclusion)</li>\n"
        	. "<li>Log Poisoning</li>\n"
        	. "<li>RCE (Remote Code Execution)</li>\n"
        	. "<li>Directory Traversal</li>\n"
      		. "<li>Full Path Disclosure</li>\n"
        	. "<li>XSS (Cross Site Scripting)</li>\n"
           	. "<li>CSRF (Cross Site Request Forgery)</li>\n"
        	. "<li>Blocco Script in PERL (Exploit)</li>\n"
			. "<br /><br />\n";
			
		if (file_exists('./install.php'))
			print "<a href='install.php'><u><b><font color=\"red\">0xSentinel non è ancora installato, installalo ora!.</font></b></u></a>\n";
			
	break;
}

$layout->footer();
?>
