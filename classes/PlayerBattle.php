<?
class battle
{
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


	{
		if( strlen($user) > 20 ) die( 'Hack edition' );



		if( !empty($player) )


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
	{

		$r = '';

		if( empty($user) && empty($lvl) && empty($clanid) && empty($team) )
		{
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
	{
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
	{

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
        ����������� ����: '.$mf['crit'].'<br />
        ��������������� ����: '.$mf['acrit'].'<br />
        ����������� �������: '.$mf['uv'].'<br />
        ����������� ����������� '.$mf['auv'].'<br />
        '; */
	}

	public function itemsinfo()
	{

		$out['Slot_name'] = array( '������ ���� ������', '������ ���� ��������', '������ ���� ������', '������ ���� �����', '������ ���� ������', '������ ���� ������', '������ ���� ������', '������ ���� �����', '������ ���� ��������', '������ ���� ���', '������ ���� �����', '������ ���� ������ 2' );
		$out['Slot_id']   = array();
		$out['Slot_type'] = array();
		$slots_h_w = array( 0 => '40_20', 1 => '60_20', 2 => '59_59', 3 => '59_59', 4 => '20_20', 5 => '20_20', 6 => '20_20', 7 => '59_59', 8 => '60_40', 9 => '59_59', 10 => '60_40', 11 => '' );

		for( $i=0; $i<=11; $i++ )
		{
			$out['Slot'][$i]    = 'empt'.$i;
		}

		$query = sprintf("SELECT Slot, Un_Id, Id, Thing_Name, NOWwear, MAXwear FROM ".SQL_PREFIX."things WHERE Slot < '11' AND Wear_ON = '1' AND Owner = '%s';", $this->Username );
		$res = $db->queryArray( $query, __METHOD__ . 'getitemsinfo' );

		if( !empty($res) )
		{
			{
				elseif( preg_match('/(��������)/i', $item['Thing_Name']) ) $type = 'i.gif'; //��������
				elseif( preg_match('/��������/i', $item['Thing_Name']) ) $type = 'e.gif'; //��������
				elseif( preg_match('/�������/i', $item['Thing_Name']) ) $type = 's.gif'; //��������
				else  $type = 'empt.gif'; //���

				$out['Slot_type'][$item['Slot']]  = 'http://'.$db_config[DREAM_IMAGES]['server'].'/slots/i/'.$slots_h_w[$item['Slot']].'/'.$type;
				$out['Slot'][$item['Slot']]       = $item['Id'];
				$out['Slot_name'][$item['Slot']]  = $item['Thing_Name']."\n(������������� ".$item['NOWwear']."/".$item['MAXwear'].")";
			}
		}

		return $out;
	}


	//function __set($var, $value){ $this->$var = $value; }
	//function __get($var){ return $this->$var; }



	public function is_blocked()
	{
		 return die( sprintf(playerblocked, $why) );

		unset($why);
	}

	public function filter($s)
	{
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
	{
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
	{

		$hp = $this->hp_div();
		$mana = $this->mana_div();

        $out = $this->out;

        if( empty($out) ) die;

	}

    public function load_enemy_visual()
    {
    	 $mf2 = $this->get_modif_player();

    	 if( empty($mf2) ) die;

    ?>
    <div class="icons_modif icons_modif_right">
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/armor_head.jpg" title="����� ������ <?=$mf2['Armor1'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/armor_chest.jpg" title="����� ������� <?=$mf2['Armor2'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/armor_belt.jpg" title="����� ����� <?=$mf2['Armor3'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/armor_boots.jpg" title="����� ��� <?=$mf2['Armor4'];?>" /><br /><br />

         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/hit.jpg" title="���� <?=$mf2['min_damage'];?> - <?=$mf2['max_damage'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/krit.jpg" title="���� <?=$mf2['crit'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/antikrit.jpg" title="�������� <?=$mf2['acrit'];?>" /><br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/uvorot.jpg" title="������ <?=$mf2['uv'];?>" /> <br />
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/antiuv.jpg" title="���������� <?=$mf2['auv'];?>" /><br />
    </div>
    <div class="loge loge_right">
      <div class="stats stats_right">
         <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/stre.png" title="���� <?=$this->Stre;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/agil.png"  title="�������� <?=$this->Agil;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/intu.png"  title="�������� <?=$this->Intu;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/intl.png"  title="��������� <?=$this->Intl;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/slots/icons/endu.png"  title="������������ <?=$this->Endu;?>" />
      </div>
    </div>
    }

	public function load_pers_buttons()
	{



        $magic = $db->queryArray("SELECT Un_Id, Id, NOWwear, MAXwear, MagicID FROM ".SQL_PREFIX."things WHERE Owner = '".$this->Username."' AND Slot = '11' AND MagicID <> '����� ����� ������' AND MagicID <> '����� ������' AND MagicID <> '�������' AND MagicID <> '���������' AND MagicID <> '�����������';");

	}



	function __destruct()
	{
	}

}
?>