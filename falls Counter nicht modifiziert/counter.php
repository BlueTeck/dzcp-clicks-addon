<?php
//-> counter output
function counter()
{
	//$sql_prefix hinzufügen
  global $db,$today,$counter_start,$useronline,$where,$isSpider,$sql_prefix;

  if(!$isSpider)
  {
    $qry2day = db("SELECT visitors FROM ".$db['counter']."
                   WHERE today = '".$today."'");
    if(_rows($qry2day))
    {
      $get2day = _fetch($qry2day);
      $v_today = $get2day['visitors'];
    } else {
      $v_today = 0;
    }

    $gestern = time() - 86400;

    $tag   = date("j", $gestern);
    $monat = date("n", $gestern);
    $jahr  = date("Y", $gestern);
    $yesterday = $tag.".".$monat.".".$jahr;

    $qryyday = db("SELECT visitors FROM ".$db['counter']."
                   WHERE today = '".$yesterday."'");

    if(_rows($qryyday))
    {
      $getyday = _fetch($qryyday);
      $yDay = $getyday['visitors'];
    } else $yDay = 0;

    $qrystats = db("SELECT SUM(visitors) AS allvisitors,
                           MAX(visitors) AS maxvisitors,
                           MAX(maxonline) AS maxonline,
                           AVG(visitors) AS avgvisitors,
                           SUM(visitors) AS allvisitors
                    FROM ".$db['counter']."");
    $getstats = _fetch($qrystats);


    if(abs(online_reg()) != 0)
    {
      $qryo = db("SELECT id FROM ".$db['users']."
                  WHERE time+'".$useronline."'>'".time()."'
                  AND online = 1
                  ORDER BY nick");
      while($geto = _fetch($qryo))
      {
        $ousers .= '<tr><td>'.rawautor($geto['id']).'</td><td align=right valign=middle><small>'.jsconvert(getrank($geto['id'])).'</small></td></tr>';
      }

      $info = 'onmouseover="DZCP.showInfo(\'<tr><td colspan=2 align=center padding=3 class=infoTop>'._online_head.'</td></tr><tr><td><table width=100% cellpadding=0 cellspacing=0>'.$ousers.'</table></td></tr>\')" onmouseout="DZCP.hideInfo()"';
    }

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

    $counter = show("menu/counter", array("v_today" => $v_today,
										//Klicks MOD Start
										  "aufrufe" => $clicksnumber,
										  //Klicks MOD Ende
                                          "v_yesterday" => $yDay,
                                          "v_all" => $getstats['allvisitors']+$counter_start,
                                          "v_perday" => round($getstats['avgvisitors'], 2),
                                          "v_max" => $getstats['maxvisitors'],
                                          "g_online" => abs(online_guests($where)-online_reg()),
                                          "u_online" => abs(online_reg()),
                                          "info" => $info,
                                          "v_online" => $getstats['maxonline'],
                                          "head_online" => _head_online,
                                          "head_visits" => _head_visits,
                                          "head_max" => _head_max,
                                          "user" => _cnt_user,
                                          "guests" => _cnt_guests,
                                          "today" => _cnt_today,
                                          "yesterday" => _cnt_yesterday,
                                          "all" => _cnt_all,
                                          "percentperday" => _cnt_pperday,
                                          "perday" => _cnt_perday,
                                          "online" => _cnt_online));

    return '<table class="navContent" cellspacing="0">'.$counter.'</table>';
  }
}
?>
