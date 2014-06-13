<?php
class SystemMessages {

function __construct( ){ }
	
public static function getMessagesAll( ){
global $db;
		
$query = sprintf("SELECT Num as id_message, Message, room, `Count` as amount FROM ".SQL_PREFIX."sys_messages;");
return $db->queryArray( $query, "SystemMessages_getMessagesAll_1" );
}
	
	
public static function getMessageById( $id_message ){
global $db;
		
$query = sprintf("SELECT Message, room, `Count` FROM ".SQL_PREFIX."sys_messages WHERE Num = '%d';", $id_message);
return $db->queryRow( $query, "SystemMessages_getMessageById_1" );
}
	
	
public static function createMessage( $body, $room, $count=0 ){
global $db;
		
$query = sprintf("INSERT INTO sys_messages ( `Message`, `room`, `Count` ) VALUES ( '%s', '%s', '%d' );", mysql_escape_string($body), mysql_escape_string($room), $count);
$db->execQuery( $query, "SystemMessages_createMessage_1" );
		
return $db->insertId();
}
	

public static function updateMessage( $id_message, $params ){
global $db;
return $db->update( SQL_PREFIX."sys_messages", $params, array( 'Num' => $id_message ), "SystemMessages_updateMessage_1" );
}
	
	
public static function deleteMessage( $id_message ){
global $db;
		
$query = sprintf("DELETE FROM ".SQL_PREFIX."sys_messages WHERE `Num` = '%d';", $id_message );
return $db->execQuery( $query, "SystemMessages_deleteMessage_1" );
}


}
?>
