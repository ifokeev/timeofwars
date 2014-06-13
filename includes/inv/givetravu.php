<?
if( (!empty( $_GET['givetravu'] ) && is_numeric( $_GET['givetravu'] )) && !empty( $_GET['whom'] ) && (!empty( $_GET['surtext'] ) && is_numeric( $_GET['surtext'] )) )
{	if($woodc){
		$err = 'Вы слишком заняты поиском трав';
	}
	elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
	else{

    if( !$row = $db->queryCheck("SELECT Username, Level FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view($_GET['whom'])."';") )
    {
    	$err = 'Заданного персонажа не существует';
    }
    elseif( trim(strtolower($row[0])) == strtolower($player->username) )
    {    	$err = 'Оригинально =)';
    }
    elseif( $row[1] < 3 )
    {
    	$err = 'Вы не можете передать что-либо к персонажам младше 3-го уровня';
    }
    elseif( $player->clanid == '200' )
    {
    	$err = 'На вас проклятие. Вам запрещены передачи.';
    }
	elseif( !intval( $_GET['surtext'] ) )
	{
		$err = 'Нельзя передать половинчатые растения :)';
	}
	elseif( !$dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Un_Id = '".intval($_GET['givetravu'])."' AND Owner = '$player->username' AND (Id LIKE '%items/%' OR Id LIKE 'fish/%');") )
	{
		$err = 'Такой вещи не существует';
    }
    elseif( $_GET['surtext'] > $dat['Count'] )
    {
    	$err = 'Нельзя передать больше, чем есть';
    }
    else
    {
    	$multstr1        = '';
    	$multstr2        = '';
    	$targetip        = '';
     	$LastIP          = '';
    	$_GET['surtext'] = intval( $_GET['surtext'] );

    	if( empty( $_GET['surtext'] ) || $_GET['surtext'] < 1 ) $_GET['surtext'] = 1;



    	if( $ip = @$db->SQL_result($db->query("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '$player->username'")) ){ $LastIP   = $ip;   }
    	if( $ip = @$db->SQL_result($db->query("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '$row[0]'")) ){     $targetip = $ip; }

        if ($targetip == $LastIP)
        {
        	$multstr1 = '<font color="red">';
        	$multstr2 = '</font>';
        }

        if( $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Id = '".$dat['Id']."' AND Owner = '$row[0]'") )
        {
        	$db->update( SQL_PREFIX.'things', Array( 'Count' => '[+]'.$_GET['surtext'] ), Array( 'Owner' => $row[0], 'Id' => $dat['Id'] ), 'maths' );
        }
        else
        {
            $db->insert( SQL_PREFIX.'things', Array( 'Owner' => $row[0], 'Id' => $dat['Id'], 'Thing_Name' => $dat['Thing_Name'], 'Slot' => '15', 'Cost' => '1', 'Count' => $_GET['surtext'], 'NOWwear' => '0', 'MAXwear' => '1' ) );
        }

    	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => $row[0], 'What' => $multstr1.$dat['Thing_Name'].' кол-вом '.$_GET['surtext'].' шт. ('.date('H:i').')'.$multstr2 ) );
    	$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $row[0], 'Text' => '<b> '.$player->username.' </b> передал вам <b> '.$dat['Thing_Name'].' </b> кол-вом <b> '.$_GET['surtext'].' </b> шт.' ) );

    	if( $dat['Count'] == '1' )
    	{
    		$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Un_Id = '".intval($_GET['givetravu'])."' AND Owner = '$player->username' AND (Id LIKE 'items/%' OR Id LIKE 'fish/%');");
    	}
    	else
    	{
    		$db->update( SQL_PREFIX.'things', Array( 'Count' => '[-]'.$_GET['surtext'] ), Array( 'Owner' => $player->username, 'Un_Id' => intval($_GET['givetravu']) ), 'maths' );
        }

        $db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND (Id LIKE '%items/%' OR Id LIKE 'fish/%') AND Count = '0';");
        $db->update( SQL_PREFIX.'players',  Array( 'Money' => '[-]0.5' ), Array( 'Username' => $player->username ), 'maths' );


        $err = $dat['Thing_Name'].' кол-вом '.$_GET['surtext'].' шт. удачно передан персонажу '.$row[0];
    }

    }
}
?>
