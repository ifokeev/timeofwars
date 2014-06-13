<?
class clanInfo{
private $idClan     = '';
private $username   = '';
private $warClan    = '';
private $clanLink   = '';
private $clanSlogan = '';
private $clanType   = '';
public $clanTitle   = '';
public $clanRank    = '';

function __construct(){ }

function GetCLanInfo($idClan, $username){
global $db;


$this->idClan   = $idClan;
$this->username = $username;

$clanInfo = $db->queryRow("SELECT title, type, slogan, link FROM ".SQL_PREFIX."clan WHERE id_clan = '".$this->idClan."'");
$id_rank  = @$db->SQL_result($db->query("SELECT id_rank FROM ".SQL_PREFIX."clan_user WHERE Username = '".$this->username."' AND id_clan = '".$this->idClan."'"));
$rank     = @$db->SQL_result($db->query("SELECT rank_name FROM ".SQL_PREFIX."clan_ranks WHERE id_rank = '".$id_rank."'"));

$this->clanRank   = $rank;
$this->clanSlogan = $clanInfo['slogan'];
$this->clanTitle  = $clanInfo['title'];

if ($clanInfo['link'] == '') { $this->clanLink = ''; }
else {                         $this->clanLink = '<b><a href="'.$clanInfo['link'].'" target="_blank">Клановый сайт</a></b><br>'; }


if ($clanInfo['type'] == 'ASTRAL') { $this->clanType = '<i>Хранитель</i><br>'; }
else {                               $this->clanType = ''; }

if(!empty($this->clanSlogan)){ $this->clanSlogan = '<b>'.$this->clanSlogan.'</b><br>'; }
else {                         $this->clanSlogan = ''; }

echo $this->clanType.'<b></small>'.$this->clanTitle.'</b><small><br>'.$this->clanSlogan.$this->clanLink;

}

function GetWarClans($idClan){
global $db, $db_config;

$this->idClan = $idClan;

$dat = $db->queryArray("SELECT id_clan_to FROM ".SQL_PREFIX."clan_relations WHERE id_clan_from = '".$this->idClan."' AND relation_type = 'WAR'");
$ret = '';

if(!empty($dat))
{
	$ret = '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/war.gif">&nbsp;&nbsp;';
	$i = 0;
	foreach($dat as $k => $warClans)
	{		$i++;
		$ret .= '<a href="top5.php?show='.$warClans['id_clan_to'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$warClans['id_clan_to'].'.gif"></a>&nbsp;';
        if( $i%4 == 0 ) $ret .= '<br />';
    }
}

return $ret;

}


function GetPeaceClans($idClan){
global $db, $db_config;

$this->idClan = $idClan;

$dat = $db->queryArray("SELECT id_clan_to FROM ".SQL_PREFIX."clan_relations WHERE id_clan_from = '".$this->idClan."' AND relation_type = 'PEACE'");
$ret = '';
if(!empty($dat))
{
	$ret = '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/pease.gif">&nbsp;&nbsp;';
	$i = 0;
	foreach($dat as $k => $peaceClans)
	{		$i++;
		$ret .= '<a href="top5.php?show='.$peaceClans['id_clan_to'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$peaceClans['id_clan_to'].'.gif"></a>&nbsp;';
        if( $i%4 == 0 ) $ret .= '<br />';
    }
}

return $ret;

}

function GetAllianceClans($idClan){
global $db, $db_config;

$this->idClan = $idClan;

$dat = $db->queryArray("SELECT id_clan_to FROM ".SQL_PREFIX."clan_relations WHERE id_clan_from = '".$this->idClan."' AND relation_type = 'ALLIANCE'");
$ret = '';

if(!empty($dat))
{
	$ret = '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/alliance.gif">&nbsp;&nbsp;';
	$i = 0;
	foreach($dat as $k => $allianceClans)
	{		$i++;
		$ret .= '<a href="top5.php?show='.$allianceClans['id_clan_to'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$allianceClans['id_clan_to'].'.gif"></a>&nbsp;';
        if( $i%4 == 0 ) $ret .= '<br />';
    }


}

return $ret;

}



}
?>
