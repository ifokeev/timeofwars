<?
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).'GMT' );
header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Content-type: text/html; charset=windows-1251;' );

if( empty($_POST['metall']) || empty($_POST['act']) ) die;

if( $_POST['metall'] != 'iron' && $_POST['metall'] != 'gold' && $_POST['metall'] != 'trash' ) die;


DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');
include_once ('../includes/to_view.php');

$player = new PlayerInfo();
$player->is_blocked();



if( empty( $_POST['howmany'] ) )
{	$msg = 'Нужно ввести количество металла';
}
else
{	if( $_POST['act'] == 'sell' )
	{		$num = @$db->SQL_result($db->query( "SELECT Count FROM ".SQL_PREFIX."metall_store WHERE Metall = '".speek_to_view($_POST['metall'])."' AND Player = '".$player->username."';" ));

        if( !is_numeric($_POST['howmany']) )
        {
        	$msg = 'Попытка обмана зенесена в логи';
        }
        elseif( $_POST['howmany'] <= 0 )
        {
        	$msg = 'Ай-яй-яй';
        }
		elseif( $_POST['howmany'] > $num )
		{			$msg = 'У вас нет столько металла';
        }
        else
        {        	switch( $_POST['metall'] )
		{
			case 'trash': $price = 0.05; $name = 'мусор';  break;
			case 'iron':  $price = 0.2;  $name = 'железо'; break;
			case 'gold':  $price = 0.5;  $name = 'золото'; break;
        }
        	$db->update( SQL_PREFIX.'metall_store', Array( 'Count' => '[-]'.floor($_POST['howmany']) ), Array( 'Player' => $player->username, 'Metall' => speek_to_view($_POST['metall']) ), 'maths' );
            $db->execQuery("INSERT INTO ".SQL_PREFIX."smith_shop ( metall, num ) VALUES ('".speek_to_view($_POST['metall'])."', '".floor($_POST['howmany'])."') ON DUPLICATE KEY UPDATE num = num + '".floor($_POST['howmany'])."';");

        	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Продажа металла', 'To' => $player->username, 'What' => 'Продал '.$name.' кол-вом '.floor($_POST['howmany']).' ('.date('H:i').')' ) );


        	$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.(floor($_POST['howmany'])*$price) ), Array( 'Username' => $player->username ), 'maths' );
        	$player->Money += (floor($_POST['howmany'])*$price);

        	$msg = floor($_POST['howmany']).' шт. металла "'.$name.'" успешно продано в магазин.';
        }
	}
	elseif( $_POST['act'] == 'buy' )
	{		$num = @$db->SQL_result($db->query( "SELECT num FROM ".SQL_PREFIX."smith_shop WHERE metall = '".speek_to_view($_POST['metall'])."' AND num >= '0';" ));

		switch( $_POST['metall'] )
		{
			case 'iron':  $price = 1; $name = 'железо'; $met = 'iron'; break;
			case 'gold':  $price = 4; $name = 'золото'; $met = 'gold'; break;
			default: die('такого металла не найдено.'); break;
        }

        if( !is_numeric($_POST['howmany']) )
        	$msg = 'Попытка обмана зенесена в логи';

        elseif( $_POST['howmany'] <= 0 )
        	$msg = 'Ай-яй-яй';

		elseif( $_POST['howmany'] > $num )			$msg = 'В магазине нет столько металла';

        elseif( $player->Money < ( floor($_POST['howmany'])*$price ) )
            $msg = 'У вас нет столько денег';

        else
        {
           if( $db->queryRow( "SELECT Metall FROM ".SQL_PREFIX."metall_store WHERE Player = '".$player->username."' AND Metall = '".$met."';" ) )
            	$db->update( SQL_PREFIX.'metall_store', Array( 'Count' => '[+]'.floor($_POST['howmany']) ), Array( 'Player' => $player->username, 'Metall' => $met ), 'maths' );
           else
            	$db->insert( SQL_PREFIX.'metall_store', Array( 'Player' => $player->username, 'Count' => floor($_POST['howmany']), 'Metall' => $met ) );

            $db->update( SQL_PREFIX.'smith_shop', Array( 'num' => '[-]'.floor($_POST['howmany']) ), Array( 'metall' => $_POST['metall'] ), 'maths' );

        	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Покупка металла', 'To' => $player->username, 'What' => 'Купил '.$name.' кол-вом '.floor($_POST['howmany']).' ('.date('H:i').')' ) );


        	$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.(floor($_POST['howmany'])*$price) ), Array( 'Username' => $player->username ), 'maths' );
        	$player->Money -= (floor($_POST['howmany'])*$price);

        	$msg = floor($_POST['howmany']).' шт. металла "'.$name.'" успешно куплено в магазин.';




        }
	}
}
?>
<div id="take_money">
   <fieldset>
    <center>
     <?=$msg;?><br /><br />
     <a href="#" title="Close window" onclick="Modalbox.hide();minesGo(0);return false;">Close</a>
    </center>
   </fieldset>
</div>