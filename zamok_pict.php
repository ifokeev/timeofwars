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
$player->checkRoom('zamok_pict');

$room = split( '__', $player->ChatRoom );

if(!empty($_GET['goto']) && $_GET['goto'] == 'zamok' ){
$player->gotoRoom( 'zamok', $room[0] );
}

$player->heal();

$msg         = Array();
$out         = Array();
@$buy        = preg_replace('/[^0-9\_]/', '', $_GET['buy']);
@$otdel      = $_GET['otdel'] == 'F' ? 'F' : 'M';

if ( !empty($buy) )
{	if( !$dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."pict_".$room[0]." WHERE Id = '".$buy."'") ){ $msg[1] = 'Такого образа не существует'; }
	elseif( $dat['price'] > $player->Money ){ $msg[1] = 'Недостаточно денег для покупки образа'; }
	elseif( $dat['otdel'] != $player->Sex ){  $msg[1] = 'Нельзя купить образ противоположного пола'; }
	elseif( $dat['Author'] == $player->username ){ $msg[1] = 'Нельзя купить образ у самого себя'; }
	else
	{		$files = scandir($db_config[DREAM_IMAGES]['web_root']. SEPARATOR . 'pict' . SEPARATOR . $player->Sex . SEPARATOR );
		foreach($files as $file)
		{			if (preg_match("/.gif/i", $file))
			{
                $file = split( '.gif', $file);

                if (preg_match("/\_/i", $file[0]))
                {                	$file = split( '_', $file[0] );
                }

			    $out[] = $file[0];
	        }
	    }

        $new_id = $player->Sex . SEPARATOR . (max(array_values($out)) + 1) . '_' . rand( 1, 999 );

        if( !empty($db_config[101]['server']) )
        {        	$connect = ftp_connect( $db_config[101]['server'] );
        	$log_res = ftp_login( $connect, $db_config[101]['user'], $db_config[101]['pass'] );

        	if( empty($connect) || empty($log_res) )
        	{        		die('ошибка закачки на сервер');
        	}

        	$from   = $db_config[100]['web_root'] . SEPARATOR . 'pict' .  SEPARATOR . 'zamok' . SEPARATOR . $dat['Id'] . '.gif';
        	$to     = $db_config[100]['web_root'] . SEPARATOR . 'pict' .  SEPARATOR . $new_id . '.gif';

        	if( !ftp_rename($connect, $from, $to) )
        	{        		die('ошибка');
        	}

        	ftp_close($connect);
        }
        else
        {        	copy( $db_config[DREAM_IMAGES]['web_root'] . SEPARATOR . 'pict' .  SEPARATOR . 'zamok' . SEPARATOR . $dat['Id'] . '.gif', $db_config[DREAM_IMAGES]['web_root'] . SEPARATOR . 'pict' .  SEPARATOR . $new_id . '.gif' );
        	unlink( $db_config[DREAM_IMAGES]['web_root'] . SEPARATOR . 'pict' .  SEPARATOR . 'zamok' . SEPARATOR . $dat['Id'] . '.gif' );
	    }



        $db->execQuery( "DELETE FROM ".SQL_PREFIX."pict_".$room[0]." WHERE Id = '".$dat['Id']."'" );

	    $db->update( SQL_PREFIX.'players', Array( 'Pict' => $new_id, 'Money' => '[-]'.$dat['price'] ), Array( 'Username' => $player->username ), 'maths' );
        $player->Money -= $dat['price'];

        $db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.($dat['price']*0.7) ), Array( 'Username' => $dat['Author'] ), 'maths' );
        $db->insert( SQL_PREFIX.'messages', Array( 'Username' => $dat['Author'], 'Text' => 'Персонаж <b> '.$player->username.' </b> купил ваш образ в магазине кланового замка. Вам зачислено 70% от цены образа.' ) );

        $db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Магазин образов в '.$room[0], 'To' => $dat['Author'], 'What' => 'Получил '.($dat['price']*0.7).' кр. от персонажа '.$player->username.' за <a href="http://'.$db_config[DREAM_IMAGES]['server'].'/pict/'.$new_id.'.gif" target="_blank">образ</a> ('.date('H:i').')' ) );
        $db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Магазин образов в '.$room[0], 'To' => $player->username, 'What' => 'Купил <a href="http://'.$db_config[DREAM_IMAGES]['server'].'/pict/'.$new_id.'.gif" target="_blank">образ</a> за  '.$dat['price'].' кр. у персонажа '.$dat['Author'].' ('.date('H:i').')' ) );

        $db->update( SQL_PREFIX.'castles', Array( 'balance' => '[+]'.($dat['price']*0.3) ), Array( 'zamok' => $room[0] ), 'maths' );

	    $msg[1] = 'Образ успешно установлен.';
    }

}


function ftp_upload($server, $user, $pass, $dest, $file)
{
error_reporting(E_ALL);
$connect = ftp_connect($server);
$log_res = ftp_login($connect, $user, $pass);

if( empty($connect) || empty($log_res) ){ return false; die; }


if ( !ftp_put($connect, $dest, $file, FTP_BINARY) ){ return false; die; }


ftp_close($connect);
return true;
}


if( !empty($_POST['add_new_pict']) && (!empty($_POST['pict_price']) && is_numeric($_POST['pict_price'])) && !empty($_POST['pict_otdel']) && !empty($_FILES['userfile']) )
{
	if( !empty($_FILES['userfile']['name']) && preg_match('/.(gif|GIF)$/i', $_FILES['userfile']['name']) )
	{
		if( $_FILES['userfile']['size'] < 51200 )
		{
			if( $_POST['pict_price'] >= 150 ){

			$file['info'] = getimagesize($_FILES['userfile']['tmp_name']);

			if( $file['info'][0] == 76 && $file['info'][1] == 209 )
			{

				$path = 'zamok_upload' . rand(0, 4) . SEPARATOR . mt_rand(1, 9999) . '_' . mt_rand(1, 9999);

                if( empty($db_config[101]['server']) )
                {                	if( move_uploaded_file($_FILES['userfile']['tmp_name'], $db_config[DREAM]['web_root'] . SEPARATOR . 'images' . SEPARATOR . 'pict' .  SEPARATOR . $path . '.gif') )
                	{                		$db->insert( SQL_PREFIX.'pict_unreg', Array( 'Id' => $path, 'Author' => $player->username, 'date' => 'now()', 'price' => $_POST['pict_price'], 'otdel' => $_POST['pict_otdel'], 'zamok' => $room[0] ) );
                		$msg[1] = 'Образ успешно отправлен на рассмотрение';
                	}
                	else
                	{                		$msg[1] = 'Произошла какая-то ошибка при загрузке файла на сервер...';
                	}
                }
                else
                {                	if( ftp_upload( $db_config[101]['server'], $db_config[101]['user'], $db_config[101]['pass'], $db_config[100]['web_root'] . SEPARATOR . 'pict' . SEPARATOR . $path . '.gif', $_FILES['userfile']['tmp_name'] ) )
                	{                		$db->insert( SQL_PREFIX.'pict_unreg', Array( 'Id' => $path, 'Author' => $player->username, 'date' => 'now()', 'price' => $_POST['pict_price'], 'otdel' => $_POST['pict_otdel'], 'zamok' => $room[0] ) );
                		$msg[1] = 'Образ успешно отправлен на рассмотрение';
                	}
                	else
                	{
                		$msg[1] = 'Произошла какая-то ошибка при загрузке файла на сервер...';
                	}
                }

            }
            else
            {
            	$msg[1] = 'Картинка образа должна быть 209x76 пикселей.';
            }

			}
			else
			{
				$msg[1] = 'Цена образа не может быть меньше 150 кр.';
	        }
		}
		else
		{
			$msg[1] = 'Размер файла не должен превышать 50 КБ';
		}
	}
	else
	{
		$msg[1] = 'Не соответствует расширение файла. Должно быть в формате .gif';
	}

}


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp =& $tow_tpl->getDisplay('content', true);

$temp->assign( 'player', $player     );
$temp->assign( 'err',    implode( "\n<br />\n", $msg )   );
$temp->assign( 'dat',    $db->queryArray("SELECT * FROM ".SQL_PREFIX."pict_".$room[0]." WHERE otdel = '".$otdel."'") );

$temp->addTemplate('zamok_pict', 'timeofwars_loc_pict_zamok.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - клановый магазин образов');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>