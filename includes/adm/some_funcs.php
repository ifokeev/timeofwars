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
		case 'January':  $str = 'ÿíâàğÿ'; break;
		case 'February':  $str = 'ôåâğàëÿ'; break;
		case 'March':  $str = 'ìàğòà'; break;
		case 'April':  $str = 'àïğåëÿ'; break;
		case 'May':  $str = 'ìàÿ'; break;
		case 'June':  $str = 'èşíÿ'; break;
		case 'July':  $str = 'èşëÿ'; break;
		case 'August':  $str = 'àâãóñòà'; break;
		case 'September':  $str = 'ñåíòÿáğÿ'; break;
		case 'October':  $str = 'îêòÿáğÿ'; break;
		case 'November':  $str = 'íîÿáğÿ'; break;
		case 'December':  $str = 'äåêàáğÿ'; break;
    }

    return $str;

}
?>
