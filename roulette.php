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
$player->checkRoom('roulette');

if(!empty($_GET['goto']) && $_GET['goto'] == 'casino' ){
$player->gotoRoom( $_GET['goto'], $_GET['goto'] );
}

$player->heal();

$w = @$db->SQL_result($db->query("SELECT Price FROM ".SQL_PREFIX."casino WHERE Username = '$player->username'"), 0);
if ($w > '500') { die( include_once('tow_templates/content/timeofwars_casino_many_price.html') ); }

if( $player->Level < 5 ) { die( include_once('tow_templates/content/timeofwars_casino_low_level.html') ); }

include_once ('chat/func_chat.php');


function make_seed()
{
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}

function gen($min, $max, $count = 1){
$result = array();

if($min > $max) return $result;
$count = min( max($count, 0), $max-$min+1 );
while( count($result) < $count ) {
mt_srand(make_seed());
$value = mt_rand( $min, $max-count($result) );
foreach($result as $used) if($used<=$value) $value++; else break;
$result[] = $value;
sort($result);
}

shuffle($result);
return $result;
}


$lefttime = 90;
$minbet = 1;
$maxbet = 50;
$wasbets = 0;


@$bet = $_GET['bet'];
@$betto = $_GET['betto'];

function writestring($string){
$string = GetMicroTime().'>><a class=date>'.date('H:i').'</a> <FONT SIZE=2>[<span>'._ROULETTE_name.'</span>] '.$string.'</FONT>'; $string = trim($string)."\n";
//$fp = fopen('chat/roulette.txt', 'a');
$fp = fopen('chat/allchat.txt', 'a');
fwrite($fp,$string); fclose($fp);
}

$roul_names[0] = 'ZERO';
for ($i=0; $i<3; $i++){
for ($j=0; $j<12; $j++)
$roul_names[$j*3+$i+1]=($j*3+$i+1);
$roul_names[37+$i]=($i+1)._ROULETTE_37;
$roul_names[40+$i]=($i+1)._ROULETTE_40;
}
$roul_names[43] = _ROULETTE_43;
$roul_names[44] = _ROULETTE_44;
$roul_names[45] = _ROULETTE_45;
$roul_names[46] = _ROULETTE_46;
$roul_names[47] = _ROULETTE_47;
$roul_names[48] = _ROULETTE_48;
for ($j=0; $j<12; $j++){
$roul_names[49+$j]=($j*3+1) . '-' . ($j*3+3);
$roul_names[61+$j]=($j*3+2) . ',' . ($j*3+3);
$roul_names[73+$j]=($j*3+1) . ',' . ($j*3+2);
}
for ($j=0; $j<11; $j++){
for ($i=0; $i<3; $i++)
$roul_names[85+(2-$i)*11+$j]=($j*3-$i+3) . ',' . ($j*3-$i+6);
$roul_names[118+$j]=($j*3+1) . '-' . ($j*3+6);
$roul_names[129+$j]=($j*3+1) . ',' . ($j*3+2) . ',' . ($j*3+4) . ',' . ($j*3+5);
$roul_names[140+$j]=($j*3+2) . ',' . ($j*3+3) . ',' . ($j*3+5) . ',' . ($j*3+6);
}

$roul_wins[0][0]=36;
$red=array(1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36);
for ($i=1; $i<=36; $i++){
$roul_wins[$i][$i]=36;
}
for ($i=0; $i<3; $i++){
for ($j=0; $j<12; $j++){
$roul_wins[$i+1+$j*3][37+$i]=3;
$roul_wins[$i+1+$j*3][40+floor(($i+$j*3)/12)]=3;
$roul_wins[$i+1+$j*3][43+floor(($i+$j*3)/18)*5]=2;
$roul_wins[$i+1+$j*3][47-(($i+$j*3)%2)*3]=2;
$roul_wins[$i+1+$j*3][49+floor(($i+$j*3)/3)]=12;
$roul_wins[$i+1+$j*3][45+(in_array($i+1+$j*3,$red)?0:1)]=2;
}
}

for ($j=0; $j<12; $j++){
$roul_wins[$j*3+2][61+$j]=18;
$roul_wins[$j*3+3][61+$j]=18;
$roul_wins[$j*3+1][73+$j]=18;
$roul_wins[$j*3+2][73+$j]=18;
}

for ($j=0; $j<11; $j++){
for ($i=0; $i<3; $i++){
$roul_wins[$j*3-$i+3][85+(2-$i)*11+$j]=18;
$roul_wins[$j*3-$i+6][85+(2-$i)*11+$j]=18;
}
for ($i=1; $i<=6; $i++) $roul_wins[$j*3+$i][118+$j]=6;
$roul_wins[$j*3+1][129+$j]=9;
$roul_wins[$j*3+2][129+$j]=9;
$roul_wins[$j*3+4][129+$j]=9;
$roul_wins[$j*3+5][129+$j]=9;
$roul_wins[$j*3+2][140+$j]=9;
$roul_wins[$j*3+3][140+$j]=9;
$roul_wins[$j*3+5][140+$j]=9;
$roul_wins[$j*3+6][140+$j]=9;



}


$db->query("LOCK TABLES ".SQL_PREFIX."roul_time WRITE, ".SQL_PREFIX."roul_bets WRITE, ".SQL_PREFIX."roul_wins WRITE");

if( $time = $db->queryCheck('SELECT * FROM '.SQL_PREFIX.'roul_time') ){ $time = $time[0]; }
else{ $time = time(); }

if ($time <= time()){

$num = implode(', ', gen(0, 36));

$bets = $db->query('SELECT * FROM '.SQL_PREFIX.'roul_bets');
if ( $db->SQL_numrows($bets) ){

$wasbets = 1;
if (!$num){                   $strnum = 'Zero';                  }
elseif(in_array($num, $red)){ $strnum = $num.', '._ROULETTE_45;  }
else{                         $strnum = $num.', '._ROULETTE_46;  }

writestring( sprintf(_ROULETTE_msg1, $strnum) );

}


while ( $cbet = $db->SQL_fetch_assoc($bets) ){

if ($roul_wins["$num"][$cbet['betto']]){

$wins[$cbet['Username']] += $cbet['bet']*$roul_wins["$num"][$cbet['betto']];
$tm = time()-3600*24*7;

$db->execQuery("DELETE FROM ".SQL_PREFIX."roul_wins WHERE wintime < '$tm'");
$db->insert( SQL_PREFIX.'roul_wins', Array( 'Username' => $cbet['Username'], 'bet' => $cbet['bet'], 'betto' => $cbet['betto'], 'win' => $cbet['bet']*$roul_wins[$num][$cbet['betto']], 'wintime' => time() ) );

}

}

$db->execQuery('DELETE FROM '.SQL_PREFIX.'roul_bets');
$db->execQuery('DELETE FROM '.SQL_PREFIX.'roul_time');
$db->insert( SQL_PREFIX.'roul_time', Array( 'shouldstart' => (time()+$lefttime) ) );

}

if( $time = $db->queryCheck('SELECT * FROM '.SQL_PREFIX.'roul_time') ){ $time = $time[0]; }
else{ $time = time(); }

$lefttime = $time-time()+2;

$db->query('UNLOCK TABLES');

$winners = '';

if (isset($wins)){

foreach ($wins as $user => $winmoney){
if ($winners) $winners .= ', ';
$winners .= $user;

$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$winmoney ), Array( 'Username' => $user ), 'maths' );
$db->execQuery("INSERT INTO ".SQL_PREFIX."casino (Username, Price) VALUES ('$user', '0') ON DUPLICATE KEY UPDATE Price = Price + '$winmoney'");

}

}


if ($wasbets){

if ($winners){ writestring( sprintf(_ROULETTE_msg2, $winners) );  }
else {         writestring( _ROULETTE_msg3 );                     }

}


$outstr='';
if ( !empty($bet) && $betto != '' && $roul_names[$betto]) {
if ( is_numeric($bet) && is_numeric($betto) ) {

if ($bet < $minbet){     $outstr = _ROULETTE_err1;  }
elseif ($bet > $maxbet){ $outstr = _ROULETTE_err2;  }
elseif ($bet > $player->Money){  $outstr = _ROULETTE_err3;  }
else  {

$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.floatval($bet) ), Array( 'Username' => $player->username ), 'maths' );
$db->execQuery("INSERT INTO ".SQL_PREFIX."casino (Username, Price) VALUES ('$player->username', '0') ON DUPLICATE KEY UPDATE Price = Price - '$bet'");
$db->insert( SQL_PREFIX.'roul_bets', Array( 'Username' => $player->username, 'bet' => floatval($bet), 'betto' => $betto ) );

$outstr = _ROULETTE_err4;

writestring( sprintf(_ROULETTE_msg4, $player->username, $roul_names[$betto]) );
$player->Money -= $bet;
}

} else {
$outstr = _ROULETTE_err5;
$fp = fopen('chat/roulette_obman.txt', 'a'); fwrite($fp, $player->username.'||'); fclose($fp);
writestring( sprintf(_ROULETTE_err6, $player->username) );
}

}



$r = $db->queryArray("SELECT * FROM ".SQL_PREFIX."roul_wins WHERE Username = '$player->username' ORDER BY wintime DESC LIMIT 5");

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'roul_names', $roul_names    );
$temp->assign( 'lefttime',   $lefttime      );
$temp->assign( 'outstr',     $outstr        );
$temp->assign( 'Money',      $player->Money );
$temp->assign( 'r',          $r             );


//$temp->setCache('roulette', 60);

//if (!$temp->isCached()) {
$temp->addTemplate('roulette', 'timeofwars_loc_roulette.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - рулетка');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
