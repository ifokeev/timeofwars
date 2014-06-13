<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('temple');

if(!empty($_GET['goto']) && ($_GET['goto'] == 'pl' || $_GET['goto'] == 'wedding')){
$player->gotoRoom( $_GET['goto'], $_GET['goto'] );
}

$player->heal();
$err = '';

$e = @$db->SQL_result($db->query("SELECT Euro FROM `".SQL_PREFIX."bank_acc` WHERE Username = '$player->username'"),0);
if(empty($e)){ $e = '0.00';   }

if((!empty($_GET['osv']) && $_GET['osv'] == 1) && !empty($_GET['item'])){
if( !$v = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE (Un_Id = '".intval($_GET['item'])."') AND (Thing_Name not like '%(made by%') AND (Thing_Name not like '%ability%') AND (Owner = '{$player->username}') AND (Wear_ON = '0')") ) {
$err = _TEMPLE_err1;
} else {
if ( preg_match('/Кольцо Благородия|клановая|именная|Освящено|made|ability/i', $v['Thing_Name'])  ) {
$err = _TEMPLE_err2;
} else {
if($v['Cost'] >= 20){
if($player->Money >= sprintf('%01.0f', ($v['Cost']*0.65))){
$a = '';
if($v['Crit'] > 0){ $a .= ', Crit = \''.sprintf ('%01.0f', ($v['Crit']+$v['Crit']*0.2)).'\' '; }
if($v['AntiCrit'] > 0){ $a .= ', AntiCrit = \''.sprintf ('%01.0f', ($v['AntiCrit']+$v['AntiCrit']*0.2)).'\''; }
if($v['Uv'] > 0){ $a .= ', Uv = \''.sprintf ('%01.0f', ($v['Uv']+$v['Uv']*0.2)).'\''; }
if($v['AntiUv'] > 0){ $a .= ', AntiUv = \''.(sprintf ('%01.0f', $v['AntiUv']+$v['AntiUv']*0.2)).'\''; }

if($v['Crit'] < 0){ $a .= ', Crit = \''.sprintf ('%01.0f', ($v['Crit']-$v['Crit']*0.2)).'\' '; }
if($v['AntiCrit'] < 0){ $a .= ', AntiCrit = \''.sprintf ('%01.0f', ($v['AntiCrit']-$v['AntiCrit']*0.2)).'\''; }
if($v['Uv'] < 0){ $a .= ', Uv = \''.sprintf ('%01.0f', ($v['Uv']-$v['Uv']*0.2)).'\' '; }
if($v['AntiUv'] < 0){ $a .= ', AntiUv = \''.(sprintf ('%01.0f', $v['AntiUv']-$v['AntiUv']*0.2)).'\' '; }

if($v['MINdamage'] > 0){ $a .= ', MINdamage = \''.sprintf ('%01.0f', ($v['MINdamage']+$v['MINdamage']*0.2)).'\' '; }
if($v['MAXdamage'] > 0){ $a .= ', MAXdamage = \''.sprintf ('%01.0f', ($v['MAXdamage']+$v['MAXdamage']*0.2)).'\' '; }
if($v['Armor1'] > 0){ $a .= ', Armor1 = \''.sprintf ('%01.0f', ($v['Armor1']+$v['Armor1']*0.2)) .'\' '; }
if($v['Armor2'] > 0){ $a .= ', Armor2 = \''.sprintf ('%01.0f', ($v['Armor2']+$v['Armor2']*0.2)).'\' '; }
if($v['Armor3'] > 0){ $a .= ', Armor3 = \''.sprintf ('%01.0f', ($v['Armor3']+$v['Armor3']*0.2)).'\' '; }
if($v['Armor4'] > 0){ $a .= ', Armor4 = \''.sprintf ('%01.0f', ($v['Armor4']+$v['Armor4']*0.2)).'\' '; }

if( $v['Endu_add'] > 0 ){  $a .= ', Endu_add = \''.sprintf ('%01.0f', ($v['Endu_add']+$v['Endu_add']*0.2)).'\' '; }

$db->execQuery("UPDATE ".SQL_PREFIX."things SET Thing_Name = concat('[Освящено] ', Thing_Name), Cost = Cost + '".sprintf('%01.0f', ($v['Cost']*0.65))."' $a WHERE Un_Id = '".intval($_GET["item"])."' AND Owner = '{$player->username}' LIMIT 1 ");
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Money = Money - '".sprintf('%01.0f', ($v['Cost']*0.65))."' WHERE Username = '{$player->username}' LIMIT 1");

$err = _TEMPLE_err3;
$player->Money -= (sprintf('%01.0f', ($v['Cost']*0.65)));

} else { $err = _TEMPLE_err4; }

} else { $err = _TEMPLE_err5_1; }

}
}
$_GET['osv'] = 1;
}



if((!empty($_GET['osv']) && $_GET['osv'] == 2) && !empty($_GET['item'])){
if( !$v = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE (Un_Id = '".intval($_GET['item'])."') AND (Owner = '{$player->username}') AND (Wear_ON = '0')") ) {
$err = _TEMPLE_err1;
} else {
if ( preg_match('/Кольцо Благородия|клановая|именная|Освящено|Освящено элитно|made|ability/i', $v['Thing_Name'])  ) {
$err = _TEMPLE_err2;
} else {
if($v['Cost'] > 0){
if($e >= sprintf('%01.0f', ($v['Cost']*0.55))){
$a = '';
if($v['Crit'] > 0){ $a .= ', Crit = \''.sprintf ('%01.0f', ($v['Crit']+$v['Crit']*0.5)).'\' '; }
if($v['AntiCrit'] > 0){ $a .= ', AntiCrit = \''.sprintf ('%01.0f', ($v['AntiCrit']+$v['AntiCrit']*0.5)).'\''; }
if($v['Uv'] > 0){ $a .= ', Uv = \''.sprintf ('%01.0f', ($v['Uv']+$v['Uv']*0.5)).'\''; }
if($v['AntiUv'] > 0){ $a .= ', AntiUv = \''.(sprintf ('%01.0f', $v['AntiUv']+$v['AntiUv']*0.5)).'\''; }

if($v['Crit'] < 0){ $a .= ', Crit = \''.sprintf ('%01.0f', ($v['Crit']-$v['Crit']*0.5)).'\' '; }
if($v['AntiCrit'] < 0){ $a .= ', AntiCrit = \''.sprintf ('%01.0f', ($v['AntiCrit']-$v['AntiCrit']*0.5)).'\''; }
if($v['Uv'] < 0){ $a .= ', Uv = \''.sprintf ('%01.0f', ($v['Uv']-$v['Uv']*0.5)).'\' '; }
if($v['AntiUv'] < 0){ $a .= ', AntiUv = \''.(sprintf ('%01.0f', $v['AntiUv']-$v['AntiUv']*0.5)).'\''; }

if($v['MINdamage'] > 0){ $a .= ', MINdamage = \''.sprintf ('%01.0f', ($v['MINdamage']+$v['MINdamage']*0.5)).'\''; }
if($v['MAXdamage'] > 0){ $a .= ', MAXdamage = \''.sprintf ('%01.0f', ($v['MAXdamage']+$v['MAXdamage']*0.5)).'\''; }
if($v['Armor1'] > 0){ $a .= ', Armor1 = \''.sprintf ('%01.0f', ($v['Armor1']+$v['Armor1']*0.5)) .'\''; }
if($v['Armor2'] > 0){ $a .= ', Armor2 = \''.sprintf ('%01.0f', ($v['Armor2']+$v['Armor2']*0.5)).'\''; }
if($v['Armor3'] > 0){ $a .= ', Armor3 = \''.sprintf ('%01.0f', ($v['Armor3']+$v['Armor3']*0.5)).'\''; }
if($v['Armor4'] > 0){ $a .= ', Armor4 = \''.sprintf ('%01.0f', ($v['Armor4']+$v['Armor4']*0.5)).'\''; }

if( $v['Endu_add'] > 0 ){  $a .= ', Endu_add = \''.sprintf ('%01.0f', ($v['Endu_add']+$v['Endu_add']*0.5)).'\' '; }

$db->execQuery("UPDATE ".SQL_PREFIX."things SET Thing_Name = concat('[Освящено элитно] ', Thing_Name) $a WHERE Un_Id='".intval($_GET['item'])."' AND Owner='{$player->username}' LIMIT 1 ");
$db->execQuery("UPDATE ".SQL_PREFIX."bank_acc SET Euro = Euro - '".sprintf('%01.0f', ($v['Cost']*0.55))."' WHERE Username = '{$player->username}'");

$err = _TEMPLE_err3;
$e -= sprintf('%01.0f', ($v['Cost']*0.55));

}else{ $err = _TEMPLE_err4; }

} else { $err = _TEMPLE_err5_2; }

}
}
$_GET['osv'] = 2;
}


$a = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '$player->username') AND (Wear_ON = '0') AND Slot NOT BETWEEN '11' AND '14' AND Slot <> '15' AND Slot <> '16' AND Slot <> '11' AND (Thing_Name not like '%Ключ от квартиры%') AND (Thing_Name not like '%Освящено%') ORDER BY Cost");
$b = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '$player->username') AND (Wear_ON = '0') AND (Slot < '11') AND (Thing_Name not like '%made by%') AND (Thing_Name not like '%ability%') AND (Thing_Name not like '%именная%') AND (Thing_Name not like '%клановая%') AND (Thing_Name not like '%Освящено%') ORDER BY Cost");

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'bgcolor', '#D5D5D5'      );
$temp->assign( 'bgcolor2', '#e1e1e1'      );
$temp->assign( 'Money',   $player->Money );
$temp->assign( 'err',     $err           );
$temp->assign( 'a',       $a             );
$temp->assign( 'b',       $b             );
$temp->assign( 'e',       $e             );

if( file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' ) )
{
	$file = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' );
	if( $file == $player->Room ) $temp->assign( 'elka', true  );
}

//$temp->setCache('temple', 60);

//if (!$temp->isCached()) {
$temp->addTemplate('temple', 'timeofwars_loc_temple.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - храм');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
