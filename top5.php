<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once ('db_config.php');
include_once ('db.php');


$iconWeb = 'http://'.$db_config[DREAM_IMAGES]['server'].'/clan';
@$_GET['show'] = intval($_GET['show']);



$listAstrals = $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getAstrals_1' );
$listClans   = $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getClans_1' );

$list = array_merge($listAstrals, $listClans);


require_once('_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );
$tow_tpl->assignGlobal( 'db',        $db        );

$temp = & $tow_tpl->getDisplay('content', true);


if(!empty($_GET['show'])){

$query = sprintf("SELECT title FROM ".SQL_PREFIX."clan WHERE id_clan = '%d'", $_GET['show']);
$clanInfo = $db->queryRow( $query, 'top5_clanGetinfo_1' );

if($clanInfo) {
 $clanUserList = $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getClanList_'.$_GET['show'] );

$temp->assign('clanInfo',     $clanInfo    );
$temp->assign('clanUserList', $clanUserList);
}

}


$temp->assign( 'list', $list );
$temp->assign( 'toplist', $db->readCache($db_config[DREAM]['web_root'].'/cache/top5/top5_toplist_'.date('Ymd'))  );
$temp->assign('iconWeb',      $iconWeb     );

$temp->addTemplate('top', 'timeofwars_top.html');

$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - топ лучших кланов');
$show->assign('Content', $temp);


$show->addTemplate( 'header', 'header_noframes.html' );
$show->addTemplate( 'index' , 'index.html'           );
$show->addTemplate( 'footer', 'footer.html'          );


$tow_tpl->display();
?>
