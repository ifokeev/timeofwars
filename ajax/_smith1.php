<?
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).'GMT' );
header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Content-type: text/html; charset=windows-1251;' );

DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');
include_once ('../includes/to_view.php');


include_once '../mines.inc';

$player = new PlayerInfo();
$player->is_blocked();


$sumget   = 0;
$sumneed  = 0;
$sumhave  = 0;
$summf    = 0;
$weap_get = array( 'level' => 0, 'str' => 0, 'agil' => 0, 'intu' => 0, 'endu' => 0);
$weap_mf = array(
'str' => 0, 'agil' => 0, 'intu' => 0, 'endu' => 0, 'crit' => 0, 'acrit' => 0, 'uv' => 0, 'auv' => 0,
'arm1' => 0, 'arm2' => 0, 'arm3' => 0, 'arm4' => 0, 'mindmg' => 0, 'maxdmg' => 0);

function GetSmithLevel(){
global $db, $player, $baseexp, $multexp;

$exp   = @$db->SQL_result($db->query("SELECT Exp FROM ".SQL_PREFIX."smith WHERE Player = '".$player->username."'"));
$exp2  = ( (max(1, $exp) ) / $baseexp );
$level = floor( Log10($exp2)/Log10($multexp) );
$level++;
if ($level<0){$level=0;}
return $level;

}

function GetRudaCount($id){
global $db, $player;
return (int)@$db->SQL_result($db->query("SELECT Count FROM ".SQL_PREFIX."metall_store WHERE Player = '".$player->username."' AND Metall = '".$id."';"));
}


function ProcessMF($mf, $value, $ismf){
global $summf, $sumget, $weap_mf, $weap_get, $price;

$value = intval($value);

if ( $value > 0 )
{
	if ($ismf == 1)
	{
		$summf       += $price[$mf]*$value;  if ($mf == 'endu'){ $value*=3; }
		$weap_mf[$mf] = $value;
	}
	else
	{
			$sumget       += $price[$mf]*$value;
			$weap_get[$mf] = $value;
	}
}

}


if ( !empty($_POST['mode']) && $_POST['mode'] == 'make' ){

if( !$db->numrows( "SELECT * FROM ".SQL_PREFIX."smith WHERE Player = '".$player->username."';" ) )
	{
		$db->insert( SQL_PREFIX.'smith', Array( 'Player' => $player->username ) );
	}

	if ( $thing_tpl[$_POST['tpl_num']]["level"] > GetSmithLevel() )
	{
		$err = 'Заготовка не соотвествует уровню.';
		$ok  = 0;
	}
	elseif ( empty($thing_tpl[$_POST['tpl_num']]['slot']) || empty($_POST['weap_name']) || empty($thing_tpl[$_POST['tpl_num']]['image']) || ( $_POST['give_maxdmg'] < $_POST['give_mindmg'] ) )
	{
		$err = 'Неправильно  названы параметры.';
		$ok  = 0;
	}
	else
	{

	ProcessMF("level", $_POST['need_lvl'], 0);
	ProcessMF("str", $_POST['need_str'], 0);
	ProcessMF("str", $_POST['give_str'], 1);
	ProcessMF("agil", $_POST['need_agil'], 0);
	ProcessMF("agil", $_POST['give_agil'], 1);
	ProcessMF("intu", $_POST['need_intu'], 0);
	ProcessMF("intu", $_POST['give_intu'], 1);
	ProcessMF("endu", $_POST['need_endu'], 0);
	ProcessMF("endu", ($_POST['give_endu']/3), 1);
	ProcessMF("crit", $_POST['give_crit'], 1);
	ProcessMF("acrit", $_POST['give_acrit'], 1);
	ProcessMF("uv", $_POST['give_uv'], 1);
	ProcessMF("auv", $_POST['give_auv'], 1);
	ProcessMF("arm1", $_POST['give_arm1'], 1);
	ProcessMF("arm2", $_POST['give_arm2'], 1);
	ProcessMF("arm3", $_POST['give_arm3'], 1);
	ProcessMF("arm4", $_POST['give_arm4'], 1);
	ProcessMF("mindmg", $_POST['give_mindmg'], 1);
	ProcessMF("maxdmg", $_POST['give_maxdmg'], 1);

	$ok = 1;

	for ($i = 0; $i < $rudacount; $i++)
	{
		$sumneed += $ruda_get[$i] * $_POST['met_'.$i];
		$sumhave += $ruda_give[$i]* $_POST['met_'.$i];

		if ( GetRudaCount($ruda_id[$i]) < $_POST['met_'.$i] )
		{
			$err = 'У вас нет столько руды '.$ruda_name[$i];
			$ok  = 0;
		}
	}


	if ( !empty($ok) )
	{
		if ( empty($summf) || $summf==0 || $summf > $sumhave || $sumget < $sumneed )
		{
			$err = 'Неверная сумма... Попытайтесь ещё раз';
		}
		else
		{			$smithLevel = GetSmithLevel();
			$multiplic  = floor((100*$summf)/(($smithLevel+1)*$multsmith));
			$multiplic2 = floor( ($smithLevel+1) * $multsmith / $summf );

			$minWear    = min( 9, max( $smithLevel, $multiplic2 ) );
			$maxWear    = max( 9, $multiplic2 );

			$rand       = rand( $minWear, $maxWear );

			if( $rand < 10 )
			{				for( $i = 0; $i < $rudacount; $i++ )
				{					$metallFailure = 0;
					$cnt           = intval($_POST['met_'.$i]);
					$metallFailure = round( $cnt * ($smithFailureFactor/100) );

					if( $metallFailure > 0 )
					{						$db->update( SQL_PREFIX.'metall_store', Array( 'Count' => '[-]'.$metallFailure ), Array( 'Player' => $player->username, 'Metall' => $ruda_id[$i] ), 'maths' );
						$msgFail[] = $ruda_name[$i]." - ".$metallFailure;
					}
				}

				$err = 'К сожалению, вещь не удалась.<br /> Вы потеряли: '.implode( ", ", $msgFail).'.';

			} else{

                $_POST['weap_name'] = iconv('utf-8', 'windows-1251', $_POST['weap_name']);
				$_POST['weap_name'] = preg_replace("/артефакт/i",'',$_POST['weap_name']);
				$_POST['weap_name'] = htmlspecialchars($_POST['weap_name']);
				$_POST['weap_name'] = substr($_POST['weap_name'], 0 , 30);


                $db->insert( SQL_PREFIX.'things',
                Array( 'Owner' => $player->username, 'Id' => $thing_tpl[$_POST['tpl_num']]['image'],
                'Thing_Name' => $_POST['weap_name'].'(made by '.$player->username.')',
                'Slot' => $thing_tpl[$_POST['tpl_num']]['slot'], 'Cost' => 0,
                'Level_need' => $weap_get['level'],
                'Stre_need'  => $weap_get['str'],
                'Agil_need'  => $weap_get['agil'],
                'Intu_need'  => $weap_get['intu'],
                'Endu_need'  => $weap_get['endu'],
                'Stre_add'   => $weap_mf['str'],
                'Agil_add'   => $weap_mf['agil'],
                'Intu_add'   => $weap_mf['intu'],
                'Endu_add'   => $weap_mf['endu'],
                'MINdamage'  => $weap_mf['mindmg'],
                'MAXdamage'  => $weap_mf['maxdmg'],
                'Crit'       => $weap_mf['crit'],
                'AntiCrit'   => $weap_mf['acrit'],
                'Uv'         => $weap_mf['uv'],
                'AntiUv'     => $weap_mf['auv'],
                'Armor1' => $weap_mf['arm1'], 'Armor2' => $weap_mf['arm2'], 'Armor3' => $weap_mf['arm3'], 'Armor4' => $weap_mf['arm4'],
                'NOWwear' => 0, 'MAXwear' => $rand ) );


				$db->update( SQL_PREFIX.'smith', Array( 'Exp' => '[+]'.$multiplic ), Array( 'Player' => $player->username ), 'maths' );

				$err = 'Успешно создана вещь "'.$_POST['weap_name'].'(made by '.$player->username.')". Получено опыта: '.$multiplic;

				for ( $i = 0; $i < $rudacount; $i++ )
				{
					$cnt = intval($_POST['met_'.$i]);
					$db->update( SQL_PREFIX.'metall_store', Array( 'Count' => '[-]'.$cnt ), Array( 'Player' => $player->username, 'Metall' => $ruda_id[$i] ), 'maths' );
				}
			}
		}
	}
	}
}
?>
<div id="mb-send-link">
  <?=$err;?>
  <p><input type="button" value="Закрыть" onclick="Modalbox.hide();" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';" /></p>
</div>