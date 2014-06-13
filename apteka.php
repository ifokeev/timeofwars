<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('apteka');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$err                = '';
@$buy               = preg_replace('/[^a-zA-Z0-9\_\-]/', '', $_GET['buy']);
@$sale_thing        = intval($_GET['sale_thing']);
@$sale              = $_POST['sale'];


$otdel = !isset($_GET['otdel']) && !isset($_SESSION['otdel']) ? 1 : (isset($_GET['otdel']) ? $_GET['otdel'] : $_SESSION['otdel']);
$_SESSION['otdel'] = $otdel;


@$tbuy  = preg_replace('/[^a-zA-Z0-9\_\-\/]/', '', $_GET['buy_grass']);
@$tsell = preg_replace('/[^a-zA-Z0-9\_\-\/]/', '', $_GET['sell_grass']);
@$num   = intval($_GET['num']);


$price = Array(
'items/vetka' => Array( 'buy' => 500, 'sell' => 0 ),
'items/grass1' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/grass2' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/jen-shen' => Array( 'buy' => 6, 'sell' => 2 ),
'items/kalendula' => Array( 'buy' => 3, 'sell' => 1 ),
'items/vasilek' => Array( 'buy' => 1.5, 'sell' => 0.5 ),
'items/vetrenica' => Array( 'buy' => 6, 'sell' => 2 ),
'items/sumka' => Array( 'buy' => 6, 'sell' => 2 ),
'items/hmel' => Array( 'buy' => 6, 'sell' => 2 ),
'items/devatisil' => Array( 'buy' => 1.5, 'sell' => 0.5 ),
'items/mak' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/shalf' => Array( 'buy' => 6, 'sell' => 2 ),
'items/shalf_r' => Array( 'buy' => 60, 'sell' => 20 ),
'items/veresk' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/sandal' => Array( 'buy' => 6, 'sell' => 2 ),
'items/valer' => Array( 'buy' => 3, 'sell' => 1 ),
'items/vanil' => Array( 'buy' => 3, 'sell' => 1 ),
'items/durman' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/pustir' => Array( 'buy' => 1.5, 'sell' => 0.5 ),
'items/muhomor' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/lisichka' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/siroezka' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/opata' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/krasnyi' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/maslenok' => Array( 'buy' => 1.2, 'sell' => 0.4 ),
'items/rose_g' => Array( 'buy' => 120, 'sell' => 40 ),
);


if( !empty($tbuy) )
{	if( !is_numeric($num) || $num <= 0 )
	{		$err = 'Ай-яй-яй...';
    }
    elseif( !$cnt = @$db->SQL_result($db->query( "SELECT num FROM ".SQL_PREFIX."things_apteka_trava WHERE trava = '".$tbuy."' AND num > '0';" )) )
    {    	$err = 'Такой травы в закромах не найдено';
    }
    elseif( $num > $cnt )
    {    	$err = 'Такого количества не найдено';
    }
    elseif( $num*$price[$tbuy]['buy'] > $player->Money )
    {    	$err = 'У вас нет столько денег';
    }
    else
    {    	if ( !$db->numrows("SELECT * FROM `".SQL_PREFIX."things` WHERE Owner = '$player->username' AND Id = '".$tbuy."'") )
    	{    		$db->insert( SQL_PREFIX.'things', Array( 'Owner' => $player->username, 'Id' => $tbuy, 'Thing_Name' => constant("_FOREST_".str_replace( 'items/', '', $tbuy )), 'Slot' => '15', 'Cost' => $price[$tbuy]['buy'], 'Count' => $num, 'NOWwear' => 0, 'MAXwear' => '1' ) );
    	}
    	else
    	{    		$db->execQuery("UPDATE `".SQL_PREFIX."things` SET Count = Count + '".$num."' WHERE Owner = '$player->username' AND Id = '".$tbuy."'");
    	}

    	$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$num*$price[$tbuy]['buy'] ), Array( 'Username' => $player->username ), 'maths' );
        $db->update( SQL_PREFIX.'things_apteka_trava', Array( 'num' => '[-]'.$num ), Array( 'trava' => $tbuy ), 'maths' );

    	$err = 'Товар "'.constant("_FOREST_".str_replace( 'items/', '', $tbuy )."").'" количеством '.$num.' шт. успешно куплен';
    }
}

if (!empty($buy) ) {

if ( !$arr = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things_apteka WHERE Amount != '0' AND Id = '$buy'") ) { $err = _SHOP_ERR1; }
elseif ( $arr['Cost'] > $player->Money){ $err = _SHOP_ERR2; }
else {

$db->insert( SQL_PREFIX.'things',   Array( 'Owner' => $player->username, 'Id' => $arr['Id'], 'Thing_Name' => $arr['Thing_Name'], 'Slot' => '16', 'Cost' => $arr['Cost'], 'Level_need' => $arr['Level_need'], 'MagicID' => 'Рецепт изготовления эликсира') );
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Магазин', 'To' => $player->username, 'What' => 'Предмет '.$arr['Thing_Name'].' куплен в аптеке, уникальный ID '.$db->insertId().' ('.date('H:i').')' ) );
$db->update( SQL_PREFIX.'things_apteka', Array( 'Amount' => '[-]1' ), Array( 'Id' => $buy ), 'maths' );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$arr['Cost'] ), Array( 'Username' => $player->username ), 'maths' );

$err = sprintf(_SHOP_MSG1, $arr['Thing_Name'], $arr['Cost'], 'кр.');
$player->Money-= $arr['Cost'];

}

}

unset($buy);

if ( !empty($tsell) )
{
	if( !is_numeric($num) || $num <= 0 )
	{
		$err = 'Ай-яй-яй...';
    }
	elseif ( !$cnt = @$db->SQL_result($db->query("SELECT Count FROM ".SQL_PREFIX."things WHERE Wear_ON = '0' AND Id = '".$tsell."' AND Owner = '$player->username' AND Id LIKE 'items/%'")) )
	{
		$err = _SHOP_ERR5;
	}
	elseif( $num > $cnt )
	{
		$err = 'У вас нет столько травы ;-)';
    }
    else
    {
    	if ( $cnt == $num )
    	{
    		$db->execQuery( "DELETE FROM ".SQL_PREFIX."things WHERE Owner = '".$player->username."' AND Id = '".$tsell."' AND Slot = '15' AND Count = '".$num."';" );
    	}
    	else
    	{
    		$db->execQuery("UPDATE `".SQL_PREFIX."things` SET Count = Count - '".$num."' WHERE Owner = '$player->username' AND Id = '".$tsell."' AND Slot = '15'");
    	}

    	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Аптека(травы)', 'To' => $player->username, 'What' => 'Продал '.constant("_FOREST_".str_replace( 'items/', '', $tsell )."").' количеством '.$num.' шт. ('.date('H:i').')' ) );




    	//// ?????????????
    	$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$num*$price[$tsell]['sell'] ), Array( 'Username' => $player->username ), 'maths' );

        $query = sprintf("INSERT INTO ".SQL_PREFIX."things_apteka_trava ( trava, num ) VALUES ( '%s', '%.2f' ) ON DUPLICATE KEY UPDATE num = num + '%.2f';", $tsell, $num, $num );
        $db->execQuery($query, "apteka_trava ");


        $err = 'Вы успешно продали '.constant("_FOREST_".str_replace( 'items/', '', $tsell )."").' количеством '.$num.' шт.';
    }
}


if (!empty($sale_thing)) {
$arr = $db->queryRow("SELECT Un_Id, Thing_Name, Cost FROM ".SQL_PREFIX."things WHERE Wear_ON = '0' AND Un_Id = '$sale_thing' AND Owner = '$player->username' AND (Slot = '16')");

if (!$arr) { $err = _SHOP_ERR5; }
elseif ( preg_match('/артефакт|клановая|именная|освящено элитно|ability/i', $arr['Thing_Name'])  ) { $err = _SHOP_ERR5; }
else {

$sale_cost = round($arr['Cost'] / 2);

$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Un_Id = '".$arr['Un_Id']."' AND Owner = '$player->username' AND Wear_ON = '0'");
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$sale_cost ), Array( 'Username' => $player->username ), 'maths' );
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => 'Магазин', 'What' => 'Предмет '.$arr['Thing_Name'].' сдан в гос. магазин, уникальный ID '.$arr['Un_Id'].' ('.date('H:i').')' ) );

$err = sprintf(_SHOP_MSG2, $arr['Thing_Name'], $sale_cost, 'кр.');
$player->Money += $sale_cost;

}

$sale = 1;
}

unset($sale_thing);


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'bgcolor', '#D5D5D5');
$temp->assign( 'player',  $player  );
$temp->assign( 'price',   $price   );
$temp->assign( 'sale',    $sale    );
$temp->assign( 'err',     $err     );

if ( !empty($sale) )
{	$temp->assign( 'a', $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Wear_ON = '0' AND (Id LIKE 'elix_%' OR Id LIKE 'recept_%' OR Id LIKE 'items/%')") );
	$otn = _SHOP_thingtypeSALE;
}
elseif( !empty($_SESSION['otdel']) && $_SESSION['otdel'] == 1 )
{	$temp->assign( 'b', $db->queryArray("SELECT * FROM ".SQL_PREFIX."things_apteka WHERE Id LIKE 'recept_%'") );
    $otn = 'Отдел: "Рецепты"';
}
elseif( !empty($_SESSION['otdel']) && $_SESSION['otdel'] == 2 )
{	$temp->assign( 'c', $db->queryArray("SELECT * FROM ".SQL_PREFIX."things_apteka_trava") );	$otn = 'Отдел: "Травы"';
}


$temp->assign( 'otn', $otn );

//if (!$temp->isCached()) {
$temp->addTemplate('apteka', 'timeofwars_loc_apteka.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - аптека');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
