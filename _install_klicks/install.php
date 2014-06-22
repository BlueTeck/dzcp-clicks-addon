<?php
## OUTPUT BUFFER START ##
include("../inc/buffer.php");
## INCLUDES ##
include(basePath."/inc/config.php");
include(basePath."/inc/bbcode.php");
## SETTINGS ##
$time_start = generatetime();
lang($language);
$where = "Installer";
$title = $pagetitle." - ".$where."";
## INSTALLER ##

if(isset($_POST['submit'])) {  

  $qry = db("CREATE TABLE ".$sql_prefix."klicks (`wo` varchar(64) NOT NULL,
													`klicks` int(32) NOT NULL,
													PRIMARY KEY  (`wo`))");
						
 								 
					
	 $qry = db("SELECT * FROM ".$sql_prefix."klicks");					
		if(_rows($qry) == '0') {
				$show = '<tr>
															<td class="contentHead"><span class="fontGreen"><b>Installation erfolgreich!</b></span></td>
													</tr>
													<tr>
															<td class="contentMainFirst"  align="center">
																	Die ben&ouml;tigten Tabellen konnten erfolgreich erstellt werden.<br>
																	<br>
																	<b>L&ouml;sche unbedingt den installer-Ordner!</b>
															</td>
													</tr>
													<tr>
															<td class="contentBottom"></td>
													</tr>';
		} else {
				$show = '<tr>
															<td class="contentHead"><span class="fontWichtig"><b>FEHLER</b></span></td>
													</tr>
													<tr>
															<td class="contentMainFirst" align="center">
																	Bei der Installation des AddOns ist ein Fehler aufgetreten. Bitte &uuml;berpr&uuml;fe deine Datenbank auf Sch&auml;den und versuche die Installation erneut.
															</td>
													</tr>
													<tr>
															<td class="contentBottom"></td>
													</tr>';
		}
} else {
		$show = '<tr>
													<td class="contentHead"><b>Klick Counter - Installation</b></td>
											</tr>
											<tr>
													<td class="contentMainFirst" align="center">
															Hallo und herzlichen Dank, dass du dieses Addon für das deV!L’z Clanportal heruntergeladen hast. Dieser Installer legt die benötigten Tabellen in der Datenbank an.<br>
															<br>
															<b>Erstell vor dem ausf&uuml;hren des Installers ein Datenbank BackUp. Wir haften f&uuml;r keine Sch&auml;den!</b><br>
															<br>
													</td>
											</tr>
											<tr>
													<td class="contentBottom" align="center">
															<form action="install.php" method="POST">
																	<input class="submit" type="submit" name="submit" value="Tabellen anlegen">
															</form>
													</td>
											</tr>';
}
## SETTINGS ##
$time_end = generatetime();
$time = round($time_end - $time_start,4);
page($show, $title, $where,$time);
?>
