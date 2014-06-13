<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);


include_once('../db_config.php');
include_once('../db.php');

 $db->writeCache( $db->queryArray( "SELECT cu.id_clan, SUM(b.Damage) as sumdmg, c.title FROM ".SQL_PREFIX."battle_list as b INNER JOIN ".SQL_PREFIX."clan_user as cu ON ( cu.Username = b.Player ) LEFT JOIN ".SQL_PREFIX."clan as c ON( c.id_clan = cu.id_clan ) WHERE cu.id_clan != '99' GROUP BY cu.id_clan ORDER BY sumdmg DESC"),  $db_config[DREAM]['web_root'].'/cache/top5/top5_toplist_'.date('Ymd') );


 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."players p LEFT OUTER JOIN ".SQL_PREFIX."top5_exclude t ON(t.Username = p.Username) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) LEFT JOIN ".SQL_PREFIX."blocked as bl ON (bl.Username = p.Username) WHERE p.Won > p.Lost AND t.Username IS NULL AND bl.Username IS NULL AND p.ClanID != '99' ORDER BY p.Won-p.Lost DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostDiff_1' );

 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."players p LEFT OUTER JOIN ".SQL_PREFIX."top5_exclude t ON(t.Username = p.Username) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) LEFT JOIN ".SQL_PREFIX."blocked as bl ON (bl.Username = p.Username) WHERE t.Username IS NULL AND p.ClanID != '99' AND bl.Username IS NULL ORDER BY p.Won+p.Lost DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostSum_1' );

 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."players p LEFT OUTER JOIN ".SQL_PREFIX."top5_exclude t ON(t.Username = p.Username) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) LEFT JOIN ".SQL_PREFIX."blocked as bl ON (bl.Username = p.Username) WHERE p.Won > p.Lost AND t.Username IS NULL AND p.ClanID != '99' AND bl.Username IS NULL ORDER BY p.Won / p.Lost DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostPerc_1' );

 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."players p LEFT OUTER JOIN ".SQL_PREFIX."top5_exclude t ON(t.Username = p.Username) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) LEFT JOIN ".SQL_PREFIX."blocked as bl ON (bl.Username = p.Username) WHERE t.Username IS NULL AND p.ClanID != '99' AND bl.Username IS NULL ORDER BY (p.Stre + p.Agil + p.Intu + p.Endu) DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top_get_stSUM_1' );


$templ = "SELECT p.Username, p.Level, p.Align, cu.id_clan FROM ".SQL_PREFIX."karma k INNER JOIN ".SQL_PREFIX."players p ON(p.Username = k.Username) LEFT OUTER JOIN ".SQL_PREFIX."top5_exclude t ON(t.Username = p.Username) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) LEFT JOIN ".SQL_PREFIX."blocked as bl ON (bl.Username = p.Username)  WHERE t.Username IS NULL AND bl.Username IS NULL ORDER BY k.Count %s LIMIT 10";

$query = sprintf( $templ, 'ASC' );
 $db->writeCache( $db->queryArray($query), $db_config[DREAM]['web_root'].'/cache/top5/top5_getKarmaMinus_1' );


$query = sprintf( $templ, 'DESC' );
 $db->writeCache( $db->queryArray($query), $db_config[DREAM]['web_root'].'/cache/top5/top5_getKarmaPlus_1' );



 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."smith s INNER JOIN ".SQL_PREFIX."players p ON( p.Username = s.Player ) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) ORDER BY s.Exp DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top_get_smithlevel' );

 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."mines s INNER JOIN ".SQL_PREFIX."players p ON( p.Username = s.Player ) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) ORDER BY s.Exp DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top5_get_mineslevel' );

 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."casino c INNER JOIN ".SQL_PREFIX."players p ON( p.Username = c.Username ) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) ORDER BY c.Price DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top5_get_casino' );




////нг
 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."elka_reit c INNER JOIN ".SQL_PREFIX."players p ON( p.Username = c.Username ) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) ORDER BY c.vetki DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top5_get_best_vetki' );

 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."elka_reit c INNER JOIN ".SQL_PREFIX."players p ON( p.Username = c.Username ) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) ORDER BY c.toys DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top5_get_best_toys' );

 $db->writeCache( $db->queryArray("SELECT p.Username, p.Level, cu.id_clan FROM ".SQL_PREFIX."elka_reit_presents c INNER JOIN ".SQL_PREFIX."players p ON( p.Username = c.podarok_for_user ) LEFT JOIN ".SQL_PREFIX."clan_user cu ON(cu.Username = p.Username) GROUP BY c.podarok_for_user ORDER BY COUNT(*) DESC LIMIT 10"), $db_config[DREAM]['web_root'].'/cache/top5/top5_get_best_presents' );

////


$templ = "SELECT c.id_clan, c.title, COUNT(cu.Username) as cnt, SUM(p.Level) as sLevel, MAX(p.Level) as mLevel, AVG(p.Level) as aLevel FROM ".SQL_PREFIX."clan c INNER JOIN ".SQL_PREFIX."clan_user cu ON (cu.id_clan=c.id_clan) INNER JOIN ".SQL_PREFIX."players p ON (p.Username=cu.Username) %s GROUP BY c.id_clan";
$query = sprintf( $templ, "" );
$query = $db->queryArray($query);

if( !empty($query) )
{
	foreach($query as $clan)
	{
		$clanlist = sprintf( "SELECT p.Username, p.Level, p.Align, p.Won, p.Lost, cu.id_clan FROM ".SQL_PREFIX."clan_user cu INNER JOIN  ".SQL_PREFIX."players p ON(p.Username = cu.Username) WHERE cu.id_clan = '%d' ORDER BY p.Level DESC", $clan['id_clan'] );

		$db->writeCache( $db->queryArray($clanlist), $db_config[DREAM]['web_root'].'/cache/top5/top5_getClanList_'.$clan['id_clan'] );

    }
}


$query = sprintf( $templ, "WHERE c.type = 'ASTRAL'" );
$db->writeCache( $db->queryArray($query), $db_config[DREAM]['web_root'].'/cache/top5/top5_getAstrals_1' );


$query = sprintf( $templ, "WHERE c.type = 'CLAN'" );
$db->writeCache( $db->queryArray($query), $db_config[DREAM]['web_root'].'/cache/top5/top5_getClans_1' );
?>