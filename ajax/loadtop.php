<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

header('Content-type: text/html; charset=windows-1251');

include_once ('../db_config.php');
include_once ('../db.php');

if( !empty($_POST['act']) && $_POST['act'] == 'loadbydate' && !empty($_POST['date']) )
{	$date = intval( str_replace( '-', '', $_POST['date'] ) );
	$toplist = $db->readCache($db_config[DREAM]['web_root'].'/cache/top5/top5_toplist_'.$date);
?>
       <?if( !empty($toplist) ): ?>
       <? foreach( $toplist as $k => $v ): ?>
        <tr>
         <td><?=($k+1);?>. <a href="http://<?=$db_config[DREAM]['server'];?>/top5.php?show=<?=$v['id_clan'];?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/clan/<?=$v['id_clan'];?>.gif" /> <?=$v['title'];?> </a> заработали <strong><?=round($v['sumdmg']/2);?></strong> опыта. </td>
        </tr>
       <? endforeach; ?>
       <? else: ?>
        <tr><td>Топ за этот день не сформирован.</td></tr>
       <? endif;?>
<?
}


?>