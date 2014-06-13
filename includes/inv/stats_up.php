<?

if ((!empty($_POST['stats_up']) && (!empty($_POST['Stre']) || !empty($_POST['Agil']) || !empty($_POST['Intu'])  || !empty($_POST['Intl']) || !empty($_POST['Endu']) )   )  || !empty($_GET['stats_up']) ) {

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
//elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
else{

if ($player->Ups > 0) {

if ((!empty($_GET['stats_up']) && $_GET['stats_up'] == 'Stre') || !empty($_POST['Stre'])) {

if( !empty($_POST['Stre']) )
  $Stre = intval($_POST['Stre']);
elseif( !empty($_POST['Stre']) && $_POST['Stre'] >= $player->Ups )
  $Stre = $player->Ups;
else
  $Stre = 1;

$db->update( SQL_PREFIX.'players', Array( 'Stre' => '[+]'.$Stre ), Array( 'Username' => $player->username ), 'maths' );

}


if ((!empty($_GET['stats_up']) && $_GET['stats_up'] == 'Agil') || !empty($_POST['Agil'])) {

if( !empty($_POST['Agil']) )
  $Agil = intval($_POST['Agil']);
elseif( !empty($_POST['Agil']) && $_POST['Agil'] >= $player->Ups )
  $Agil = $player->Ups;
else
  $Agil = 1;


$db->update( SQL_PREFIX.'players', Array( 'Agil' => '[+]'.$Agil ), Array( 'Username' => $player->username ), 'maths' );

}


if ((!empty($_GET['stats_up']) && $_GET['stats_up'] == 'Intu') || !empty($_POST['Intu'])) {

if( !empty($_POST['Intu']) )
  $Intu = intval($_POST['Intu']);
elseif( !empty($_POST['Intu']) && $_POST['Intu'] >= $player->Ups )
  $Intu = $player->Ups;
else
  $Intu = 1;


$db->update( SQL_PREFIX.'players', Array( 'Intu' => '[+]'.$Intu ), Array( 'Username' => $player->username ), 'maths' );

}


if ((!empty($_GET['stats_up']) && $_GET['stats_up'] == 'Intl') || !empty($_POST['Intl'])) {


if( !empty($_POST['Intl']) )
  $Intl = intval($_POST['Intl']);
elseif( !empty($_POST['Intl']) && $_POST['Intl'] >= $player->Ups )
  $Intl = $player->Ups;
else
  $Intl = 1;


$db->update( SQL_PREFIX.'players', Array( 'Intl' => '[+]'.$Intl ), Array( 'Username' => $player->username ), 'maths' );

}

if ((!empty($_GET['stats_up']) && $_GET['stats_up'] == 'Endu') || !empty($_POST['Endu'])) {

if( !empty($_POST['Endu']) )
{
  $Endu   = intval($_POST['Endu']);
  $hp_all = $Endu*3;
}
elseif( !empty($_POST['Endu']) && $_POST['Endu'] >= $player->Ups )
{
  $Endu = $player->Ups;
  $hp_all = $Endu*3;
}
else
{
  $Endu   = 1;
  $hp_all = 3;
}


$che = Array( 'Endu' => '[+]'.$Endu, 'HPall' => '[+]'.$hp_all );

if( $turnir_id ) $che['HPnow'] = '[+]'.$hp_all;

$db->update( SQL_PREFIX.'players', $che, Array( 'Username' => $player->username ), 'maths');

}

if(!empty($_POST['Stre']) || !empty($_POST['Agil']) || !empty($_POST['Intu']) || !empty($_POST['Intl'])  || !empty($_POST['Endu'])){ $upsik = $_POST['Stre'] + $_POST['Agil'] + $_POST['Intu'] + $_POST['Intl'] + $_POST['Endu']; }
else{ $upsik = 1; }

$db->update( SQL_PREFIX.'players', Array( 'Ups' => '[-]'.$upsik ), Array( 'Username' => $player->username ), 'maths' );

$err = 'Характеристики увеличены';

}else { $err = 'У Вас нет свободных апов'; }

}

}
?>
