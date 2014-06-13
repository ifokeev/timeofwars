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
$player->checkRoom('smith');

if(!empty($_GET['goto']) && $_GET['goto'] == 'mines' ){
$player->gotoRoom( 'mines', 'mines' );
}

include_once 'mines.inc';


function GetSmithLevel(){
global $db, $player, $baseexp, $multexp;

$exp   = @$db->SQL_result($db->query("SELECT Exp FROM ".SQL_PREFIX."smith WHERE Player = '".$player->username."'"));
$exp2  = ( (max(1, $exp) ) / $baseexp );
$level = floor( Log10($exp2)/Log10($multexp) );
$level++;
if ($level<0){$level=0;}
return $level;

}


function GetNextLevelExp(){
global $db, $player, $baseexp, $multexp;

$exp      = @$db->SQL_result($db->query("SELECT Exp FROM ".SQL_PREFIX."smith WHERE Player = '".$player->username."'"));
$curlevel = GetSmithLevel();
return intval($baseexp * ( pow($multexp, $curlevel) ));

}


function PrintMetallFunctionTable(){
global $rudacount, $ruda_name, $ruda_give, $ruda_get, $ruda_repair;

$s = '<table cellpadding="5" cellspacing="5" width="100%" height="100%" align="center" valign="top" border="1"><tr><td>Металл</td><td>Даёт единиц</td><td>Берёт единиц</td><td>Единиц ремонта</td></tr>';

for ($i=0;$i<$rudacount;$i++)
{
	$s .= '<tr><td>'.$ruda_name[$i].'</td><td>'.$ruda_give[$i].'</td><td>'.$ruda_get[$i].'</td><td>'.$ruda_repair[$i].'</td></tr>';
}

$s.= "</table>";

return $s;
}


function PrintPriceSingle($name, $price, $t1, $t2){
$s='<tr><td >'.$name.'</td><td >'.$price.'</td><td >'.($t1 == 'Нет' ? 'Нет' : 'Да').'</td><td >'.($t2 == 'Нет' ? 'Нет' : 'Да').'</td>';
return $s;
}


function PrintPrice(){
global $price;

$s  = '<table cellpadding="1" cellspacing="1" width="100%" height="100%" align="center" valign="top" border="1"><tr><td >Наименовние</td><td >Цена</td><td >В модификаторах</td><td >В требованиях</td></tr>';
$s .= PrintPriceSingle("Уровень",$price["level"],0,1);
$s .= PrintPriceSingle("Сила",$price["str"],1,1);
$s .= PrintPriceSingle("Ловкость",$price["agil"],1,1);
$s .= PrintPriceSingle("Интуиция",$price["intu"],1,1);
$s .= PrintPriceSingle("Выносливость(+hp)",$price["endu"],1,1);
$s .= PrintPriceSingle("Мф. крита",$price["crit"],1,0);
$s .= PrintPriceSingle("Мф. антикрита",$price["acrit"],1,0);
$s .= PrintPriceSingle("Мф. уворота",$price["uv"],1,0);
$s .= PrintPriceSingle("Мф. антиуворота",$price["auv"],1,0);
$s .= PrintPriceSingle("Броня головы",$price["arm1"],1,0);
$s .= PrintPriceSingle("Броня корпуса",$price["arm2"],1,0);
$s .= PrintPriceSingle("Броня пояса",$price["arm3"],1,0);
$s .= PrintPriceSingle("Броня ног",$price["arm4"],1,0);
$s .= PrintPriceSingle("Мин. повреждение",$price["mindmg"],1,0);
$s .= PrintPriceSingle("Макс. повреждение",$price["maxdmg"],1,0);
$s .='</table>';
return $s;

}


function GetRudaCount($id){
global $db, $player;
return (int)@$db->SQL_result($db->query("SELECT Count FROM ".SQL_PREFIX."metall_store WHERE Player = '".$player->username."' AND Metall = '".$id."';"));
}



require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$table = '<table cellpadding="5" cellspacing="5" width="100%" height="100%" align="center" valign="top" border="1"><tr><td>Металл</td><td>В наличии</td></tr>';
for ($i=0;$i<$rudacount;$i++){

	$table .= '<tr><td>'.$ruda_name[$i].'</td><td>'.GetRudaCount($ruda_id[$i]).'</tr>';
}
$table .= '</table>';

$temp->assign('rudsTable',$table);

$temp->assign('table_metalls', PrintMetallFunctionTable());
$temp->assign('table_price', PrintPrice());


$temp->assign('thing_tpl', $thing_tpl);


$temp->assign('exp', max( 0, $exp = @$db->SQL_result($db->query( "SELECT Exp FROM ".SQL_PREFIX."smith WHERE Player = '".$player->username."';")) ) );
$temp->assign('newexp', GetNextLevelExp());
$temp->assign('smith_level', GetSmithLevel());



$temp->addTemplate('smith', 'timeofwars_loc_smith.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - Кузница');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>