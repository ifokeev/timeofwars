<?php
class ClanAbility {
var $abils;


function ClanAbility( ){
		
$this->abils[12]['CRITICAL']['TYPE']		= 'PERCENT';
$this->abils[12]['CRITICAL']['AMOUNT']		= 30;
$this->abils[12]['CRITICAL']['PROBABILITY']	= 100;
		
$this->abils[8]['CRITICAL']['TYPE']			= 'PERCENT';
$this->abils[8]['CRITICAL']['AMOUNT']		= 30;
$this->abils[8]['CRITICAL']['PROBABILITY']	= 100;
		
$this->abils[41]['CRITICAL']['TYPE']		= 'PERCENT';
$this->abils[41]['CRITICAL']['AMOUNT']		= 30;
$this->abils[41]['CRITICAL']['PROBABILITY']	= 100;
		
$this->abils[18]['DAMAGE']['TYPE']			= 'PERCENT';
$this->abils[18]['DAMAGE']['AMOUNT']		= 25;
$this->abils[18]['DAMAGE']['PROBABILITY']	= 32;

$this->abils[29]['DAMAGE']['TYPE']			= 'PERCENT';
$this->abils[29]['DAMAGE']['AMOUNT']		= 23;
$this->abils[29]['DAMAGE']['PROBABILITY']	= 33;
		
$this->abils[7]['DAMAGE']['TYPE']			= 'MULTY';
$this->abils[7]['DAMAGE']['AMOUNT']			= 2;
$this->abils[7]['DAMAGE']['PROBABILITY']	= 10;
		
$this->abils[29]['DAMAGE']['TYPE']			= 'VAMPIRE';
$this->abils[29]['DAMAGE']['AMOUNT']		= 0.25;
$this->abils[29]['DAMAGE']['PROBABILITY']	= 30;
		
$this->abils[26]['ARMOR']['TYPE']			= 'ADD';
$this->abils[26]['ARMOR']['AMOUNT']			= 0;
$this->abils[26]['ARMOR']['PROBABILITY']	= 100;
		
}
	
	
function getDamage( $userBattle ){
return $this->calcAmount( $this->abils[$id_clan]['DAMAGE'], $source );
}
	

function calcAmount( &$params, $source ){
if( $params['PROBABILITY'] < rand( 0 , 100 ) ){
return $source;
}
		
switch ( $params['TYPE'] ){
case 'PERCENT'	:	return ( $source * $params['AMOUNT']);
case 'ADD'		  :	return ( $source + $params['AMOUNT']);
case 'VAMPIRE'	:	return ( $source * $params['AMOUNT']);
}


}

}
?>
