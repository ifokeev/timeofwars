<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once ('db_config.php');

include_once ('db.php');



function slogin( $user, $lvl, $clanid )
{   global $db_config;
    $r = '';
	if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';
    else $r .= '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/1pix.gif" width="24" height="15" alt="" border="0">';


	$r .= '<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$user.'" target="_blank">'.$user.'</a> ['.$lvl.']';
	$r .= '<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$user.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$user.'" /></a>';

	return $r;
}


require_once('_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );
$tow_tpl->assignGlobal( 'db',        $db        );

$temp = & $tow_tpl->getDisplay('content', true);



$temp->assign('WLD',          $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostDiff_1' )     );
$temp->assign('WLS',          $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostSum_1' )      );
$temp->assign('WLP',          $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostPerc_1' )     );
$temp->assign('stSUM',        $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top_get_stSUM_1' )           );
$temp->assign('karmaPlus',    $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getKarmaPlus_1' )       );
$temp->assign('karmaMinus',   $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getKarmaMinus_1' )      );
$temp->assign('smith',        $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top_get_smithlevel' )        );
$temp->assign('mines',        $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_get_mineslevel' )       );
$temp->assign('casino',       $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_get_casino' )           );
$temp->assign('refer',       $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_get_refer' )           );
//$temp->assign('vetki',        $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_get_best_vetki' )       );
//$temp->assign('toys',         $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_get_best_toys' )        );
//$temp->assign('presents',     $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_get_best_presents' )    );

$temp->addTemplate('top', 'timeofwars_top_users.html');

$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - топ лучших игроков');
$show->assign('Content', $temp);


$show->addTemplate( 'header', 'header_noframes.html' );
$show->addTemplate( 'index' , 'index.html'           );
$show->addTemplate( 'footer', 'footer.html'          );


$tow_tpl->display();
?>
