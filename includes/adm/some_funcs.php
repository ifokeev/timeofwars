<?
function slogin( $user, $lvl, $clanid )
{
	global $db_config;

		$r = '';

		if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';

		$r .= '<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$user.'" target="_blank">'.$user.'</a> ['.$lvl.']';
		return $r;
}

function getmonth($F)
{
	switch($F)
	{
		case 'January':  $str = '������'; break;
		case 'February':  $str = '�������'; break;
		case 'March':  $str = '�����'; break;
		case 'April':  $str = '������'; break;
		case 'May':  $str = '���'; break;
		case 'June':  $str = '����'; break;
		case 'July':  $str = '����'; break;
		case 'August':  $str = '�������'; break;
		case 'September':  $str = '��������'; break;
		case 'October':  $str = '�������'; break;
		case 'November':  $str = '������'; break;
		case 'December':  $str = '�������'; break;
    }

    return $str;

}
?>
