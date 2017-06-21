# Klicks Mod - ReadMe
   
   Durch diesen Mod ist es m&ouml;glcih zu sehen, wie oft eine Teilseite aufgerufen worden ist.
   Zum Beispiel wie oft wurde diese News ge&ouml;ffnet oder wie oft hat sich jemand die Userliste angekuckt.
   Diese Statistik funktioniert für alle Seiten/Teilseite, nur die Adminseiten werden ausgeschlossen, da ich dies für unwichtig hielt.

# Haftungsausschluss

  Ich übernehmen keinerlei Verantwortung, für Schäden die durch das einbinden der Mod/des Addons entstehen. Das einbinden und
  nutzen erfolgt demnach auf eigene Gefahr.
  Vor den einbinden der Mod/des Addons sollte eine Datenbanksicherung durchgeführt werden. Des Weiteren empfehle ich,
  von allen Dateien welche geändert werden müssen (unter „Benötigte Dateien“ aufgelistet), ebenfalls eine Sicherheitskopie anzufertigen.

# Benötigte Dateien

Folgende Datei werden f&uuml;r diese Mod/dieses Addon ben&ouml;tigt:<br>

- _install_klicks/install.php
- inc/menu-functions/counter.php
- inc/_templates_/TEMPLATE/menu/counter.html
- inc/additional-functions/klicks.php
- inc/_templates_/TEMPLATE/index.html

# Installation

Es gibt zwei Varianten dieses Mods/Addons. In Variante 1 wird der Klickcounter in den Standart DZCP-Counter eingebaut. 
In Variante 2 kann der Klick-Counter an eine beliebige Stelle eures Templates eingebunden werden.
         
Damit es zu keinen Fehler kommt, müssen zuerst die Tabellen in der Datenbank angelegt werden. Hierfür haben wir einen kleinen
Installer geschrieben, welcher am Ordnernamen _install_XXXXXXX zu erkennen ist. Ladet diesen Ordner in das Hauptverzeichnis eures deV!L'z Clanportals.

Ruft anschliesend eure Seite auf und fügt hinter die Adresse folgendes ein:

/_install_klicks/install.php

Wenn die Installation erfolgreich verlief löscht zur Sicherheit den installer-Ordner von euren Webspace.

Ändert nun folgende Dateien entsprechend den Anweisungen ab:
        
## Variante 1
   
### inc/menu-functions/counter.php

Sucht nach folgenden Zeilen:
```php
global $db,
```
Fügt direkt hinter dieser Zeile folgendes ein:
```php
$sql_prefix,
```
Sucht nun nach folgender Zeile:
```php
$counter = show("menu/counter", array(
```
Fügt direkt darüber folgendes ein:
```php
//Klicks Mod
if(strpos($_SERVER['PHP_SELF'],"/admin/")!==false) {
	$clicksnumber = "-";
	} else {
if($_SERVER['QUERY_STRING']!="") {$whereclicks = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];} else {$whereclicks = $_SERVER['PHP_SELF'];}
$clicksrownumber = mysql_num_rows(db("SELECT klicks FROM ".$sql_prefix."klicks WHERE wo = '".$whereclicks."'"));
if($clicksrownumber == 0) {
	$qry = db("INSERT INTO ".$sql_prefix."klicks 
                       SET `wo`  = '".$whereclicks."',
                           `klicks`  = '1'");
		$clicksnumber = 1;				   
	} else {
		$clicksnumber = mysql_fetch_array(db("SELECT klicks FROM ".$sql_prefix."klicks WHERE wo = '".$whereclicks."'"));
		$clicksnumber = $clicksnumber[0] +1;
		$qry = db("UPDATE ".$sql_prefix."klicks SET klicks = '".$clicksnumber."' WHERE wo LIKE '".$whereclicks."'");
		}
}
//Klicks Mod Ende
```
Sucht nun nach folgender Zeile:
```php
$counter = show("menu/counter", array(
```
Fügt direkt dahinter, folgendes ein:
```php
"aufrufe" => $clicksnumber,
```

### inc/_templates_/TEMPLATE/menu/counter.html

Sucht nun nach folgender Zeile:
```html
<td class="counterContentRight">[v_perday]</td><br>
</tr>
```
Fügt direkt dahinter, folgendes ein:
```html
<tr><br>
<td class="counterSpace"></td><br>
</tr><br>
<tr><br>
<td colspan="2" class="counterContentHead"><span class="fontBoldUnder">Aufrufe Teilseite:</span></td><br>
</tr><br>
<tr><br>
<td class="counterContentLeft"><span class="fontBold">Insgesamt:</span></td><br>
<td class="counterContentRight">[aufrufe]</td><br>
</tr>
```

## Variante 2

Hierzu müsst ihr die Datei klicks.php nach /inc/menu-functions/klicks.php hochladen.
Anschließend müsst ihr den Platzhalter [klicks] in eure Templatedatei einbauen (inc/_templates_/TEMPLATE/index.html)
