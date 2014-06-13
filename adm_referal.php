<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if ( empty($_SESSION['login']) )  die( include('includes/bag_log_in.php') );


include('db.php');
include('includes/to_view.php');
include('includes/adm/some_funcs.php');

header('Content-type: text/html; charset=windows-1251');

$user = mysql_escape_string( speek_to_view($_SESSION['login']) );
$id   = intval($_GET['id']);

$ClanID = @$db->SQL_result($db->query("SELECT ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$user."' LIMIT 1;"),0);

if( $ClanID != 255 ) die(_adminerr);

$zayavka = $db->queryRow( "
SELECT ref.status, ref2.refer_id, p.Id as referal_id, p.Username as referal_uname, p.Level as referal_lvl, p.ClanID as referal_clanid, p2.Username as refer_uname, p2.Level as refer_lvl, p2.ClanID as refer_clanid FROM
".SQL_PREFIX."referal as ref INNER JOIN ".SQL_PREFIX."players as p ON (p.Username = ref.login),
".SQL_PREFIX."referal as ref2 INNER JOIN ".SQL_PREFIX."players as p2 ON (p2.Id = ref2.refer_id)
WHERE ref2.un = '".$id."' AND ref.un = '".$id."'
" );


if( !$zayavka ) die( 'не существует' );

////////////1///////////////////
if( !empty($_GET['page1']) && is_numeric($_GET['page1']) )
{
@$p = intval($_GET['page1']);

$refer_num = $db->numrows( "SELECT ip FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['refer_id']."';" );

$num   = 10;
$total = @ceil($refer_num/$num);

if(empty($p) || $p < 0)
    $p = 1;
if($p > $total)
    $p = $total;

$start = max( 0, ($p * $num - $num) );


$refer_enters = $db->queryArray( "SELECT INET_NTOA(ip) as ip, add_time FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['refer_id']."' ORDER BY add_time DESC LIMIT ".$start.", ".$num );

$pages = array();
$s     = 0;
$out1   = '';

for($i = 1; $i <= $total; $i++)
   if( ($i <= 2  || ($i >= $p-2 && $i <= $p+2)  ||  $i > $total-2 ) && !in_array($i, $pages))
     $pages[] = $i;


$p > 1 ? $out1 .= ' <a href="javascript:page1('.($p-1).')">предыдущая</a> ' : $out1 .= '';

for($i = 0; $i < count($pages); $i++)
{
	$s++;
	$pages[$i] != $s ? $out1 .= ' ... ' : $out1 .= '';
	$pages[$i] == $p ? $out1 .= ' <span>'.$pages[$i].'</span> ' : $out1 .= ' <a href="javascript:page1('.$pages[$i].')">'.$pages[$i].'</a> ';
	$s = $pages[$i];
}

$p < $total && $total > 1 ? $out1 .= ' <a href="javascript:page1('.($p+1).')">следующая</a> ' : $out1 .= '';
?>
<table width="50%" height="*" border="1" style="color:green;" cellspacing="5" cellpadding="5" align="left">
<? $i = 1;
   if( !empty($refer_enters) ):
?>
 <tr>
  <td>Username <?=slogin($zayavka['refer_uname'], $zayavka['refer_lvl'], $zayavka['refer_clanid']);?></td>
  <td>time</td>
  <td>ip</td>
 </tr>
<?
   foreach( $refer_enters as $row ):
?>
 <tr>
  <td>#<?=$i;?></td>
  <td><?=date('j', $row['add_time']).' '.getmonth(date('F', $row['add_time'])).', '.date('Y', $row['add_time']).' г.';?></td>
  <td><?=$row['ip'];?></td>
 </tr>
<? $i++;
   endforeach;
?>
 <tr>
  <td>Страницы: <?=$out1;?></td>
 </tr>
<?
   else:
?>
 <tr>
  <td>Логи персонажа <?=slogin($zayavka['refer_uname'], $zayavka['refer_lvl'], $zayavka['refer_clanid']);?> не найдены.</td>
 </tr>
<? endif; ?>
</table>
<?
die;

}
////////////end//////////////////



////////////1///////////////////

if( !empty($_GET['page2']) && is_numeric($_GET['page2']) )
{
@$p = intval($_GET['page2']);

$referal_num = $db->numrows( "SELECT ip FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['referal_id']."';" );

$num   = 10;
$total = @ceil($referal_num/$num);

if(empty($p) || $p < 0)
    $p = 1;
if($p > $total)
    $p = $total;

$start = max( 0, ($p * $num - $num) );


$referal_enters = $db->queryArray( "SELECT INET_NTOA(ip) as ip, add_time FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['referal_id']."' ORDER BY add_time DESC LIMIT ".$start.", ".$num );

$pages = array();
$s     = 0;
$out2   = '';

for($i = 1; $i <= $total; $i++)
   if( ($i <= 2  || ($i >= $p-2 && $i <= $p+2)  ||  $i > $total-2 ) && !in_array($i, $pages))
     $pages[] = $i;


$p > 1 ? $out2 .= ' <a href="javascript:page2('.($p-1).')">предыдущая</a> ' : $out2 .= '';

for($i = 0; $i < count($pages); $i++)
{
	$s++;
	$pages[$i] != $s ? $out2 .= ' ... ' : $out2 .= '';
	$pages[$i] == $p ? $out2 .= ' <span>'.$pages[$i].'</span> ' : $out2 .= ' <a href="javascript:page2('.$pages[$i].')">'.$pages[$i].'</a> ';
	$s = $pages[$i];
}

$p < $total && $total > 1 ? $out2 .= ' <a href="javascript:page2('.($p+1).')">следующая</a> ' : $out2 .= '';


?>
<table width="50%" height="*" border="1" style="color:red;" cellspacing="5" cellpadding="5">
<? $i = 1;
   if( !empty($referal_enters) ):
?>
 <tr>
  <td>Username <?=slogin($zayavka['referal_uname'], $zayavka['referal_lvl'], $zayavka['referal_clanid']);?></td>
  <td>time</td>
  <td>ip</td>
 </tr>
<?
   foreach( $referal_enters as $row ):
?>
 <tr>
  <td>#<?=$i;?></td>
  <td><?=date('j', $row['add_time']).' '.getmonth(date('F', $row['add_time'])).', '.date('Y', $row['add_time']).' г.';?></td>
  <td><?=$row['ip'];?></td>
 </tr>
<? $i++;
   endforeach;
?>
 <tr>
  <td>Страницы: <?=$out2;?></td>
 </tr>
<?
   else:
?>
 <tr>
  <td>Логи персонажа <?=slogin($zayavka['referal_uname'], $zayavka['referal_lvl'], $zayavka['referal_clanid']);?> не найдены.</td>
 </tr>
<? endif; ?>
</table>
<?
die;
}
////////////end//////////////////


//$referal_enters       = $db->queryArray( "SELECT INET_NTOA(ent.ip), p.Username, p.Level, p.ClanID FROM ".SQL_PREFIX."enter_logs as ent INNER JOIN ".SQL_PREFIX."players as p ON(p.Id = ent.user_id) WHERE ent.user_id = '".$zayavka['referal_id']."';");



$refer_enters_query   = $db->queryArray( "SELECT ip FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['refer_id']."' GROUP BY ip" );
$referal_enters_query = $db->queryArray( "SELECT ip FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['referal_id']."' GROUP BY ip" );

$refer_enters_cnt   = 0;
$referal_enters_cnt = 0;


if( !empty($refer_enters_query) )
{
	foreach($refer_enters_query as $row_ip)
	{
		$referal_enters_cnt += @$db->SQL_result($db->query( "SELECT COUNT(ip) FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['referal_id']."' AND ip = '".$row_ip['ip']."' GROUP BY ip" ) ).'<br />';
	}
}


if( !empty($referal_enters_query) )
{
	foreach($referal_enters_query as $row_ip)
	{
		$refer_enters_cnt += @$db->SQL_result($db->query( "SELECT COUNT(ip) FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['refer_id']."' AND ip = '".$row_ip['ip']."' GROUP BY ip" ) );
	}
}
//echo $refer_enters_cnt.'<br />'.$referal_enters_cnt;
$all_enters = 0;
$all_enters += @$db->SQL_result($db->query( "SELECT COUNT(ip) FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['refer_id']."' GROUP BY ip" ) ) + @$db->SQL_result($db->query( "SELECT COUNT(ip) FROM ".SQL_PREFIX."enter_logs WHERE user_id = '".$zayavka['referal_id']."' GROUP BY ip" ) );

//$refer_enters_cnt   = empty($refer_enters_cnt) ? 0 : $refer_enters_cnt;
//$referal_enters_cnt = empty($referal_enters_cnt) ? 0 : $referal_enters_cnt;


$sovpadenia = ($all_enters != 0) ? round(($refer_enters_cnt+$referal_enters_cnt)/$all_enters * 100) : 0;



include('_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'id', $id );
$temp->assign( 'sovpadenia', $sovpadenia );
$temp->assign( 'status', $zayavka['status'] );
$temp->assign( 'referal', slogin($zayavka['referal_uname'], $zayavka['referal_lvl'], $zayavka['referal_clanid']) );
$temp->assign( 'refer', slogin($zayavka['refer_uname'], $zayavka['refer_lvl'], $zayavka['refer_clanid']) );
$temp->assign( 'refer_enters_cnt', $refer_enters_cnt );
$temp->assign( 'referal_enters_cnt', $referal_enters_cnt );
//$temp->assign( 'refer_enters', $refer_enters );
//$temp->assign( 'referal_enters', $referal_enters );

$temp->addTemplate('adm_referal', 'timeofwars_func_adm_referal.html');

$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - штукенция #id'.$id);
$show->assign('Content', $temp);

$show->addTemplate( 'header', 'header_noframes.html' );
$show->addTemplate( 'index' , 'index.html'           );
$show->addTemplate( 'footer', 'footer.html'          );

$tow_tpl->display();
?>
