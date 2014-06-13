<?
error_reporting(E_ALL);
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
$player->checkRoom('zamok_flower');

$room = split( '__', $player->ChatRoom );

if(!empty($_GET['goto']) && $_GET['goto'] == 'zamok' ){
$player->gotoRoom( 'zamok', $room[0] );
}


$player->heal();

@$_POST['user']     = speek_to_view($_POST['user']);
@$_POST['usersmsg'] = speek_to_view($_POST['usersmsg']);
$msg                = Array();

$clan_id = split( 'zamok_', $room[0] );
if($player->admin == 1 && $player->id_clan == $clan_id[1]){ $admin = 1; }

$dat = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things_presentshop_".$room[0]." WHERE presentCOUNT > '0' ORDER BY presentPRICE ASC");

if( !empty($_POST) && !empty($_POST['user']) ){

foreach($_POST as $k => $v){


if($k == 'user'){ if( !$res = $db->queryCheck("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST[$k]."'") ){ $msg[] = 'Такого персонажа не существует.'; } }
elseif($res && $k != 'usersmsg'){

list($var, $id, $cnt) = split('_', $v); $id = str_replace('i', '', $id);

if( !$data = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things_presentshop_".$room[0]." WHERE id = '$id'") ){ $msg[] = 'Такой вещи нет на складе'; }
elseif($data['presentCOUNT'] < $cnt){ $msg[] = 'Такого количества "'.$data['presentNAME'].'" нет на складе'; }
elseif($data['presentCOUNT']*$cnt > $player->Money){ $msg[] = 'Недостаточно денег для покупки "'.$data['presentNAME'].'"'; }
else{

for($i = 1; $i <= $cnt; $i++){
$db->insert( SQL_PREFIX.'presents', Array( 'Player' => $res[0], 'presentName' => $data['presentNAME'], 'presentIMG' => $data['presentIMG'], 'presentDATE' => time(), 'presentMSG' => $_POST['usermsg'], 'presentFROM' => $player->username ) );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$data['presentPRICE'] ), Array( 'Username' => $player->username ), 'maths' );
$db->update( SQL_PREFIX.'things_presentshop_'.$room[0], Array( 'presentCOUNT' => '[-]1' ), Array( 'id' => $id ), 'maths' );
$db->update( SQL_PREFIX.'castles', Array( 'balance' => '[+]'.$data['presentPRICE']*0.3 ), Array( 'zamok' => $room[0] ), 'maths' );
$txt = '<i>Персонаж <b> '.$player->username.' </b> подарил вам <b> '.$data['presentNAME'].' </b>(послано '.date('d.m.y H:i').')</i>';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $res[0], 'Text' => $txt ) );
$player->Money -= $data['presentPRICE'];
}

$msg[1] = 'Подарки успешно доставлены';
}

}

}

}


function ftp_upload($server, $user, $pass, $dest, $file)
{
$connect = ftp_connect($server);
$log_res = ftp_login($connect, $user, $pass);

if( empty($connect) || empty($log_res) ){ return false; die; }


if ( !ftp_put($connect, $dest, $file, FTP_BINARY) ){ return false; die; }


ftp_close($connect);
return true;
}


if( !empty($_POST['add_new_present']) && !empty($_POST['present_name']) && (!empty($_POST['present_price']) && is_numeric($_POST['present_price'])) && !empty($_FILES['userfile']) && $admin == '1' )
{	if( !empty($_FILES['userfile']['name']) && preg_match('/.(gif|GIF)$/i', $_FILES['userfile']['name']) )
	{		if( $_FILES['userfile']['size'] < 5120 )
		{			if( $_POST['present_price'] >= 5 ){
			$file['info'] = getimagesize($_FILES['userfile']['tmp_name']);

			if( $file['info'][0] == 60 && $file['info'][1] == 60 )
			{
				$path = 'upload' . rand(0, 4) . SEPARATOR . mt_rand(1, 9999) . '_' . mt_rand(1, 9999);

                if( empty($db_config[101]['server']) )
                {                	if( @move_uploaded_file($_FILES['userfile']['tmp_name'], $db_config[DREAM]['web_root'] . SEPARATOR . 'images' . SEPARATOR . 'gifts' .  SEPARATOR . $path . '.gif') )
                	{                		$db->insert( SQL_PREFIX.'things_presentshop_view', Array( 'zamok_number' => $clan_id[1], 'presentNAME' => speek_to_view($_POST['present_name']), 'presentIMG' => $path, 'presentPRICE' => intval($_POST['present_price']), 'presentDATEPOST' => 'now()' ) );
                		$msg[1] = 'Товар успешно отправлен на рассмотрение';
                	}
                	else
                	{                		$msg[1] = 'Произошла какая-то ошибка при загрузке файла на сервер...';
                	}
                }
                else
                {                	if( ftp_upload( $db_config[101]['server'], $db_config[101]['user'], $db_config[101]['pass'], $db_config[100]['web_root'] . SEPARATOR . 'gifts' . SEPARATOR . $path . '.gif', $_FILES['userfile']['tmp_name'] ) )
                	{                		$db->insert( SQL_PREFIX.'things_presentshop_view', Array( 'zamok_number' => $clan_id[1], 'presentNAME' => speek_to_view($_POST['present_name']), 'presentIMG' => $path, 'presentPRICE' => intval($_POST['present_price']), 'presentDATEPOST' => 'now()' ) );
                		$msg[1] = 'Товар успешно отправлен на рассмотрение';
                	}
                	else
                	{
                		$msg[1] = 'Произошла какая-то ошибка при загрузке файла на сервер...';
                	}
                }
            }
            else
            {            	$msg[1] = 'Картинка подарка должна быть 60x60 пикселей.';
            }

			}
			else
			{				$msg[1] = 'Цена подарка не может быть меньше 5 кр.';
	        }
		}
		else
		{			$msg[1] = 'Размер картинки не должен превышать 5 КБ';
		}
	}
	else
	{		$msg[1] = 'Не соответствует расширение файла. Должно быть в формате .gif';
	}

}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'err',   implode( "\n<br />\n", $msg )   );
$temp->assign( 'Money', $player->Money                  );
$temp->assign( 'admin', $admin                          );
$temp->assign( 'dat',   $dat                            );


$temp->addTemplate('flower', 'timeofwars_loc_flower_zamok.html');

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - магазин подарков');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
