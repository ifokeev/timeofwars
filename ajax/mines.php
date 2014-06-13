<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

//require_once 'JsHttpRequest.php';

//$JsHttpRequest =& new JsHttpRequest("windows-1251");

header('Content-type: text/html; charset=windows-1251');
if( $_POST['slot'] == '' ) die;

error_reporting(E_ALL);
include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../mines.inc');
include_once ('../classes/PlayerInfo.php');
include_once ('../includes/to_view.php');
include_once ('../includes/lib/php2js.php');


$player = new PlayerInfo();

if( !$us = $db->queryRow( "SELECT * FROM ".SQL_PREFIX."mines WHERE Player = '".$player->username."';" ) )
{
	$db->insert( SQL_PREFIX.'mines', Array( 'Player' => $player->username ) );
}



function GetRudaCount($id){
global $db, $player;
return (int)@$db->SQL_result($db->query( "SELECT Count FROM ".SQL_PREFIX."metall_store WHERE Player = '".$player->username."' AND Metall = '".$id."';" ));
}


function ReCalcCounts(){
global $db, $player, $allcount, $wincount, $losecount, $diecount, $magicName;

$temp_count = $allcount-$diecount;
$count      = 0;

  //Теперь считаем повышения от кирок и пр
if( $kirka = $db->queryRow( "SELECT Un_Id, MAXwear, NOWwear, Srab FROM ".SQL_PREFIX."things WHERE MagicID = '".$magicName."' AND Owner = '".$player->username."' AND Wear_ON = '1';") )
{
	if( $kirka['NOWwear'] >= $kirka['MAXwear'] )
	{
		$db->execQuery( "DELETE FROM ".SQL_PREFIX."things WHERE MagicID = '".$magicName."' AND Wear_ON='1' AND Owner = '".$player->username."' AND Un_Id = '".$kirka['Un_Id']."';");

        $txt = '<i>Почта от <b> Информация </b> (послано '.date('d.m.y H:i').'):</i> Кирка совсем сточилась. Она больше непригодна к использованию.';
        $db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player->username, 'Text' => mysql_escape_string($txt) ) );

        $ok = 0;
    }

    if ( $ok !== 0 )  $count += $kirka['Srab'];

    $count    *= 0.01;
    $fcount    = ceil($wincount*(1+$count));
    $wincount  = min($fcount, $temp_count);
    $losecount = $allcount-$diecount-$wincount;

    $db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $kirka['Un_Id'], 'Owner' => $player->username, 'MagicID' => $magicName, 'Wear_ON' => 1 ), 'maths' );

}

}

function GetMinesLevel(){
global $db, $player, $baseexp, $multexp;

$exp   = @$db->SQL_result($db->query( "SELECT Exp FROM ".SQL_PREFIX."mines WHERE Player = '".$player->username."';" ));
$exp   = $exp/$baseexp;

$level = floor(Log10($exp) / Log10($multexp));
$level++;
if ( $level < 0 ){ $level = 0; }
return $level;
}


function GetNextExp($login){
global $db, $player, $baseexp,$multexp;

$curlevel = GetMinesLevel();
return intval( $baseexp * ( pow($multexp, $curlevel) ) );

}



function GetSlots(){
global $db, $player;

srand((double)microtime()*1000000);

return explode(";",  @$db->SQL_result($db->query( "SELECT slots FROM ".SQL_PREFIX."mines WHERE Player = '".$player->username."';" )) );
}




function SetNewSlots($max, $wincount, $diecount, $losecount){
global $db, $player;

$j=0;

for($i = 0; $i < $max; $i++)
{
	$slots[$i] = '';
}

for($i = 0; $i < $diecount; $i++)
{
	$j = rand(0, $max-1);
	while($slots[$j] != '')
	{
		$j = rand(0, $max-1);
	}
}

for($i = 0; $i < $wincount; $i++)
{
	$j = rand(0, $max-1);
    while($slots[$j] != '')
    {
    	$j = rand(0, $max-1);
    }

    $slots[$j] = 2;
    //echo "Выигрыш:".($j+1)."<br>";
}

for($i = 0; $i < $losecount; $i++)
{
	$j = rand(0, $max-1);
    while($slots[$j] != '')
    {
    	$j = rand(0, $max-1);
    }

    $slots[$j] = 1;
}

for($i = 0; $i < $max; $i++)
{
	if ($slots[$i] == ''&& $slots[$i]!=0 )
	{
		$slots[$i] = 1;
	}
}

$slotsstr = implode($slots, ";");
$db->update( SQL_PREFIX.'mines', Array( 'Slots' => $slotsstr ), Array( 'Player' => $player->username ) );
return $slotsstr;
}


function GetMetal(){
global $db, $player, $ruda_id, $ruda_exp, $ruda_name, $rudacount, $level, $levelpercent;

$rnd = rand(0, 100);

for ($i = 0; $i < $rudacount; $i++)
{
	if ($levelpercent[$level][$i] > 0 && $rnd >= 0 && $rnd <= $levelpercent[$level][$i])
	{
		$j = $i;
	}

    $rnd = $rnd-$levelpercent[$level][$i];
}

if ($j >= $rudacount)
{
	$j = $rudacount-1;
}


if( $db->numrows( "SELECT * FROM ".SQL_PREFIX."metall_store WHERE Player = '".$player->username."' AND Metall = '".$ruda_id[$j]."'; " ) )
{
	$db->update( SQL_PREFIX.'metall_store', Array( 'Count' => '[+]1' ), Array( 'Player' => $player->username, 'Metall' => $ruda_id[$j] ), 'maths' );
}
else
{
	$db->insert( SQL_PREFIX.'metall_store', Array( 'Player' => $player->username, 'Metall' => $ruda_id[$j], 'Count' => 1 ) );
}

$db->update( SQL_PREFIX.'mines', Array( 'Exp' => '[+]'.$ruda_exp[$j], 'last_activy' => time() ), Array( 'Player' => $player->username ), 'maths' );

return 'Вы нашли '.$ruda_name[$j].'. Получено опыта '.$ruda_exp[$j];
}


$slots = GetSlots();
$level = GetMinesLevel();
ReCalcCounts();
$msg   = '';

if ( !empty($_POST['slot']) && $_POST['slot'] != 0 && is_numeric($_POST['slot']) )
{
	if( (time() - $us['last_activy']) > 2 )
	{		switch ($slots[$_POST['slot']-1])
		{

		case 0:
		case 1:
		$db->update( SQL_PREFIX.'mines', Array( 'last_activy' => time() ), Array( 'Player' => $player->username ), 'maths' );
		$msg  = 'К сожалению, вы ничего не нашли';
		break;


		case 2:
		$msg = GetMetal();
		$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'MagicID' => $magicName, 'Wear_ON' => 1, 'Owner' => $player->username ), 'maths' );
		break;
		}
	}
	else
	{		$db->update( SQL_PREFIX.'mines', Array( 'Cheat' => '[+]1', 'last_activy' => time() ), Array( 'Player' => $player->username ), 'maths' );		$msg  = 'Между раскопками должен быть интервал в 3 секунды.';
    }
}

$table = "";
for ($i=0;$i<$rudacount;$i++){
  $table .= $ruda_name[$i]." ".GetRudaCount($ruda_id[$i]).", ";
}
$table .= "";



SetNewSlots($allcount, $wincount, $diecount, $losecount);





$arr = array(
  'table'  => $table,
  'newexp' => GetNextExp($player->username),
  'exp'    => @$db->SQL_result($db->query( "SELECT Exp FROM ".SQL_PREFIX."mines WHERE Player = '".$player->username."';" )),
  'level'  => GetMinesLevel(),
  'msg'    => $msg
);

echo php2js($arr);
?>