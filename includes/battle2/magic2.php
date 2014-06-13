<?

function set_hp($user, $hp)
{
		if( !is_numeric($hp) ) die;

		global $db;
		$db->update( SQL_PREFIX.'players', Array( 'HPnow' => intval($hp) ), Array( 'Username' => $user ) );
}


function write_slogin( $user, $lvl, $clanid, $team = 0 )
{
		global $db_config;

		$r = '';

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

function magic( $un_id, $target, $battle_id, $step )
{	global $db, $player, $battle_log;
   $antimag = 0;
   $str = '';

   if( !$th = $db->queryRow("SELECT Un_Id, Id, Owner, Thing_Name, Level_need, MINdamage, MAXdamage, Srab, MagicID, NOWwear, MAXwear FROM ".SQL_PREFIX."things WHERE Un_Id = '".intval($un_id)."' LIMIT 1;") )
         return '����� ���� �� ����������';

   if( !empty($target) )
   {
      $tar = @iconv('UTF-8', 'windows-1251', $target);
      if( empty($tar) )
        $tar = $target;
   }

   if( $th['MagicID'] != 'note' && !empty($tar) )
   {
	    if( !$dat = $db->queryRow( "SELECT p.Username, p.Level, p.ClanID, p.HPnow, p.HPall, 2ba.team, 2ba.is_dead FROM ".SQL_PREFIX."players as p LEFT OUTER JOIN ".SQL_PREFIX."2battle_action as 2ba ON ( 2ba.battle_id = battle_id AND 2ba.Username = p.Username ) WHERE p.Username = '".$tar."' AND 2ba.is_dead = '0' AND p.BattleID2 = '".$battle_id."' LIMIT 1;" ) )
	      return '������ ��������� �� ���������� ���� �� ��� �����.';
   }

   $used = (rand(1,100) < $th['Srab']);

   if ( !empty($dat['Username']) && $anti = $db->queryRow("SELECT Srab FROM ".SQL_PREFIX."things WHERE Id = 'antimag1' AND Owner = '".$dat['Username']."';") )
   {   	  $used2 = (rand(1,200) < $anti['Srab']);
   	  if( $used2 )
   	   $antimag = 1;
   }


   $noantimag = array( '+ 20 HP', '+ 30 HP', '+ 50 HP', '+ 100 HP', '+ 500 HP', '���������', '������ 10', '������ 20', '������ 50', '������ 100' );

   if( $antimag == 1 && !empty($dat['Username']) && !in_array( $th['MagicID'], $noantimag ) )
     $str = write_slogin( $dat['Username'], $dat['Level'], $dat['ClanID'], $dat['team'] ).' ��������� �� ����� '.$player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).'.';
   elseif( !$used )
     $str = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' ������� ������������ ����� <strong>'.$th['Thing_Name'].',</strong> �� ��������.';
   else
   {
       ////�������������� �� (��������)
       if (  $th['MagicID'] == '+ 20 HP' || $th['MagicID'] == '+ 30 HP' || $th['MagicID'] == '+ 50 HP' || $th['MagicID'] == '+ 100 HP'  || $th['MagicID'] == '+ 500 HP' || $th['MagicID'] == '���������'   )
       {       	   switch( $th['MagicID'] )
       	   {       	   		case '+ 20 HP':   $heal_hm = 20;  break;
                case '+ 30 HP':   $heal_hm = 30;  break;
                case '+ 50 HP':   $heal_hm = 50;  break;
       	   		case '+ 100 HP':  $heal_hm = 100; break;
       	   		case '+ 500 HP':  $heal_hm = 500; break;
       	   		case '���������': $heal_hm = $th['Level_need']*2; break;
       	   		default:          $heal_hm = 1;   break;
       	   }


       	   if( $player->hp == $player->hp_all )
       	   {
       	   	  	$str = '� '.$player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' ������ �� ����� <strong>'.$th['Thing_Name'].'.</strong>';
       	   }
       	   else
       	   {       	   	    $new_hp = $player->hp+$heal_hm;
       	   	    if( $new_hp > $player->hp_all ) $new_hp = $player->hp_all;

       	   	    $player->set_hp( $new_hp );
       	   	    $str = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' ������ ����������� <strong>'.$heal_hm.' HP</strong> ['.$new_hp.'/'.$player->hp_all.'].';

       	   }       }       //����� ����� � ����������

       if ( ($th['MagicID'] == '������ 10' || $th['MagicID'] == '������ 20' || $th['MagicID'] == '������ 50' || $th['MagicID'] == '������ 100') && !empty($dat['Username']))
       {       		switch( $th['MagicID'] )
       		{       			case '������ 10':  $heal_hm = 10;  break;
       			case '������ 20':  $heal_hm = 20;  break;
       			case '������ 50':  $heal_hm = 50;  break;
       			case '������ 100': $heal_hm = 100; break;
       			default:           $heal_hm = 1;   break;
       		}

       		$new_hp = $dat['HPnow'] + $heal_hm;
       		if( $new_hp > $dat['HPall'] ) $new_hp = $dat['HPall'];

       		set_hp( $dat['Username'], $new_hp );

       		$str = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' ����������� ��������� '.write_slogin($dat['Username'], $dat['Level'], $dat['ClanID'], $dat['team']).' <strong>'.$heal_hm.' HP</strong> ['.$new_hp.'/'.$dat['HPall'].'].';
       }


       switch( $th['MagicID'] )
       {       		case 'note':
       		  		 $str = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).': '.$tar;
       		break;


            case '����������':

                if( empty($dat['Username']) ) return 'Wtf?O_o';
               	elseif( $dat['team'] == $player->team ) return '�������� ��� �� ����� �������.';


               		$db->update( SQL_PREFIX.'2battle_action', Array( 'team' => $player->team ), Array( 'Username' => $dat['Username'] ) );
               		$str = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' �������� '.write_slogin($dat['Username'], $dat['Level'], $dat['ClanID'], $dat['team']).' �� ���� �������.';
            break;



            case '����':
              	if( $db->execQuery( "DELETE FROM ".SQL_PREFIX."2battle_action WHERE Username = '".$player->Username."' AND battle_id = '".$battle_id."' AND is_dead = '0';" ) )
              	{              		$db->update( SQL_PREFIX.'players', Array( 'BattleID2' => 0 ), Array( 'Username' => $player->Username ) );
                 	$str = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' ������ � ���� ���.';
                }
            break;



            case '�����������':
                if( empty($dat['Username']) ) return 'Wtf?O_o';
              	elseif( $dat['is_dead'] == 0 ) return '�������� ���.';

              	$db->update( SQL_PREFIX.'2battle_action', Array( 'is_dead' => 0 ), Array( 'Username' => $dat['Username'] ) );
              	$db->update( SQL_PREFIX.'players', Array( 'HPnow' => $dat['HPall'] ), Array( 'Username' => $dat['Username'] ) );
              	$str = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' ��������� '.write_slogin($dat['Username'], $dat['Level'], $dat['ClanID'], $dat['team']).'.';
            break;


            case 'Fireball':
            case '������� ����':

                if( empty($dat['Username']) ) return 'Wtf?O_o';

              	$dmg = mt_rand( $th['MINdamage'], $th['MAXdamage'] );
              	$new_hp = $dat['HPnow'] - $dmg;

              	$player->add_hited( $dmg );

                $str1 = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' ����������� '.$th['Thing_Name'].' �� '.write_slogin($dat['Username'], $dat['Level'], $dat['ClanID'], $dat['team']).'. <strong>-'.$dmg.' HP</strong> ['.( $new_hp < 0 ? 0 : $new_hp ).'/'.$dat['HPall'].'].';
              	$battle_log->add_log( get_date().$str1, $step );

              	if( $new_hp <= 0 )
              	{              	  	$new_hp = 0;
              	  	$db->update( SQL_PREFIX.'2battle_action', Array( 'is_dead' => 1 ), Array( 'Username' => $dat['Username'] ) );
              	  	$str2 = '<strong>'.write_slogin($dat['Username'], $dat['Level'], $dat['ClanID'], $dat['team']).' ����.</strong>';
              	  	$battle_log->add_log( get_date().$str2, $step );
              	}


                set_hp( $dat['Username'], $new_hp );
            break;


            case '��������':
            case '������� ������':

                 $n = 0;

            	 if( $th['MagicID'] == '��������' )
            	  	$kolvo = 25;
            	 elseif($name == '������� ������')
            	 	$kolvo = 3;
                 else
                 	$kolvo = 1;

                 $str1 = $player->slogin($player->Username, $player->Level, $player->id_clan, $player->team).' ����������� '.$th['Thing_Name'].' �� ������� ����������.';
                 $battle_log->add_log( get_date().$str1, $step );

                 $an_team = $db->queryArray( "SELECT p.Username, p.Level, p.ClanID, p.HPnow, p.HPall, 2ba.team FROM ".SQL_PREFIX."2battle_action as 2ba INNER JOIN ".SQL_PREFIX."players as p ON (p.BattleID2 = 2ba.battle_id AND p.Username = 2ba.Username) WHERE 2ba.team <> '".$player->team."' AND 2ba.is_dead = '0' AND 2ba.battle_id = '".$battle_id."';" );

                 if( !empty($an_team) )
                 {                 	foreach($an_team as $user)
                 	{                 		if( $n <= $kolvo )
                 		{                 			if ( $anti = $db->queryRow("SELECT Srab FROM ".SQL_PREFIX."things WHERE Id = 'antimag1' AND Owner = '".$user['Username']."';") )
   							{   								$used = (rand(1,200) < $anti['Srab']);
   								if( $used )
   							 		$battle_log->add_log( get_date().write_slogin($user['Username'], $user['Level'], $user['ClanID'], $user['team']).' ��������� �� �����.', $step );
                        	}
                        	else
                        	{                        		$dmg = mt_rand( $th['MINdamage'], $th['MAXdamage'] );              					$new_hp = $user['HPnow'] - $dmg;


              					$battle_log->add_log( get_date().write_slogin($user['Username'], $user['Level'], $user['ClanID'], $user['team']).' <strong>-'.$dmg.' HP</strong> ['.( $new_hp < 0 ? 0 : $new_hp ).'/'.$user['HPall'].'].', $step );

              				    if( $new_hp <= 0 )
              					{
              	  						$new_hp = 0;
              	  						$db->update( SQL_PREFIX.'2battle_action', Array( 'is_dead' => 1 ), Array( 'Username' => $user['Username'] ) );
              	  						$str = '<strong>'.write_slogin($user['Username'], $user['Level'], $user['ClanID'], $user['team']).' ����.</strong>';
              					}

              					$player->add_hited( $dmg );                        	    set_hp( $user['Username'], $new_hp );

                        	}

                        }
                    	$n++;
                    }
                 }

            break;

       }




   }


   $db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $th['Un_Id'], 'Owner' => $player->Username), 'maths' );
   $th['NOWwear']++;

   if( $th['NOWwear'] >= $th['MAXwear'] ) $db->execQuery('DELETE FROM '.SQL_PREFIX.'things WHERE NOWwear = MAXwear');

   $win_team = completed_or_not_completed( $battle_id, $step );

 	switch( $win_team )
 	{
 		case 3: $battle_log->add_log( get_date().'<b>�����.</b>', $step+1 ); break;
 		case 2: $battle_log->add_log( get_date().'<b>������� <font color="#6666ff">�����</font> ��������.</b>', $step+1 ); break;
 		case 1: $battle_log->add_log( get_date().'<b>������� <font color="#ff6666">�������</font> ��������.</b>', $step+1 ); break;
 	}

   if( !empty($str) )
      $battle_log->add_log( get_date().$str, $step );

}
?>