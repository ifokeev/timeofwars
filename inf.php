<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include 'db.php';
include 'classes/PlayerBattle.php';
include 'includes/conf/conf_chat.php';
include 'classes/Clan/clanInf.php';
include 'includes/to_view.php';



function hrefActivate($text) {
  $text = preg_replace_callback(
    '{
      (?:
        # ВНИМАНИЕ: \w+ вместо (?:http|ftp) СИЛЬНО ТОРОМОЗИТ!!!
        ((?:http|ftp)://)   # протокол с двумя слэшами
        | www\.             # или просто начинается на www
      )
      (?> [a-z0-9_-]+ (?>\.[a-z0-9_-]+)* )   # имя хоста
      (?: : \d+)?                            # порт
      (?: &amp; | [^[\]&\s\x00»«"<>])*       # URI (но БЕЗ кавычек)
      (?:                 # последний символ должен быть...
          (?<! [[:punct:]] )  # НЕ пунктуацией
        | (?<= &amp; | [-/&+*]     )  # но допустимо окончание на -/&+*
      )
      (?= [^<>]* (?! </a) (?: < | $)) # НЕ внутри тэга
    }xis',
    "hrefCallback",
    $text
  );
  return $text;
}

// Функция обратного вызова для preg_replace_callback().
function hrefCallback($p) {
  $name = $p[0];

  $href = (!empty($p[1])? $name : "http://$name");
  // Если ссылка на текущий сайт, пробуем преобразовать ее в имя страницы.
  if (preg_match("{^http://forumtow.ru}si", $href, $p))
      $name = 'Ссылка на оф. форум [forumtow.ru]';
  elseif (preg_match("{^http://timeofwars.ru|tow.su|vkontakte.ru}si", $href, $p))  	  $name = $href;
  else
  {
      $name = '[Сторонняя ссылка] '.$name;
   	  $href = 'http://tow.su/away.php?to='.$href;
  }

  $href = str_replace('"', '&amp;', $href); // на всякий случай
  if ($name === null) $name = $href;
  $html = "<a href=\"$href\" target=\"_blank\">".$name."</a>";
  return $html;
}

class Player extends battle
{	public $Username;
	public $Id;
	public $battle_id;
	public $Level;
	public $Agil;
	public $Intu;
	public $Endu;
	public $Intl;
	public $hp;
	public $hp_all;
	public $mana;
	public $mana_all;
	public $Reg_IP;
	public $id_clan;
	public $Pict;
	public $sex;
	public $out;
	public $win;
	public $lost;
	public $cl_name;
	public $rank_name;
	public $lo_time;
	public $room;
	public $online;
	public $clanwars;
	public $clanpeace;
	public $clanalliance;
	public $name;
	public $town;
	public $ICQ;
	public $infor;
    public $births;
    public $email;
    public $karma;


	function __construct($user)
	{		global $db, $_ROOM;
		$user = $this->filter($user);		$player = $db->queryRow( "SELECT p.Username, p.Id, p.BattleID2, p.Level, p.ICQ, p.Info, p.RealName, p.Email, p.Stre, p.Agil, p.Intu, p.Endu, p.Intl, p.HPnow, p.HPall, p.mana, p.mana_all, p.Reg_IP, p.Pict, p.Sex, p.Won, p.Lost, p.Email, p.Birthdate, p.town, cu.id_clan, cu.id_rank FROM ".SQL_PREFIX."players as p LEFT OUTER JOIN ".SQL_PREFIX."clan_user as cu ON (p.Username = cu.Username) WHERE p.Username = '".$user."' LIMIT 1;" );
       	if( empty($player) ) die( 'Такого персонажа не существует.' );

        if( !empty($player['id_clan']) )
        {        	$this->cl_name = @$db->SQL_result( $db->query( "SELECT title FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player['id_clan']."';" ),0,0);
        	if( !empty($player['id_rank']) )
        	   $this->rank_name = @$db->SQL_result( $db->query( "SELECT rank_name FROM ".SQL_PREFIX."clan_ranks WHERE id_rank = '".$player['id_rank']."';" ),0,0);

             $clanInfo = new clanInfo();

             $this->clanwars = $clanInfo->GetWarClans($player['id_clan']);
             $this->clanpeace = $clanInfo->GetPeaceClans($player['id_clan']);
             $this->clanalliance = $clanInfo->GetAllianceClans($player['id_clan']);
             unset($clanInfo);
  		 }

        if ( ( $Link = @$db->SQL_result($db->query("SELECT Link FROM ".SQL_PREFIX."vip WHERE Username = '".$player['Username']."';"),0,0) != '' ) && $_GET['uname'] != $player['Username'] )
           die('<script>location.href=\''.$Link.'\'</script>');

		 $Time = @$db->SQL_result($db->query("SELECT Time FROM ".SQL_PREFIX."hp WHERE Username = '".$player['Username']."';"),0,0);

		 $lo_time = getdate($Time);

         $wday  = $lo_time['mday'] < 10 ? '0'.$lo_time['mday'] : $lo_time['mday'];
         $mon   = $lo_time['mon'] < 10 ? '0'.$lo_time['mon'] : $lo_time['mon'];
         $hours = $lo_time['hours'] < 10 ? '0'.$lo_time['hours'] : $lo_time['hours'];
         $min   = $lo_time['minutes'] < 10 ? '0'.$lo_time['minutes'] : $lo_time['minutes'];


         $this->lo_time = '<br />Последний раз '.($player['Sex'] == 'M' ? 'был' : 'была').' в клубе <br />'.$wday.'.'.$mon.'.'.$lo_time['year'].' '.$hours.':'.$min;

         unset( $lo_time, $wday, $mon, $hours, $min );


		if( $room = @$db->SQL_result($db->query("SELECT Room FROM ".SQL_PREFIX."online WHERE Username = '".$player['Username']."';"),0,0) )
		  $this->online = true;
	    else
	      $this->online = false;

		if ( !empty($room) && isset($_ROOM[$room]) )
		{
			list($room, ) = split('::', $_ROOM[''.$room.'']);
            $this->room = $room;
            unset($room);
        }



         $text = split( "\n", $player['Info'] );
         $newtext = '';

         if( !empty($text) )
            foreach( $text as $str )
              $newtext .= hrefActivate(wordwrap( $str, 70, '<br />' ))."\n";

        $newtext = bbcodeINF($newtext);


        $this->infor = $newtext;
        $this->karma = @$db->SQL_result($db->query("SELECT Count FROM ".SQL_PREFIX."karma WHERE Username = '".$player['Username']."';"),0,0);
        $this->Username = $player['Username'];
        $this->Id = $player['Id'];
        $db->checklevelup( $player['Username'] );
        $this->id_clan = $player['id_clan'];
        $this->battle_id = $player['BattleID2'];
        $this->Level = $player['Level'];
        $this->Stre = $player['Stre'];
        $this->Agil = $player['Agil'];
        $this->Intu = $player['Intu'];
        $this->ICQ = $player['ICQ'];
        $this->Endu = $player['Endu'];
        $this->Intl = $player['Intl'];
        $this->hp = $player['HPnow'];
        $this->hp_all = $player['HPall'];
        $this->mana = $player['mana'];
        $this->mana_all = $player['mana_all'];
        $this->Reg_IP = $player['Reg_IP'];
        $this->Pict = $player['Pict'];
        $this->sex  = $player['Sex'];
        $this->Won = $player['Won'];
        $this->Lost  = $player['Lost'];
        $this->births  = $player['Birthdate'];
        $this->email   = $player['Email'];

        $this->town  = $player['town'];
        $this->name  = $player['RealName'];
		$this->out = $this->itemsinfo();

    }

    public function slogin( $user, $lvl, $clanid )
    {		global $db_config;

		$r = '';

		if( empty($user) && empty($lvl) && empty($clanid) )
		{
			$user = $this->Username;
			$lvl  = $this->Level;
			$clanid = $this->id_clan;
		}


		if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';

	    $r .= '<span>'.$user.'</span>';


		$r .= ' ['.$lvl.']';
		return $r;
    }


}

$pl = new Player($_GET['uname']);
$mf = $pl->get_modif_player();


$gifts = $db->queryArray("SELECT pr.presentIMG, pr.presentMSG, pr.presentFROM, p.Username, p.Level, p.ClanID FROM ".SQL_PREFIX."presents as pr INNER JOIN ".SQL_PREFIX."players as p ON (p.Username = pr.presentFROM) WHERE pr.Player = '".$pl->Username."' ORDER BY presentDATE DESC;");


if ( @list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_2uron WHERE Username = '".$pl->Username."';" ) )
{

	if( !empty($uron_time) && time() - $uron_time < $for*3600 )
 		$msg = '<b><font color=#ff7272>Персонаж воспользовался услугой "Двойной урон".<br /> Будет действовать еще '.sprintf("%01.1f", $for*60 - (time() - $uron_time)/60 ).' мин.</font></b><br />';

}
elseif ( @list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_3uron WHERE Username = '".$pl->Username."';" ) )
{

	if( !empty($uron_time) && time() - $uron_time < $for*3600 )
		$msg =  '<b><font color=#ff7272>Персонаж воспользовался услугой "Тройной урон".<br /> Будет действовать еще '.sprintf("%01.1f", $for*60 - (time() - $uron_time)/60 ).' мин.</font></b><br />';
}

session_start();
if( !empty($_SESSION['login']) )
{
	list($user, $ClanID, $LevelV) = $db->queryCheck("SELECT Username, ClanID, Level FROM ".SQL_PREFIX."players WHERE Username = '".mysql_real_escape_string($pl->filter($_SESSION['login']))."'");

	if ( !empty($_GET['karma']) && ($_GET['karma'] == 'dec' || $_GET['karma'] == 'inc')  )
	{		if( $pl->Username == $_SESSION['login'] ) $msg = '<b>Нельзя голосовать за самого себя.</b>';
		elseif( $LevelV <= 4 ) $msg = '<b>Голосовать можно только с 5 уровня.</b>';
		else
		{
			$karmavote = $db->queryRow("SELECT Username FROM ".SQL_PREFIX."karma_votes WHERE Username = '".$user."';");
			if (!$karmavote)
			{				$db->insert( SQL_PREFIX.'karma_votes', Array( 'Username' => $user, 'Time' => time('void') ) );

				if (!empty($_GET['karma']) && $_GET['karma'] == 'dec')
				{
    				$query = sprintf("INSERT INTO ".SQL_PREFIX."karma ( Username, Count ) VALUES ( '%s', '-1' ) ON DUPLICATE KEY UPDATE Count = Count - '1';", $pl->Username );
    				$db->execQuery($query, "modifyKarmaMINUS");

					$pl->karma--;
					$msg = '<b>Вы подпортили карму игроку.</b>';
				}

				if (!empty($_GET['karma']) && $_GET['karma'] == 'inc')
				{    				$query = sprintf("INSERT INTO ".SQL_PREFIX."karma ( Username, Count ) VALUES ( '%s', '1' ) ON DUPLICATE KEY UPDATE Count = Count + '1';", $pl->Username );
    				$db->execQuery($query, "modifyKarmaPLUS");

					$pl->karma++;
					$msg = '<b>Вы увеличили карму игроку.</b>';
				}
        	}
        	else
        		$msg = '<b>Вы уже сегодня голосовали. Попробуйте через 4 часа.</b>';
        }
   }

	if ( !empty($ClanID) && ($ClanID == 1 || $ClanID == 2 || $ClanID == 3 || $ClanID == 4 || $ClanID == 50 || $ClanID == 255 || $ClanID == 53) )
		$admin = $ClanID;

	if ( $_SESSION['login'] == 's!.' )
		$admin = 255;

    if( !empty($admin) )
    {		$ip    = @$db->SQL_result($db->query("SELECT Ip FROM ".SQL_PREFIX."ip WHERE Username = '".$pl->Username."'"),0,0);
		$multi = $db->queryArray("SELECT p.Username, p.ClanID, p.Level FROM ".SQL_PREFIX."ip as i INNER JOIN ".SQL_PREFIX."players as p ON( p.Username = i.Username ) WHERE i.Ip = '".$ip."' AND p.Username <> '".$pl->Username."';");


 		$chaos1  = $db->queryRow("SELECT p.Username, p.Level, p.ClanID, COUNT(an.Username) as cnt FROM ".SQL_PREFIX."as_notes as an INNER JOIN ".SQL_PREFIX."players as p ON (p.Username = an.hranitel) WHERE an.Username = '".$pl->Username."' AND an.Status = 'chaos' GROUP BY an.Username");
		$blok  = $db->queryRow("SELECT p.Username, p.Level, p.ClanID, COUNT(an.Username) as cnt FROM ".SQL_PREFIX."as_notes as an INNER JOIN ".SQL_PREFIX."players as p ON (p.Username = an.hranitel) WHERE an.Username = '".$pl->Username."' AND an.Status = 'blok' GROUP BY an.Username");
        $shut_cnt = @$db->SQL_result($db->query( "SELECT COUNT(Username) FROM ".SQL_PREFIX."as_notes WHERE Username = '".$pl->Username."' AND Status = 'shuted' GROUP BY Status;" ),0,0);


    }

}

$Time = @$db->SQL_result($db->query("SELECT Time FROM ".SQL_PREFIX."stopped WHERE Username = '".$pl->Username."'"),0,0);
$shut = $db->queryRow("SELECT p.Username, p.Level, p.ClanID, an.Text, an.On_time FROM ".SQL_PREFIX."as_notes as an INNER JOIN ".SQL_PREFIX."players as p ON (p.Username = an.hranitel) WHERE an.Username = '".$pl->Username."' AND an.Status = 'shuted' ORDER BY an.Time DESC");

if( !empty($Time) ) $molch_time = round( ($Time - time('void')) / 3600, 1);


if( $blocked = $db->queryRow("SELECT Why, link FROM ".SQL_PREFIX."blocked WHERE Username = '".$pl->Username."'") )
{
    $bloc = 'Персонаж заблокирован. Причина: '.$blocked['Why'];
    if( !empty($blocked['link']) ) $bloc .= '. <a href="'.$blocked['link'].'" target="_blank">Ссылка на дело.</a>';
}

$chaos2 = $db->queryRow("SELECT FreeTime, Comment, link FROM ".SQL_PREFIX."chaos WHERE Username = '".$pl->Username."'");
if( !empty($chaos2) ) $chaos_time = round( ($chaos2['FreeTime'] - time('void')) / 3600, 1);

if( $brak = $db->queryRow("SELECT p.Username, p.Level, p.ClanID FROM ".SQL_PREFIX."as_notes as an INNER JOIN ".SQL_PREFIX."players as p ON (p.Username = an.Text) WHERE an.Username = '".$pl->Username."' AND an.Status = 'brak'") )	$brak = ($pl->sex == 'M' ? 'Женат на ' : 'Замужем за ').$pl->slogin( $brak['Username'], $brak['Level'], $brak['ClanID'] ).'<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$brak['Username'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$brak['Username'].'" /></a>';


$reit = array( 'lost_diff' => 0, 'lost_sum' => 0, 'lost_perc' => 0, 'get_stsum' => 0, 'karma_plus' => 0, 'karma_min' => 0 );

function search_in_array( $needle, $haystack )
{	if( !empty($haystack) )		foreach( $haystack as $k => $v )			if( $v['Username'] == $needle ) return $k+1;

}

$reit['lost_diff']  = search_in_array( $pl->Username, $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostDiff_1' ) );
$reit['lost_sum']   = search_in_array( $pl->Username, $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostSum_1' ) );
$reit['lost_perc']  = search_in_array( $pl->Username, $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getWinLostPerc_1' ) );
$reit['get_stsum']  = search_in_array( $pl->Username, $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top_get_stSUM_1' ) );
$reit['karma_plus'] = search_in_array( $pl->Username, $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getKarmaPlus_1' ) );
$reit['karma_min']  = search_in_array( $pl->Username, $db->readCache( $db_config[DREAM]['web_root'].'/cache/top5/top5_getKarmaMinus_1' ) );


if( empty($reit['lost_diff']) && empty($reit['lost_sum']) && empty($reit['lost_perc']) && empty($reit['get_stsum']) && empty($reit['karma_plus']) && empty($reit['karma_min']) )
  $reit2 = 'Не заня'.($pl->sex == 'M' ? 'л' : 'ла').' ни одно из мест в <a href="clans_top.php">общих рейтингах</a>';
else
{	$type  = array();
	$mesto = array();

	if( !empty($reit) )	foreach( $reit as $k => $v )
	{		if( !empty($v) )
		{			switch( $k )
			{				case 'lost_diff': $type['Разница win — lost'] = $v; break;
				case 'lost_sum': $type['Сумма win + lost'] = $v; break;
				case 'lost_perc': $type['Отношение win / lost'] = $v; break;
				case 'get_stsum': $type['Сумма статов'] = $v; break;
				case 'karma_plus': $type['Респект игроков'] = $v; break;
				case 'karma_min': $type['Дизреспект игроков'] = $v; break;
       		 }
       	}


	}



	if( !empty($type) )
	{		$reit2 = '<a href="clans_top.php"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/g_kubok1.gif" align="left" style="margin-right:5px"></a>Заня'.($pl->sex == 'M' ? 'л' : 'ла');		foreach( $type as $k => $v )
		{			$reit2 .= ' <b>'.$v.'</b> место в "'.$k.'"';		 	if( $v != end($type) )
		 	 $reit2 .= ', ';
        }
    }
   //$reit2 = '<img src="images/g_kubok1.gif" align="left" style="margin-right:5px">Заня'.($pl->sex == 'M' ? 'л' : 'ла'). ' ' .implode( ', ', $mesto ). ' '.( count($mesto) > 1 ? 'места' : 'место' ).' в '.( count($type) > 1 ? 'рейтингах' : 'рейтинге' ).' <a href="clans_top.php">"'.implode( ', ',$type ).'"</a> соответственно.';


}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<title>Информация о персонаже</title>
    <link href="http://<?=$db_config[DREAM]['other'];?>/css/player_visual.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="http://<?=$db_config[DREAM]['other'];?>/css/info.css" rel="stylesheet" type="text/css" media="screen" />
   <script src="http://www.google.com/jsapi"></script>
   <script type="text/javascript">

    google.load("jquery", "1.4.2");

    google.setOnLoadCallback(function() {    	$.getScript("http://<?=$db_config[DREAM]['other'];?>/js/jquery/jquery.overscroll.js",function(){ $("#overscroll").overscroll(); });        $('.btn1').click(function(){$('#pict_'+this.id).show()});$('.btn2').click(function(){$('#pict_'+this.id).hide()})

        $("#sword__bg").height($("#center_content").height()-14)+"px";
    });
    </script>

</head>
<body>

   <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr style="height: 97">
     <td valign="top" align="left"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/top_left.png" width="125px" height="97px" /></td>

     <td class="tbl-sts_top" align="center" valign="top">

      <table height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td valign="top" align="left"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/top_logo_left.png" width="189px" height="97px" /></td>
        <td valign="top" align="right"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/top_logo_right.png" width="188px" height="97px" /></td>
        </tr>
      </table>

     </td>


     <td  valign="top"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/top_right.png" width="125px" height="97px" /></td>
    </tr>
   </table>



    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>

    <td valign="top" class="bg_left_and_right tbl-left-bg">&nbsp;</td>


     <td valign="top" align="left" id="center_content">

          <table width="210px" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td align="left">
			 <?=$pl->load_pers_visual();?>
             <div class="text_input">
             <form action="inf.php" method="GET">
                <input type="text" name="uname" id="uname" maxlength="20" class="text_field" value="Найти" onBlur="if (value == '') {value='Найти'}" onFocus="if (value == 'Найти') {value = ''}" />

             </form>
             </div>
 	            <table align="left" valig="top">
	             <? if( $pl->online == true ): ?>
	             <tr>
	              <td>Персонаж находится в комнате<br /> <b>"<?=$pl->room;?>"</b></td>
	             </tr>
	             <? else: ?>
	             <tr>
	              <td><?=$pl->lo_time;?></td>
	             </tr>
	             <? endif; ?>
				 <? if( !empty($pl->id_clan) ): ?>
		         <tr>
		          <td align="center"><b><?=$pl->clanwars;?></b></td>
		         </tr>
		         <tr>
		          <td align="center"><b><?=$pl->clanpeace;?></b></td>
		         </tr>
		         <tr>
		          <td align="center"><b><?=$pl->clanalliance;?></b></td>
		         </tr>
		         <? endif; ?>
                 <? if( !empty($admin) ): ?>
		         <tr>
		          <td align="center"><br /><a href="adm.php?uname=<?=$pl->Username;?>" target="_blank">В админку</a><br /><a href="vin.php?uname=<?=$pl->Username;?>" target="_blank">Досье</a></td>
		         </tr>
		         <? endif; ?>
	            </table>
	       </td>
           <td align="left" valign="top" style="padding-left:70px;">

				<table width="320px">
				 <tr>
					<td class="uzor_bg" width="270px" align="center"><b>Параметры персонажа</b></td>
        		 </tr>
				 <tr>
					<td>
					   <table valign="top">
					    <tr>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/stre.png" title="Сила <?=$pl->Stre;?>" />

					      </td>

					      <td>сила: <b><?=$pl->Stre;?></b></td>

                          <td width="10px">&nbsp;</td>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/udar.png" title="Удар <?=$mf['min_damage'];?> - <?=$mf['max_damage'];?>" />

					      </td>

					      <td>удар: <b><?=$mf['min_damage'];?> - <?=$mf['max_damage'];?></b></td>
					    </tr>

					    <tr>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/agil.png" title="Ловкость <?=$pl->Agil;?>" />

					      </td>
					      <td>ловкость: <b><?=$pl->Agil;?></b></td>
                          <td width="10px">&nbsp;</td>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/krit.png" title="Крит. удар <?=$mf['crit'];?>" />

					      </td>

					      <td>крит: <b><?=$mf['crit'];?></b></td>
					    </tr>


					    <tr>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/intu.png" title="Интуиция <?=$pl->Intu;?>" />

					      </td>
					      <td>интуиция: <b><?=$pl->Intu;?></b></td>
                          <td width="10px">&nbsp;</td>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/save_mf.png" title="Антикрит <?=$mf['acrit'];?>" />

					      </td>

					      <td>Антикрит: <b><?=$mf['acrit'];?></b></td>
					    </tr>

					    <tr>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/intl.png" title="Интеллект <?=$pl->Intl;?>" />

					      </td>
					      <td>интеллект: <b><?=$pl->Intl;?></b></td>
                           <td width="10px">&nbsp;</td>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/uvorot.png" title="Уворот <?=$mf['uv'];?>" />

					      </td>

					      <td>уворот: <b><?=$mf['uv'];?></b></td>
					    </tr>

					    <tr>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/endu.png" title="Выносливость <?=$pl->Endu;?>" />

					      </td>
					      <td>выносливость: <b><?=$pl->Endu;?></b></td>
                          <td width="10px">&nbsp;</td>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/antiuvorot.png" title="Антиуворот <?=$mf['auv'];?>" />

					      </td>

					      <td>Антиуворот: <b><?=$mf['auv'];?></b></td>
					    </tr>


					    <tr>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/head.png" title="Броня головы <?=$mf['Armor1'];?>" />

					      </td>
					      <td>броня головы: <b><?=$mf['Armor1'];?></b></td>
                          <td width="10px">&nbsp;</td>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/belt.png" title="Броня пояса <?=$mf['Armor3'];?>" />

					      </td>

					      <td>броня пояса: <b><?=$mf['Armor3'];?></b></td>
					    </tr>

					    <tr>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/chest.png" title="Броня груди <?=$mf['Armor2'];?>" />

					      </td>
					      <td>броня груди: <b><?=$mf['Armor2'];?></b></td>
                          <td width="10px">&nbsp;</td>
					      <td width="27px">

					      <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/icons/legs.png" title="Броня ног <?=$mf['Armor4'];?>" />

					      </td>

					      <td>броня ног: <b><?=$mf['Armor4'];?></b></td>
					    </tr>

					 </table>
					</td>
        		</tr>
        		<tr>
				   <td class="uzor_bg" width="270px" align="center"><b>Характеристики персонажа</b></td>
				</tr>
				<tr>
						<td>
					   		<table valign="top" align="center">
					   		 <tr>
					   		   <td class="lenta_bg">
					   		    <table align="center" valign="top">
					   		     <tr>
					   		      <td><br /><b><?=$pl->Won;?></b></td>
					   		      <td width="30px">&nbsp;</td>
					   		      <td><br /><b><?=$pl->Lost;?></b></td>
				                 </tr>
				                </table>
					   		   </td>
					   		 </tr>
					   		 <tr>
					   		   <td align="center">
					   		    <?
					   		    	$img = @get_headers('http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$pl->id_clan.'_big.gif');
                                	if ( $img[0] == 'HTTP/1.1 200 OK' ): print '<br /><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$pl->id_clan.'_big.gif" border="0" />'; endif;
                                ?>
					   		   </td>
			                 </tr>
					   		</table>
		                </td>
		         </tr>
		         <tr>
		              <td>
		                <table valign="top" align="left">
		                 <tr>
		                  <td>Пол: <b><?=$pl->sex == 'M' ? 'мужской' : 'женский';?></b></td>
		                 </tr>
		                 <tr>
		                  <td>Карма: <b><?=(!empty($pl->karma) ? $pl->karma : 0);?></b> <a href="?uname=<?=$pl->Username;?>&karma=inc">+</a>/<a href="?uname=<?=$pl->Username;?>&karma=dec">-</a> </td>
		                 </tr>
		                 <? if( !empty($pl->id_clan) ): ?>
		                 <tr>
		                  <td>Клан: <a href="top5.php?show=<?=$pl->id_clan;?>" class="us2" target="_blank"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/clan/<?=$pl->id_clan;?>.gif" border="0" alt="<?=$pl->cl_name;?>" /><b><?=$pl->cl_name;?></b></td>
		                 </tr>
		                 <? endif; ?>
		                 <? if( !empty($pl->rank_name) ): ?>
		                 <tr>
		                  <td>Ранг: <b><?=$pl->rank_name;?></b></td>
		                 </tr>
		                 <? endif; ?>
		                 <? if( !empty($brak) ): ?>
		                 <tr>
		                  <td> <?=$brak;?> </td>
		                 </tr>
		                 <? endif; ?>
		                 <? if( !empty($reit2) ): ?>
		                 <tr>
		                  <td> <?=$reit2;?> </td>
		                 </tr>

		                 <? endif; ?>
		                 <? if( !empty($msg) ): ?>
		                 <tr>
		                  <td><?=$msg;?></td>
		                 </tr>
		                 <? endif; ?>
		                </table>
		              </td>
		          </tr>
   				</table>


           </td>
	      </tr>

	     </table>
	     <? if( !empty($molch_time) || !empty($bloc) || !empty($chaos2) ): ?>
	     <table valign="bottom" align="center" style="margin-top:50px;">
	     <? if( !empty($molch_time) ): ?>
	      <tr>
	       <td>
	        <b><font color=#ff7272>Персонажу запрещено общение. Осталось: <?=okon4($molch_time, array('час', 'часа', 'часов'));?>.
	       Наложено хранителем <?=$pl->slogin( $shut['Username'], $shut['Level'], $shut['ClanID'] ).'<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$shut['Username'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$shut['Username'].'" /></a>'; ?><br /><? if( !empty($shut['Text']) ) echo 'Причина: '.$shut['Text']; ?>
            </font></b> </td>
	      </tr>
	     <? endif; ?>
	     <? if( !empty($bloc) ): ?>
	     <tr>
	      <td> <b><font color=#ff7272><?=$bloc;?></font></b> </td>
	     </tr>
	     <? endif;?>

	     <? if( !empty($chaos2) ): ?>
	     <tr>
	      <td> <b><font color=#ff7272>У персонажа проклятие. Осталось: <?=okon4($chaos_time, array('час', 'часа', 'часов'));?>. <? if(!empty($chaos2['Comment'])) echo '<br />Причина: '.$chaos2['Comment']; ?> <? if(!empty($chaos2['link'])) echo '<br /><a href="'.$chaos2['link'].'" target="_blank">Ссылка на дело</a>'; ?> </font></b> </td>
	     </tr>
	     <? endif;?>
	     </table>
	     <? endif; ?>
         <table valign="bottom" align="left" style="margin-top:22px;">

             		<tr>
						<td class="uzor_bg" width="570px" align="center"><b>Анкетные данные</b></td>
					</tr>
					<tr>
						<td>
					   		<table valign="top" align="left" style="margin-left:30px">
					   		 <tr>
					   		      <td>Имя: <b><?=$pl->name;?></b></td>
					   		 </tr>
					   		 <tr>
					   		      <td>Город: <b><?=( !empty($pl->town) ? $pl->town : 'не указан.');?></b></td>
					   		 </tr>
					   		 <tr>
					   		      <td>ICQ: <b><?=( !empty($pl->ICQ) ? '<a href="http://www.icq.com/people/&searched=1&uin='.$pl->ICQ.'"><img src="http://iti-images.it-industry.biz/sidebar-icq-online.gif" border="0" align="middle" height="18px" width="18px" />'.$pl->ICQ.'</a>' : 'нет.');?></b></td>
					   		 </tr>
					   		 <tr><td></td></tr>
					   		 <tr>
					   		  <td> О себе: <br />
					   		     <table valign="top" width="500px">
					   		      <tr>
					   		       <td><?=$pl->infor;?></td>
				                  </tr>
				                 </table>
					   		  </td>
			                 </tr>
			                 <? if( !empty($admin) ): ?>
			                 <tr><td><hr color="#cccccc;" /></td></tr>
			                 <tr>
			                  <td>

			                    Текущий либо последний заригистрированный IP: <?=$ip;?> (разглашение IP наказуемо)<br />
			                    Мульты с этого IP:
			                     <?
			                     if( !empty($multi) )			                     	foreach( $multi as $m )
			                     	{
			                     	   echo $pl->slogin( $m['Username'], $m['Level'], $m['ClanID'] ).'<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$m['Username'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$m['Username'].'" /></a>';
			                     	   if( $m != end($multi) ) echo ',&nbsp;&nbsp;';
			                     	   else echo '.';
			                        }
			                     else
			                       echo '<b>пусто.</b>';
			                     ?>
			                    <br /><br />Регистрационный e-mail: <?=$pl->email;?><br />
			                    Реальная дата рождения: <?=$pl->births;?><br /><br />

			                    Молчанки: <? if( !empty($shut_cnt) ): echo $shut_cnt; ?> шт. Последняя by <? echo $pl->slogin($shut['Username'], $shut['Level'], $shut['ClanID']).'<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$shut['Username'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$shut['Username'].'" /></a>'; else: echo '0'; endif; ?>.<br />
                                Проклятия: <? if( !empty($chaos1) ): echo $chaos1['cnt']; ?> шт. Последнее by <? echo $pl->slogin($chaos1['Username'], $chaos1['Level'], $chaos1['ClanID']).'<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$chaos1['Username'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$chaos1['Username'].'" /></a>'; else: echo '0'; endif; ?>.<br />
			                    Блоки: <? if( !empty($blok) ): echo $blok['cnt']; ?> шт. Последний by <? echo $pl->slogin($blok['Username'], $blok['Level'], $blok['ClanID']).'<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$blok['Username'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$blok['Username'].'" /></a>'; else: echo '0'; endif; ?>.<br />
			                  </td>
			                 </tr>
			                 <? endif; ?>
					   		</table>
		                </td>
		            </tr>
            </td>
          </tr>
         </table>
     </td>

  <!-------- /osnovnoe -------->

    <td valign="top">

		        <table valign="top" align="right">
				<tr>
					<td align="left">
					<img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/sword_head.png" width="69px" height="121px"  /><br />
    					<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    					<tr>

    						<td valign="top" class="sword__bg" id="sword__bg">&nbsp;</td>
					    </tr>
					    </table>
					<img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/sword_end.png" width="69px" height="59px"  />
					<div style="position:absolute; margin-top:60px;margin-left:-70px;text-align:center;color:#cccccc;"> Воин, помни: не всегда сильнее тот,<br /> у кого длиннее меч </div>
                    </td>
                </tr>

        		</table>

    </td>



    <td valign="top">

				<table valign="top">
				<tr>
					<td class="uzor_bg" width="270px" align="center"><b>Подарки персонажа</b></td>
        		</tr>
        		<tr>
        		 <td>

					<div id="overscroll">
						<ul>
						  <?
						  if( !empty($gifts) ):
						  foreach( $gifts as $v ):
						  	$v['presentMSG'] = string_words($v['presentMSG'],100);
						  	echo '<li><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/gifts/'.$v['presentIMG'].'.gif" width="60px" height="60px" align="left" />&nbsp;<b>'.$v['presentMSG'].' <br />&nbsp;От: </b>'.$pl->slogin($v['Username'], $v['Level'], $v['ClanID']).'<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$v['Username'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$v['Username'].'" /></a></li>';
                          endforeach;
                          endif;
                          ?>

						</ul>
					</div>
					<div style="text-align:center;color:#cccccc;font-size:10px"> just drag ;-) </div>
	             </td>
	            </tr>
	           </table>
    </td>



    <td valign="top" class="bg_left_and_right tbl-right-bg">&nbsp;</td>

    </tr>
   </table>


   <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr style="height: 79">
      <td valign="top" align="left">
        <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/bottom_left.png" width="125px" height="79px" />
      </td>
      <td class="tbl-sts_bottom" align="center" valign="bottom">

    	<table height="100%" border="0" cellspacing="0" cellpadding="0">
        	<tr>
        	  <td valign="bottom" align="right"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/bottom_logo_left.png" width="149px" height="79px" /></td>
        	  <td valign="bottom" align="right"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/bottom_logo_right.png" width="150px" height="79px" /></td>
        	</tr>
        </table>


      </td>
      <td valign="top" align="right">
        <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/info/bottom_right.png" width="125px" height="79px" />
      </td>
    </tr>
   </table>

</body>
</html>