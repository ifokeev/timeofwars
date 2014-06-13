<?

function dlogin($name, $level, $align, $clan){
global $db_config;
$s      = '';
$rank   = 0;
$alpict = '';

if( $align < 10 ){
switch($align){
case 0: $alpict = '#5A5AA1'; break;
case 1: $alpict = '#D9A7A7'; break;
case 2: $alpict = '#A7D9A7'; break;
case 3: $alpict = '#A7D9D2'; break;
case 4: $alpict = '#5A5AA1'; break;
case 5: $alpict = '#5A5AA1'; break;
}

} else if( $clan > 0 ){

$rank = ($align - $clan*10);
$rank = ($rank > 0) ? $rank : 0;
$align = 0;

} else {

$align = 0;

}


$s .= '<a href="javascript:top.AddToPrivate(\''.$name.'\', true)"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/private.gif" border="0" title="Private" /></a>';

if( $clan > 0 ){
$s .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clan.'" target="_blank">';
$s .= '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clan.'.gif" width="24px" height="15px" alt="" /></a>';
} else {
$s .= '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/1pix.gif" width="24px" height="15" alt="" />';
}

if( $align == 0 ){
if( !empty($glava) && $glava == 1 ){ $s .= '<a href="javascript:void(0);" onclick="a_click();"><u>'.$name.'</u></a>['.$level.']'; }
else{              $s .= '<a href="javascript:void(0);" onclick="a_click();">'.$name.'</a>['.$level.']';        }
} else {
$s .= '<a href="javascript:void(0)" onclick="a_click()"><font style="BACKGROUND-COLOR: '.$alpict.'">'.$name.'</font></a>['.$level.']';
}


$s .= '<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$name.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" width="12px" height="12px" title="info '.$name.'" /></a>';

$s .= '&nbsp;&nbsp;';

return $s;
}


function turnir_msg ( $msg )
{
	global $db_config;

	$files = scandir($db_config[DREAM]['web_root'].'/chat');
	foreach($files as $file)
	{
		if (preg_match("/.txt/i", $file))
		{
			$file = str_replace( '.txt', '', $file );
            $chat = new ChatSendMessages('Информация', $file, 0);
			$chat->sendMessage( '<font color="red">Турнир</font>', $msg );
		}
	}


}

function turnir_log( $turnir_id, $msg )
{
	global $db_config;
	$file = fopen( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $turnir_id, 'a' );
	fwrite( $file, '<li>'.$msg.'</li>' );
	fclose( $file );

}

function wslogin( $user, $lvl, $clanid )
{   global $db_config;
    $r = '';
	if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';

	$r .= '<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$user.'" target="_blank">'.$user.'</a> ['.$lvl.']';
	return $r;
}

?>