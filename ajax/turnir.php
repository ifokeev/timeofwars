<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);
session_start();


header('Content-type: text/html; charset=windows-1251');

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');
include_once ('../classes/ChatSendMessages.php');
include_once ('../includes/lib/php2js.php');
include_once ('../includes/turnir/func.php');


$player = new PlayerInfo();


$player->heal();

function okon4 ($number, $titles){
$cases = array (2, 0, 1, 1, 1, 2);
return $number.' '.$titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
}



function dataload( $page = 1 )
{	global $db, $player, $db_config;

	    if( !empty($_SESSION['turnir_time']) && time() - $_SESSION['turnir_time'] <= 2 )
	    {	    	die('time');
	    }
		$p = intval($page);

		$turn_num = $db->numrows("SELECT * FROM ".SQL_PREFIX."turnir");
                         $num   = 10;
                         $total = @ceil($turn_num/$num);
    	if(empty($p) || $p < 0): $p     = 1;         endif;
    	if($p > $total):         $p     = $total;    endif;
                         $start = max( 0, ($p * $num - $num) );

    	$turnirs = $db->queryArray("SELECT * FROM ".SQL_PREFIX."turnir ORDER BY date DESC LIMIT ".$start.", ".$num);

    	$pages = array();
    	$s     = 0;
    	$out   = '';

    	for($i = 1; $i <= $total; $i++) {
    		if( ($i <= 2  || ($i >= $p-2 && $i <= $p+2)  ||  $i > $total-2 ) && !in_array($i, $pages)) $pages[] = $i;
    	}

    	$p > 1 ? $left = ' <a href="javascript:loadpage('.($p-1).');">предыдущая</a> ' : $left = '&nbsp;';

    	$p < $total && $total > 1 ? $right = ' <a href="javascript:loadpage('.($p+1).');">следующая</a> ' : $right = '&nbsp;';

    	$cont = '';
    	if( !empty($turnirs) )
    	{    	    $cont .= '
    			<table width="80%" align="center" valign="top">
    			 <tr>
    			  <td align="center">№</td>
    			  <td align="center">Дата</td>
    			  <td align="center">Время</td>
    			  <td align="center">Настройки</td>
    			  <td>Победитель</td>
    			  <td>Клан</td>
    			  <td align="right">Приз</td>
    			  <td align="right">Очков</td>
    			 </tr>
    			 ';
    		foreach( $turnirs as $turn )
    		{

    			$cont .=
    			'
    			 <tr>
                  <td align="center"><a href="turnir_log.php?id='.$turn['id'].'" target="_blank">'.$turn['id'].'</a></td>
                  <td align="center">'.date( 'F j', $turn['date']).'</td>
                  <td align="center">'.date( 'H:i', $turn['date']).'</td>
                  <td align="center">М.ставка: '.$turn['stavka'].', шаг: '.$turn['next_stavka'].'%, человек: '.$turn['players'].'</td>
                ';

                switch( $turn['status'] )
                {
                 case 1:

                 $text = '<small>Вы можете поставить от '.$turn['stavka'].' до '.ceil($turn['stavka']+$turn['stavka']/100*$turn['next_stavka']).' кр.</small>';
                 if( !@$db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->username."';" ),0) )
                 {                 	$cont .= '<td><a href="javascript:;" onclick="$(\'#info\').html(\''.$text.'\');$(\'#do_stavka\').slideToggle(\'slow\');$(\'#turnir_id\').val(\''.$turn['id'].'\');">Принять участие</a></td>';
                 }

                 //$cont .= '<td><div id="timer">0:00</div><script>lefttime = 55; timer();</script></td>';
                 $cont .= '<td><div id="timer">0:00</div><script> var lefttime = '.($turn['date']+$turn['wait']-time()).'; timer();</script></td>';

                 break;
                 case 2: $cont .= '<td><a href="turnir_log.php?id='.$turn['id'].'" target="_blank">В процессе</a></td>'; break;
                 case 3: list($uname, $level, $clanid) = split( ';', $turn['winner'] );
                  if( !empty($uname) )
                  {                  	$cont .= '<td><a href="inf.php?uname='.$uname.'" target="_blank">'.$uname.' ['.$level.']</a></td>';
                  }
                  else
                  {                  	$cont .= '<td><b>нет</b></td>';
                  }


                  if( !empty($clanid) )
                  $cont .= '<td><a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a></td>';
                  else $cont .= '<td>&nbsp;</td>';


                  $cont .= '<td align="right">'.$turn['prize'].' кр.</td>
                  <td align="right">'.$turn['points'].'</td>
                  ';
                 break;
                }

                 $cont .= '</tr>';
            }
        }


        $arr = array(
        'left' => $left,
        'right' => $right,
        'content' => $cont,
        'msg' => 'Заявка добавлена',
        );

        $_SESSION['turnir_time'] = time();
        return php2js( $arr );

}


switch( $_GET['act'] )
{	case 'dataload':
	  echo dataload( empty($_GET['page']) ? 1 : $_GET['page'] );
	break;



	case 'new_zayavka':
	  if( empty( $_GET['stavka'] ) || empty($_GET['next_stavka']) || $_GET['next_stavka'] > 100 || empty($_GET['users']) || empty($_GET['wait']) || !is_numeric($_GET['users']) || !is_numeric($_GET['wait']) || $_GET['next_stavka'] <= 0 || $_GET['stavka'] <= 0 || $_GET['users'] <= 1 ){ die( php2js( array( 'err' => 'Неправильно заданы параметры' ) ) ); }
      if( @$db->SQL_result($db->query( "SELECT id FROM ".SQL_PREFIX."turnir WHERE status = '1' OR status = '2';" ),0) ){ die( php2js( array( 'err' => 'Турнир уже создан. Вы можете принять в нем участие.' ) ) ); }
	  if( $db->queryRow( "SELECT user FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->username."';" ) ){ die( php2js( array( 'err' => 'Вы уже принимаете участие в турнире.' ) ) ); }
	  if( $player->Money < floor($_GET['stavka']) ){ die( php2js( array( 'err' => 'У вас недостаточно денег, чтобы сделать ставку.' ) ) ); }
      if( $player->HPnow < $player->HPall/2) { die( php2js( array( 'err' => 'В таком состоянии нельзя незть в бой.' ) ) ); }
      if( $db->numrows("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '$player->username'") ){ die( php2js( array( 'err' => 'Для начала необходимо вылечить травму.' ) ) ); }
	  $db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.floor($_GET['stavka']) ), Array( 'Id' => $player->user_id ), 'maths' );
	  $db->insert( SQL_PREFIX.'turnir', Array( 'date' => time(), 'creator' => $player->username.';'.$player->Level.';'.$player->id_clan.';', 'stavka' => floor($_GET['stavka']), 'next_stavka' => intval($_GET['next_stavka']), 'players' => floor($_GET['users']), 'wait' => intval($_GET['wait']*60), 'prize' => floor($_GET['stavka']) ), 'query' );
      $id = mysql_insert_id();
      $db->insert( SQL_PREFIX.'turnir_users', Array( 'turnir_id' => $id, 'user' => $player->username ) );
	  turnir_log( $id, date('d.m.Y').' в '.date('H:i:s').' персонаж '.wslogin( $player->username, $player->Level, $player->id_clan ).' организовал новый турнир. Настройки: минимальная ставка &#151; '.floor($_GET['stavka']).' кр., шаг &#151; '.intval($_GET['next_stavka']).'%, человек &#151; '.floor($_GET['users']).'.' );
	  turnir_msg( 'Приглашаются участники. Настройки: минимальная ставка &#151; '.floor($_GET['stavka']).' кр., шаг &#151; '.intval($_GET['next_stavka']).'%, человек &#151; '.floor($_GET['users']).'. Начнется через <b>'.okon4( intval($_GET['wait']), array('минуту', 'минуты', 'минут') ).'.</b>' );
	  echo dataload();
	break;

	case 'go':
	  if( empty($_GET['stavka']) || !is_numeric($_GET['stavka']) || $_GET['stavka'] <= 0 ){ die( php2js( array( 'err' => 'Неправильная ставка.' ) ) ); }
      if( !list($id, $min, $shag, $stat, $kolvo) = $db->queryCheck( "SELECT id, stavka, next_stavka, status, players FROM ".SQL_PREFIX."turnir WHERE id = '".intval($_GET['turnir'])."';" ) ){ die( php2js( array( 'err' => 'Такого турнира не существует.' ) ) ); }
	  if( $db->queryRow( "SELECT user FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->username."';" ) ){ die( php2js( array( 'err' => 'Вы уже принимаете участие в турнире.' ) ) ); }
      if( $db->numrows( "SELECT user FROM ".SQL_PREFIX."turnir_users WHERE turnir_id = '".$us_data['turnir_id']."';" ) == $kolvo ){ die( php2js( array( 'err' => 'Турнир полон.' ) ) ); }
      if( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."demands WHERE Username = '$player->username' OR Name_pr = '$player->username'") ){ die( php2js( array( 'err' => 'Нельзя что-либо надеть, находясь в заявке на бой.' ) ) ); }
      if( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (Team1 LIKE '%".$player->username."%') OR (Team2 LIKE '%".$player->username."%')") ){ die( php2js( array( 'err' => 'Нельзя что-либо надеть, находясь в заявке на бой.' ) ) ); }
      if( floor($_GET['stavka']) > ceil($min+$min/100*$shag) || floor($_GET['stavka']) < $min ){ die( php2js( array( 'err' => 'Ставка слишком большая либо слишком маленькая.' ) ) ); }
      if( floor($_GET['stavka']) > $player->Money ){ die( php2js( array( 'err' => 'Недостаточно денег для ставки.' ) ) ); }
      if( $stat != 1 ){ die( php2js( array( 'err' => 'Турнир уже начался.' ) ) ); }
      if( $player->HPnow < $player->HPall/2) { die( php2js( array( 'err' => 'В таком состоянии нельзя лезть в бой.' ) ) ); }
      if( $db->numrows("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '$player->username'") ){ die( php2js( array( 'err' => 'Для начала необходимо вылечить травму.' ) ) ); }
      $db->insert( SQL_PREFIX.'turnir_users', Array( 'turnir_id' => $id, 'user' => $player->username ) );
      $db->update( SQL_PREFIX.'turnir', Array( 'prize' => '[+]'.floor($_GET['stavka']) ), Array( 'id' => $id ), 'maths' );
      $db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.floor($_GET['stavka']) ), Array( 'Id' => $player->user_id ), 'maths' );
	  if( floor($_GET['stavka']) == ceil($min+$min/100*$shag) )
	  {	  	$db->update( SQL_PREFIX.'turnir', Array( 'stavka' => floor($_GET['stavka']) ), Array( 'id' => $id ) );
	  	turnir_log( $id, 'В '.date('H:i:s').' '.wslogin( $player->username, $player->Level, $player->id_clan ).' подал заявку на участие, <b>увеличив</b> ставку до '.floor($_GET['stavka']).' кр.' );
	    turnir_msg( wslogin( $player->username, $player->Level, $player->id_clan ).' подал заявку на участие в турнире, <b>увеличив</b> ставку до '.floor($_GET['stavka']).' кр.' );
	  }
	  else
	  {	  	turnir_log( $id, 'В '.date('H:i:s').' '.wslogin( $player->username, $player->Level, $player->id_clan ).' подал заявку на участие, поставив '.floor($_GET['stavka']).' кр.' );
	    turnir_msg( wslogin( $player->username, $player->Level, $player->id_clan ).' подал заявку на участие в турнире со ставкой '.floor($_GET['stavka']).' кр.' );
	  }

	  echo dataload();
	break;




	default: die; break;
}
?>