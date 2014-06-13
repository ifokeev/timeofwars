<?
class battle
{	public $Username;
	public $Id;
	public $battle_id;
	public $Level;
	public $Room;
	public $ChatRoom;
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
	public $Enemy;
	public $hited;
	public $team;
	public $is_dead;
	public $out;

	function __construct($user)
	{		global $db;
		if( strlen($user) > 20 ) die( 'Hack edition' );

		$player = $db->queryRow( "SELECT p.Username, p.Id, p.Level, p.BattleID2 as battle_id, p.Room, p.ChatRoom, p.Stre, p.Agil, p.Intu, p.Endu, p.Intl, p.HPnow as hp, p.HPall as hp_all, p.Reg_IP, p.Pict, p.mana, p.mana_all, cu.id_clan, 2ba.Enemy, 2ba.hited, 2ba.team, 2ba.is_dead FROM ".SQL_PREFIX."players as p LEFT OUTER JOIN ".SQL_PREFIX."clan_user as cu ON (cu.Username = p.Username) INNER JOIN ".SQL_PREFIX."2battle_action as 2ba ON ( 2ba.battle_id = p.BattleID2 AND 2ba.Username = p.Username ) WHERE p.Username = '".$this->filter($user)."' LIMIT 1;", __METHOD__ . 'query 1' );

		if( !empty($player) )			foreach( $player as $key => $val ) $this->$key = $val;


	    $this->out = $this->itemsinfo();
	}

	public function unwear_all()
	{
		for( $i = 0; $i < 11; $i++ )
		{
			if( $this->out['Slot'][$i] != 'empt'.$i )
			{
			 	   $this->unwear( $this->out['Slot_id'][$i] );
			}
		}

	}

	private function unwear($id)
	{
		global $db;

		$query = '';

		if( $thing_on = $db->queryRow("SELECT Un_Id, Endu_add, Slot, Stre_add, Agil_add, Intu_add, Level_add, Thing_Name FROM ".SQL_PREFIX."things WHERE Owner = '$this->Username' AND Un_Id = '$id' AND Wear_ON = '1'") )
		{
			if ($this->hp > ($this->hp_all - $thing_on['Endu_add']) )
				$db->execQuery("UPDATE ".SQL_PREFIX."players SET HPnow = HPall - '".$thing_on['Endu_add']."' WHERE Username = '$this->Username'");

			if ($thing_on['Stre_add'])
		 		$db->execQuery("UPDATE ".SQL_PREFIX."players SET Stre = Stre - '".$thing_on['Stre_add']."' WHERE Username = '$this->Username'");

			if ($thing_on['Agil_add'])
		 		$db->execQuery("UPDATE ".SQL_PREFIX."players SET Agil = Agil - '".$thing_on['Agil_add']."' WHERE Username = '$this->Username'");

			if ($thing_on['Intu_add'])
				$db->execQuery("UPDATE ".SQL_PREFIX."players SET Intu = Intu - '".$thing_on['Intu_add']."' WHERE Username = '$this->Username'");

			if ($thing_on['Endu_add'])
				$db->execQuery("UPDATE ".SQL_PREFIX."players SET HPall = HPall - '".$thing_on['Endu_add']."' WHERE Username = '$this->Username'");

			if ($thing_on['Level_add'])
				$db->execQuery("UPDATE ".SQL_PREFIX."players SET Level = Level - '".$thing_on['Level_add']."' WHERE Username = '$this->Username'");

			if ($thing_on['Slot'] == 4 || $thing_on['Slot'] == 5 || $thing_on['Slot'] == 6)
				$query = ", Slot = '4'";

			$db->execQuery("UPDATE ".SQL_PREFIX."things SET Wear_ON = '0' ".$query." WHERE Owner = '$this->Username' AND Un_Id = '".$id."' AND Wear_ON = '1'");

		}

	}


	public function slogin( $user = '', $lvl = '', $clanid = '', $team = '' )
	{		global $db_config;

		$r = '';

		if( empty($user) && empty($lvl) && empty($clanid) && empty($team) )
		{			$user = $this->Username;
			$lvl  = $this->Level;
			$clanid = $this->id_clan;
			$team = $this->team;
		}


		if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';

		if( !empty($team) )
		{
		  if( $team == 1 ) $r .= '<a href="javascript:top.AddToPrivate(\''.$user.'\', true)" class="team1">'.$user.'</a>';
		  else $r .= '<a href="javascript:top.AddToPrivate(\''.$user.'\', true)" class="team2">'.$user.'</a>';
	    }
		else $r .= '<a href="javascript:top.AddToPrivate(\''.$user.'\', true)">'.$user.'</a>';

		$r .= ' ['.$lvl.']';
		return $r;
	}

	public function add_hited($plus)
	{		global $db;
		$db->update( SQL_PREFIX.'2battle_action', Array( 'hited' => '[+]'.$plus ), Array( 'Username' => $this->Username ), 'maths' );
	}

	public function set_dead($dead)
	{
		global $db;
		if( $dead != 1 && $dead != 0 ) die;

		$db->update( SQL_PREFIX.'2battle_action', Array( 'is_dead' => $dead ), Array( 'Username' => $this->Username ) );

	}

	public function set_hp($hp)
	{
		if( !is_numeric($hp) ) die;

		global $db;
		$db->update( SQL_PREFIX.'players', Array( 'HPnow' => intval($hp) ), Array( 'Username' => $this->Username ) );
		$this->hp = $hp;
	}

	public function get_modif_player()
	{		global $db; 		$mf = $db->queryRow( "SELECT IF (SUM(Crit) IS NULL, 0, SUM(Crit)) as crit, IF(SUM(AntiCrit) IS NULL, 0, SUM(AntiCrit)) as acrit, IF(SUM(Uv) IS NULL, 0, SUM(Uv)) as uv, IF(SUM(AntiUv) IS NULL, 0, SUM(AntiUv)) as auv, IF(SUM(Armor1) IS NULL, 0, SUM(Armor1)) as Armor1, IF(SUM(Armor2) IS NULL, 0, SUM(Armor2)) as Armor2, IF(SUM(Armor3) IS NULL, 0, SUM(Armor3)) as Armor3, IF(SUM(Armor4) IS NULL, 0, SUM(Armor4)) as Armor4, IF(SUM(MINdamage) IS NULL, 0, SUM(MINdamage)) as min_damage, IF(SUM(MAXdamage) IS NULL, 0, SUM(MAXdamage)) as max_damage FROM ".SQL_PREFIX."things WHERE Owner = '".$this->Username."' AND Wear_ON = '1'", __METHOD__ . 'getmodif' );

 		$p_crit   = $this->Intu * 0.75;
 		$p_auv    = $this->Intu * 0.25;
 		$p_uv     = $this->Agil * 0.75;
 		$p_acrit  = $this->Agil * 0.25;
 		$p_armor  = $this->Endu * 0.15;
 		$p_dmg_min    = $this->Stre * 0.5;
 		$p_dmg_max    = $this->Stre * 0.75;

 		$ret = array(
 		'crit' => round($mf['crit'] + $p_crit),
 		'acrit' => round($mf['acrit'] + $p_acrit),
 		'uv'    => round($mf['uv'] + $p_uv),
 		'auv'   => round($mf['auv'] + $p_auv),
 		'Armor1' => round($mf['Armor1'] + $p_armor),
 		'Armor2' => round($mf['Armor2'] + $p_armor),
 		'Armor3' => round($mf['Armor3'] + $p_armor),
 		'Armor4' => round($mf['Armor4'] + $p_armor),
 		'min_damage' => ceil($mf['min_damage']+$p_dmg_min),
 		'max_damage' => ceil($mf['max_damage']+$p_dmg_max)
 		);

 		return $ret;
        /*echo
        '
        Критический удар: '.$mf['crit'].'<br />
        Антикритический удар: '.$mf['acrit'].'<br />
        Вероятность уворота: '.$mf['uv'].'<br />
        Вероятность антиуворота '.$mf['auv'].'<br />
        '; */
	}

	public function itemsinfo()
	{		global $db, $db_config;

		$out['Slot_name'] = array( 'Пустой слот серьги', 'Пустой слот ожерелье', 'Пустой слот оружие', 'Пустой слот броня', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот шапка', 'Пустой слот перчатки', 'Пустой слот щит', 'Пустой слот обувь', 'Пустой слот оружие 2' );
		$out['Slot_id']   = array();
		$out['Slot_type'] = array();
		$slots_h_w = array( 0 => '40_20', 1 => '60_20', 2 => '59_59', 3 => '59_59', 4 => '20_20', 5 => '20_20', 6 => '20_20', 7 => '59_59', 8 => '60_40', 9 => '59_59', 10 => '60_40', 11 => '' );

		for( $i=0; $i<=11; $i++ )
		{			$out['Slot_id'][$i] = 0;
			$out['Slot'][$i]    = 'empt'.$i;
		}

		$query = sprintf("SELECT Slot, Un_Id, Id, Thing_Name, NOWwear, MAXwear FROM ".SQL_PREFIX."things WHERE Slot < '11' AND Wear_ON = '1' AND Owner = '%s';", $this->Username );
		$res = $db->queryArray( $query, __METHOD__ . 'getitemsinfo' );

		if( !empty($res) )
		{			foreach( $res as $item )
			{				if( preg_match('/made by/i', $item['Thing_Name']) ) $type = 'm.gif'; //самодел
				elseif( preg_match('/(артефакт)/i', $item['Thing_Name']) ) $type = 'i.gif'; //артефакт
				elseif( preg_match('/клановая/i', $item['Thing_Name']) ) $type = 'e.gif'; //клановая
				elseif( preg_match('/именная/i', $item['Thing_Name']) ) $type = 's.gif'; //клановая
				else  $type = 'empt.gif'; //гос

				$out['Slot_type'][$item['Slot']]  = 'http://'.$db_config[DREAM_IMAGES]['server'].'/slots/i/'.$slots_h_w[$item['Slot']].'/'.$type;				$out['Slot_id'][$item['Slot']]    = $item['Un_Id'];
				$out['Slot'][$item['Slot']]       = $item['Id'];
				$out['Slot_name'][$item['Slot']]  = $item['Thing_Name']."\n(долговечность ".$item['NOWwear']."/".$item['MAXwear'].")";
			}
		}

		return $out;
	}


	//function __set($var, $value){ $this->$var = $value; }
	//function __get($var){ return $this->$var; }



	public function is_blocked()
	{		global $db;		if ( $why = @$db->SQL_result($db->query("SELECT Why FROM ".SQL_PREFIX."blocked WHERE Username = '".$this->Username."'"),0,0) )
		 return die( sprintf(playerblocked, $why) );

		unset($why);
	}

	public function filter($s)
	{		$str = $s;
		$str = trim($str);
		$str = htmlspecialchars($str, ENT_NOQUOTES);
		$str = str_replace( '&lt;', '<', $str );
		$str = str_replace( '&gt;', '>', $str );
		$str = str_replace( '&quot;', '"', $str );
		$str = str_replace( '&', '&#38', $str );
		$str = str_replace( '"', '&#34', $str );
		$str = str_replace( "'", '&#39', $str );
		$str = str_replace( '<', '&#60', $str );
		$str = str_replace( '>', '&#62', $str );
		$str = str_replace( '\0', '', $str );
		$str = str_replace( '', '', $str );
		$str = str_replace( '\t', '', $str );
		$str = str_replace( '../', '. . / ', $str );
		$str = str_replace( '..', '. . ', $str );
		$str = str_replace( ';', '&#59', $str );
		$str = str_replace( '/*', '', $str );
		$str = str_replace( '%00', '', $str );
		$str = stripslashes( $str );
		$str = str_replace( '\\', '&#92', $str );
		$str = mysql_escape_string($str);
		return $str;
	}

	public function hp_div()
	{		global $db_config;		$sz1_1 = round((151/$this->hp_all)*$this->hp);
		$sz2_1 = 160 - $sz1_1;

	    $str = '<img src=http://'.$db_config[DREAM_IMAGES]['server'].'/slots/hp_red.gif width='.$sz1_1.'px height=10px class=visible /><img src=http://'.$db_config[DREAM_IMAGES]['server'].'/slots/hpsilver.gif width=160px height=11px /><font class=value>'.$this->hp.'/'.$this->hp_all.'</font>';

	    return $str;
	}

	public function mana_div()
	{
		global $db_config;
		$sz1_1 = round((151/$this->mana_all)*$this->mana);
		$sz2_1 = 160 - $sz1_1;

	    $str = '<img src=http://'.$db_config[DREAM_IMAGES]['server'].'/slots/mana_blue.gif width='.$sz1_1.'px height=10px class=visible /><img src=http://'.$db_config[DREAM_IMAGES]['server'].'/slots/hpsilver.gif width=160px height=11px /><font class=value>'.$this->mana.'/'.$this->mana_all.'</font>';

	    return $str;

	}

	public function load_pers_visual()
	{		global $db_config;

		$hp = $this->hp_div();
		$mana = $this->mana_div();

        $out = $this->out;

        if( empty($out) ) die;
		include( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'visual.php' );
	}

    public function load_enemy_visual()
    {    	global $db_config;
    	 $mf2 = $this->get_modif_player();

    	 if( empty($mf2) ) die;
         echo $this->load_pers_visual();
    ?>
    <div class="icons_modif icons_modif_right">
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/armor_head.jpg" title="Броня головы <?=$mf2['Armor1'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/armor_chest.jpg" title="Броня корпуса <?=$mf2['Armor2'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/armor_belt.jpg" title="Броня пояса <?=$mf2['Armor3'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/armor_boots.jpg" title="Броня ног <?=$mf2['Armor4'];?>" /><br /><br />

         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/hit.jpg" title="Удар <?=$mf2['min_damage'];?> - <?=$mf2['max_damage'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/krit.jpg" title="Крит <?=$mf2['crit'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/antikrit.jpg" title="Антикрит <?=$mf2['acrit'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/uvorot.jpg" title="Уворот <?=$mf2['uv'];?>" /> <br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/antiuv.jpg" title="Антиуворот <?=$mf2['auv'];?>" /><br />
    </div>
    <div class="loge loge_right">
      <div class="stats stats_right">
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/stre.png" title="Сила <?=$this->Stre;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/agil.png"  title="Ловкость <?=$this->Agil;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/intu.png"  title="Интуиция <?=$this->Intu;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/intl.png"  title="Интеллект <?=$this->Intl;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/endu.png"  title="Выносливость <?=$this->Endu;?>" />
      </div>
    </div>    <?
    }

	public function load_pers_buttons()
	{		global $db_config, $db;
		$out = $this->out;


        $magic = $db->queryArray("SELECT Un_Id, Id, NOWwear, MAXwear, MagicID FROM ".SQL_PREFIX."things WHERE Owner = '".$this->Username."' AND Slot = '11' AND MagicID <> 'Сброс своих статов' AND MagicID <> 'Сброс статов' AND MagicID <> 'Лечение' AND MagicID <> 'Нападение' AND MagicID <> 'Принуждение';");
		include( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'attack_buttons.html' );
	}



	function __destruct()
	{
	}

}
?>