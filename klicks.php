<?php
//-> counter output
function klicks()
{
	//$sql_prefix hinzufügen
  global $sql_prefix;

  

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

    return '<table class="navContent" cellspacing="0">Aufrufe Teilseite: '.$clicksnumber.'</table>';
  }

?>
