<?
class write_to_log
{	private $sxe;
	public $battle_id;
	private $file;
	function __construct($battle_id)
	{		global $db_config;

		    if( !is_numeric($battle_id) ) die('error');

		    $this->battle_id = $battle_id;			$this->file = $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'battles' . DIRECTORY_SEPARATOR . $this->battle_id . '.xml';
			if( !file_exists($this->file) ) die('Лога не найдено');

			$xmlstr = file_get_contents( $this->file );
			$this->sxe = new SimpleXMLElement($xmlstr);
	}

	public function from_xml($str)
	{
		$str = str_replace( '&apos;', "'", $str );
		$str = str_replace( '&lt;', '<', $str );
		$str = str_replace( '&gt;', '>', $str );
		$str = str_replace( '&quot;', '"', $str );
		$str = str_replace( '&amp;', '&', $str );
		return $str;
	}

	public function to_xml($str)
	{
		$str = trim($str);
		$str = str_replace( "'", '&apos;', $str );
		$str = str_replace( '<', '&lt;', $str );
		$str = str_replace( '>', '&gt;', $str );
		$str = str_replace( '"', '&quot;', $str );
		$str = str_replace( '&', '&amp;', $str );
		return $str;
	}

	public function add_log( $str, $step, $param = 0 )
	{
		$str = $this->to_xml($str);
		$str = iconv( 'windows-1251', 'UTF-8', $str );

        $sxe = $this->sxe;
		$log = $sxe->log;

		if( $param == 0 )
			$par = $log->addChild( 'str', $str );
        elseif( $param == 1 )
        	$par = $log->addChild( 'death', $str );
        elseif( $param == 2 )
            $par = $log->addChild( 'abil', $str );

		$par->addAttribute('step', $step);

		file_put_contents( $this->file, $sxe->asXML() );
	}

	public function add_user_to_team( $user, $team )
	{		$user = iconv( 'windows-1251', 'UTF-8', $user );
		$sxe = $this->sxe;
        $sxe->{'team'.$team}[0] .= ', '.$user;
		file_put_contents( $this->file, $sxe->asXML() );
	}

	public function read_log()
	{
		$sxe = $this->sxe;

    	$log   = array();
    	$death = array();
    	$abil  = array();

    	for( $i = 1; $i <= (count($sxe->log->str)-1); $i++ )
    	{
    		$sxe->log->str[$i] = iconv( 'UTF-8', 'windows-1251', $sxe->log->str[$i] );
        	$step = intval(trim($sxe->log->str[$i]->attributes()->step));
    		$log[$step][] = (string) trim($sxe->log->str[$i]);

    	}

    	for( $i = 0; $i < count($sxe->log->death); $i++ )
    	{
    		$sxe->log->death[$i] = iconv( 'UTF-8', 'windows-1251', $sxe->log->death[$i] );
        	$step = intval(trim($sxe->log->death[$i]->attributes()->step));
    		$death[$step][] = (string) trim($sxe->log->death[$i]);

    	}

    	for( $i = 0; $i < count($sxe->log->abil); $i++ )
    	{
    		$sxe->log->abil[$i] = iconv( 'UTF-8', 'windows-1251', $sxe->log->abil[$i] );
        	$step = intval(trim($sxe->log->abil[$i]->attributes()->step));
    		$abil[$step][] = (string) trim($sxe->log->abil[$i]);

    	}
    	return array( 'team1' => iconv( 'UTF-8', 'windows-1251', $sxe->team1), 'team2' => iconv( 'UTF-8', 'windows-1251', $sxe->team2),
    	'nachalo' => iconv( 'UTF-8', 'windows-1251', $sxe->log->str[0] ), 'log' => $log, 'death' => $death, 'abil' => $abil );

	}



	public function make_log( $Iam, $enemy, $damage, $kick, $he_blocked, $critanul, $block_crit, $uvernulsa, $step, $newhp, $hpall )
	{
		switch( $kick )
		{
			case 1: $kuda = 'голову'; break;
			case 2: $kuda = 'корпус'; break;
			case 3: $kuda = 'пояс'; break;
			case 4: $kuda = 'ноги'; break;
    	}

        if( $newhp < 0 ) $newhp = 0;

     	$str = $Iam.' ударил '.$enemy.' в '.$kuda.'. -'.$damage.' HP ['.$newhp.'/'.$hpall.']';

    	if( !empty($he_blocked) )
    	{
    		if( empty($block_crit) ) $str =  $Iam.' ударил '.$enemy.' в '.$kuda.', но тот заблокировал удар.';
    		else $str =  $Iam.' <font color=red>мощнейшим ударом в '.$kuda.' пробил блок</font> '.$enemy.'<font color=red>. -'.$damage.' HP ['.$newhp.'/'.$hpall.']</font>';
    	}
    	else
    	{
    		if( !empty($critanul) ) $str =  $Iam.' <font color=red>поразил</font> '.$enemy.' <font color=red>мощнейшим ударом в '.$kuda.'. -'.$damage.' HP ['.$newhp.'/'.$hpall.']</font>';
    		if( !empty($uvernulsa) ) $str = $Iam.' пытался ударить '.$enemy.' в '.$kuda.', но тот увернулся.';
    		if( !empty($set_dead) ) $str = $Iam.' ударил '.$enemy.' в '.$kuda.'. -'.$damage.' HP [0/'.$hpall.'].';
    	}


    	$this->add_log( get_date().$str, $step );

    	//if( !empty($set_dead) ) return '<strong>'.$enemy.' убит.</strong>';
	}
}
?>