<?PHP
class ChatRooms {

function ChatRooms( $rooms='' ) { }
	

function getRoomName( $room ){
$tmp = ChatRooms::getRoomParams( $room );
return $tmp['roomName'];
}
	
	
function getCurrentRoom( $room ){

if( ChatRooms::isValid($room) ){
if( ChatRooms::checkParams( ChatRooms::getRoomParams( $room ) ) ){ return $room; }
return 'newby';
} else {
die('Ошибка ввода данных. Комнаты '.$room.' не существует.');
}

}
	
	
function isValid( $room ){
global $Chat_Rooms;
return isset($Chat_Rooms[$room]);
}
	

function getRoomParams( $room ){
global $Chat_Rooms;

list($out['roomName'],$out['accessType'],$out['accessValue'],$out['clearTime']) = split("::",$Chat_Rooms[$room]);
return $out;

}
	

function checkParams( $params ){
global $User;
		
if( $params['accessType'] == 'N' ){ return true; }
elseif( $params['accessType'] == 'S' ){ if( $User->Sex != $params['accessValue'] ){ return false; } }
elseif( $params['accessType'] == 'L' ){ if( $User->Level < $params['accessValue'] ){ return false; } }
return true;

}

}
?>
