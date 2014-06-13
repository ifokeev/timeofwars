<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

header('Content-type: text/html; charset=windows-1251');
require_once ('db_config.php');
require_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('cl');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$player->heal();

$page = !isset($_GET['page']) && !isset($_SESSION['page']) ? 'request' : (isset($_GET['page']) ? $_GET['page'] : $_SESSION['page']);
$_SESSION['page'] = $page;

function in_multi_array($needle, $haystack)
{
    $in_multi_array = false;
    if(in_array($needle, $haystack))
    {
        $in_multi_array = true;
    }
    else
    {
        for($i = 0; $i < sizeof($haystack); $i++)
        {
            if(is_array($haystack[$i]))
            {
                if(in_multi_array($needle, $haystack[$i]))
                {
                    $in_multi_array = true;
                    break;
                }
            }
        }
    }
    return $in_multi_array;
}


require_once ('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

include_once ('classes/clan/ClanRanks.php');

if( !empty($player->id_rank) ) $acclev = @split( ',', $db->SQL_result($db->query( "SELECT perms FROM ".SQL_PREFIX."clan_ranks WHERE id_clan = '".$player->id_clan."' AND id_rank = '".$player->id_rank."';" )) );

$temp->assign( 'username', $player->username );
if( !empty($_SESSION['page']) && $_SESSION['page'] == 'request' )
{	if( (!empty($acclev) && in_array( 'request', $acclev )) || $player->admin == 1 )
	{		$temp->assign( 'rules', true );
		$temp->assign( 'demands', $db->queryArray("SELECT cd.Username, p.Id, p.Level, cu.id_clan as ClanID, c.id_clan, c.join_price, cd.text FROM ".SQL_PREFIX."clan_demands cd LEFT JOIN ".SQL_PREFIX."players p ON (p.Username=cd.Username) LEFT JOIN ".SQL_PREFIX."clan c ON (c.id_clan = cd.id_clan) LEFT JOIN ".SQL_PREFIX."clan_user cu ON (cu.Username = cd.Username) WHERE cd.id_clan = '".$player->id_clan."';") );
    }

}

if( !empty($_SESSION['page']) && $_SESSION['page'] == 'align' )
{
	if( (!empty($acclev) && in_array( 'align', $acclev )) || $player->admin == 1 )
	{
		$temp->assign( 'rules', true );

    }

}

if( !empty($_SESSION['page']) && $_SESSION['page'] == 'rank' )
{
	if( (!empty($acclev) && in_array( 'rank', $acclev )) || $player->admin == 1 )
	{
		$temp->assign( 'rules', true );
		$temp->assign( 'rankall', $db->queryArray( "SELECT * FROM ".SQL_PREFIX."clan_ranks WHERE id_clan = '".$player->id_clan."';" )  );

    }

}


if( !empty($_SESSION['page']) && $_SESSION['page'] == 'members' )
{
	if( (!empty($acclev) && in_array( 'members', $acclev )) || $player->admin == 1 )
	{
		$temp->assign( 'rules', true );
        $temp->assign( 'rankall', $db->queryArray( "SELECT * FROM ".SQL_PREFIX."clan_ranks WHERE id_clan = '".$player->id_clan."';" )  );
        $temp->assign( 'leftp', @$db->SQL_result($db->query("SELECT left_price FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player->id_clan."';")) );
    }

    $temp->assign( 'members', $db->queryArray( "SELECT o.Username as isonline, p.Username, p.Id, p.Level, cu.id_rank, cu.id_clan as ClanID, cu.tax, cr.rank_name FROM ".SQL_PREFIX."clan_user cu LEFT JOIN ".SQL_PREFIX."clan_ranks cr ON (cr.id_rank=cu.id_rank) LEFT JOIN ".SQL_PREFIX."players p ON(p.Username = cu.Username) LEFT JOIN ".SQL_PREFIX."online o ON(o.Username = p.Username) WHERE cu.id_clan = '".$player->id_clan."';" )  );
    $temp->assign( 'goout', $db->queryArray( "SELECT cg.*, p.Id FROM ".SQL_PREFIX."clan_goout cg LEFT JOIN ".SQL_PREFIX."players p ON(cg.Username = p.Username) WHERE cg.id_clan = p.ClanID AND p.ClanID = '".$player->id_clan."';" ) );

}



if( !empty($_SESSION['page']) && $_SESSION['page'] == 'setup' )
{	if( (!empty($acclev) && in_array( 'setup', $acclev )) || $player->admin == 1 )
	{		$temp->assign( 'setup', true );
    }	if( (!empty($acclev) && in_array( 'kazna', $acclev )) || $player->admin == 1 )
	{
		$temp->assign( 'kazna', true );
		$temp->assign( 'm_demand', $db->queryArray( "SELECT * FROM ".SQL_PREFIX."clan_demands_m WHERE id_clan = '".$player->id_clan."';") );

    }

    $temp->assign( 'info', $db->queryRow("SELECT advert, slogan, link FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player->id_clan."'") );
    $temp->assign( 'money', $db->SQL_result($db->query("SELECT kazna FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player->id_clan."';")) );

}


if( !empty($_SESSION['page']) && $_SESSION['page'] == 'weapons' )
{    if( (!empty($acclev) && in_array( 'weapon', $acclev )) || $player->admin == 1 )
	{
		$temp->assign( 'rules', true );
		$temp->assign( 'alldemands', $db->queryArray("SELECT cd.id_item, cd.Username, cd.addTime, cd.status, t.Thing_Name FROM ".SQL_PREFIX."clan_weapon_demands cd LEFT JOIN ".SQL_PREFIX."clan_weapon_items ci ON(ci.id_item = cd.id_item) LEFT JOIN ".SQL_PREFIX."things t ON(t.Un_Id = ci.id_item) WHERE ci.id_clan = '".$player->id_clan."' AND cd.status IS NULL;") );
    }

    $temp->assign( 'u_demands', $db->queryArray("SELECT cd.id_item, cd.Username, cd.addTime, cd.status FROM ".SQL_PREFIX."clan_weapon_demands cd LEFT JOIN ".SQL_PREFIX."clan_weapon_items as ci ON(cd.id_item = ci.id_item) WHERE cd.Username = '".$player->username."' AND ci.id_clan = '".$player->id_clan."' AND ci.location = 'STORE';") );


}


if( !empty($_SESSION['page']) && $_SESSION['page'] == 'history' )
{
    if( (!empty($acclev) && in_array( 'weapon', $acclev )) || $player->admin == 1 )
	{
		$temp->assign( 'rules', true );
    }
}

$temp->assign( 'ClanID', $player->id_clan );

if( empty($player->id_clan) )
{	$temp->assign( 'mydemand', $db->queryRow("SELECT c.id_clan, c.name FROM ".SQL_PREFIX."clan_demands cd LEFT JOIN ".SQL_PREFIX."clan c ON( c.id_clan = cd.id_clan ) LEFT JOIN ".SQL_PREFIX."players p ON(p.Username = cd.Username) WHERE cd.Username = '".$player->username."';" ) );	$temp->assign( 'clanList', $db->queryArray("SELECT id_clan, title, type, join_price, left_price, slogan, advert, link FROM ".SQL_PREFIX."clan ORDER BY type DESC, title;") );
}


$temp->assign( 'requestPage', $_SESSION['page'] );


$temp->addTemplate('cl', 'timeofwars_loc_cl.html');


$show =& $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - клановая комната');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>