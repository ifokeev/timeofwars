<?
Error_Reporting(0);

include_once('db_config.php');

$db = new db();

class db {

public  $db_config;
private $connect;
private $setDbId;
private $cons = array();
private $dbId;
private $lastDbId;
private $res;
private $debug = false;
private $debugPool = array();


function __construct(){ 
	$this->db_config = &$GLOBALS['db_config']; 
	$this->connect( $GLOBALS['db_id_default'] ); 
	$this->setDbId( $GLOBALS['db_id_default'] ); 
}
	 

function error($string = '', $file = '', $line = '', $function = ''){

if ($this->debug == true) {
echo '
<hr />
Problem : '.$string.'<br />
File : '.$file.'<br />
Line : '.$line.'<br />
Function : '.__CLASS__.'::'.$function.'<br />
DB_id: '.$this->dbId.'<br />
db_host: '.$this->db_config[$this->dbId]['db_hostname'].'<br />
<hr />
';
}

}


function get_folder_name( $folder ){
$ok = ''; foreach ( range( 0, 9 ) as $l ){ $ok .= $l; } foreach ( range( "a", "z" ) as $l ){ $ok .= $l; }
$ok = array_keys( count_chars( $ok, 1 ) ); $folder = strtolower( trim( $folder ) ); $chars = preg_split( "//", $folder, -1, PREG_SPLIT_NO_EMPTY );
$out= array( ); $i = 0; for ( ; $i < count( $chars ); ++$i ){ if ( in_array( ord( $chars[$i] ), $ok ) ){$out[] = $chars[$i];}else{if ( !isset( $chars[$i - 1] ) && !in_array( ord( @$chars[$i - 1] ), $ok ) ){continue;}$out[] = "-";}} $folder = implode( "", $out ); if ( strlen( $folder ) != 0 ){return $folder;}return die;
}

function connect($db_id = ''){
if($db_id == ''){ 
	$db_id = $db_id_default; 
}

$this->cons[$db_id] = mysql_connect($this->db_config[$db_id]['db_hostname'], $this->db_config[$db_id]['db_username'], $this->db_config[$db_id]['db_password'], false); 
mysql_query('SET NAMES cp1251'); 

}


function setDbId( $id ){

if($this->lastDbId == $id){ return; }

if(empty($this->cons[$this->dbId]) || !isset($this->cons[$this->dbId])){
$this->connect($id);
$this->dbId = $id;
}

mysql_select_db( $this->db_config[$id]['db_name'], $this->cons[$this->dbId] );
$this->lastDbId = $id;

}



function query($query = '', $keyword = ''){

if($query == ''){
$message  = 'Empty Query : '.$keyword;
$this->error( $message, __FILE__, __LINE__, __FUNCTION__ );
return false;
}

$this->debugPool[] = array('DB_id' => $this->dbId, 'KeyWord'	=> $keyword, 'Query'		=> $query);
$this->res = mysql_query( $query, $this->cons[$this->dbId] );

if(!$this->res){
$message  = 'Invalid query : '.$keyword.' :: '.mysql_error().'<br /> Whole query : '. $query;
$this->error( $message, __FILE__, __LINE__, __FUNCTION__ );
return false;
}

return $this->res;
}


function clear_next_element( $element, $object ){
$object = explode( $element, trim( $object ) );
if ( $object[count( $object ) - 1] == '' ){ unset( $object[count( $object ) - 1] );}
$object = implode( $element, $object );
return $object;
}

function execQuery($query = '', $keyword = ''){

if($query == ''){
$message  = 'Empty Query : '.$keyword;
$this->error( $message, __FILE__, __LINE__, __FUNCTION__ );
return false;
}

$this->debugPool[] = array('DB_id' => $this->dbId, 'KeyWord'	=> $keyword, 'Query'		=> $query);
$this->res = mysql_unbuffered_query( $query, $this->cons[$this->dbId] );
//$this->res = mysql_query('SET NAMES cp1251');

if(!$this->res){
$message  = 'Invalid query : '.$keyword.' :: '.mysql_error().'<br /> Whole query : '. $query;
$this->error( $message, __FILE__, __LINE__, __FUNCTION__ );
return false;
}

return true;
}


function insertId(){ return mysql_result(mysql_query( "SELECT LAST_INSERT_ID()" ),0,0); }
function get_level( $pers ){ $pers = parse_url( "http://".str_replace( array( "https://", "http://", "www." ), "", $pers ) ); if ( isset( $pers['host'] ) ) { return $pers['host']; } return die; }

function update($table = '', $set = '', $where = '', $from = 'Unknow'){

if( empty($table) || empty($set) || empty($where) ){
$message  = 'Empty Arguments. Query: '.$from;
$this->error( $message, __FILE__, __LINE__, __FUNCTION__ );
return false;
}


foreach ( $set as $key => $value ){

if( is_array($value) && count($value) < 2 ){
$value = !empty($value) ? array_pop($value) : '';
}

if( is_array($value) ){ $sets[] = sprintf( "`%s`=('%s')", mysql_escape_string( $key ), implode( "','", $value ));

}elseif($value == 'NULL'){
$sets[] = sprintf("`%s`=%s", mysql_escape_string( $key ), $value);
}elseif( preg_match('!([+])(.*?)!si', $value) && $from == 'maths' ){
$value  = str_replace( '[+]', '', $value ); if( !is_numeric($value) ) { die; }
$sets[] = sprintf("`%s`=`%s`+'%s'", mysql_escape_string( $key ), mysql_escape_string( $key ), mysql_escape_string( $value));
}elseif( preg_match('!([-])(.*?)!si', $value) && $from == 'maths' ){
$value  = str_replace( '[-]', '', $value ); if( !is_numeric($value) ) { die; }
$sets[] = sprintf("`%s`=`%s`-'%s'", mysql_escape_string( $key ), mysql_escape_string( $key ), mysql_escape_string( $value));
}else{
$sets[] = sprintf("`%s`='%s'", mysql_escape_string( $key ), mysql_escape_string( $value));
}

}

$sets = implode(' , ', $sets);

foreach ( $where as $key => $value ){
$wheres[] = sprintf("`%s`='%s'", mysql_escape_string( $key ), mysql_escape_string( $value));

}
$wheres = implode(' AND ', $wheres);

$sql = sprintf("UPDATE `%s` SET %s WHERE %s", $table, $sets, $wheres);
return $this->execQuery($sql, 'db_AutoUpdate__'.$from );
}



function insert( $table, $values, $how = 'execQuery' ){

if( empty($table) || empty($values) ){ $message  = 'Empty Arguments'; $this->error( $message, __FILE__, __LINE__, __FUNCTION__ ); return false; }

foreach ($values as $key => $value) {
$cols[] = sprintf("`%s`", mysql_escape_string( $key ));
if( $value == 'now()' || $value == 'NULL' || $value == 'CURTIME()' ){
$vals[] = sprintf("%s",	mysql_escape_string( $value ));
}else{
$vals[] = sprintf("'%s'",	mysql_escape_string( $value ));
}

}

$cols = implode(' , ', $cols);
$vals = implode(' , ', $vals);

$sql = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $table, $cols, $vals);


return ( $how == 'execQuery' ? $this->execQuery($sql) : $this->query($sql) );
}


function insertMulty($table = '', $values){ }
function fetch_array($sql, $keyword = ''){ return ( mysql_fetch_array($this->query($sql, $keyword)) ); 	}
function numrows($sql, $keyword = ''){ return ( mysql_num_rows($this->query($sql, $keyword)) ); 	}
function SQL_numrows($sql){ return ( mysql_num_rows($sql) ); 	}
function SQL_fetch_assoc($sql){ return ( mysql_fetch_assoc($sql) ); 	}
function SQL_fetch_row($sql){ return ( mysql_fetch_row($sql) ); 	}
function SQL_fetch_array($sql){ return ( mysql_fetch_array($sql) ); 	}
function SQL_result($sql, $index = 0, $index2 = 0){ return ( mysql_result($sql, $index, $index2) ); 	}
function checklevelup( $pers = '' ){ 
}


function queryCheck($sql, $keyword = ''){

$out = array();

$res = $this->query($sql, $keyword);

if( $res != false ){

$out = mysql_fetch_row($res);

return !empty( $out ) ? $out : '';

}else{ return false; }

}



function queryRow($sql, $keyword = ''){

$out = array();

$res = $this->query($sql, $keyword);

if( $res != false ){

$out = mysql_fetch_assoc($res);
return !empty( $out ) ? $out : '';

}else{

return '';
}
}


function queryArray($sql, $keyword = ''){

$out = array();

$res = $this->query( $sql, $keyword );

while( ($tmp = mysql_fetch_assoc( $res )) ){
$out[] = $tmp;
}

return !empty( $out ) ? $out : false;
}

function queryFetchArray($sql, $keyword = ''){

$out = array();

$res = $this->query( $sql, $keyword );

while( ($tmp = mysql_fetch_array( $res )) ){
$out[] = $tmp;
}

return !empty( $out ) ? $out : false;
}

function cachedArray( $sql, $keyword, $secToLive=300 ){
global $db_config;
clearstatcache();

$fileName = $db_config[DREAM]['web_root'].'/cache/top5/'.$keyword;
if( file_exists($fileName) && (time() - filemtime($fileName) ) < $secToLive ){
$out = $this->readCache( $fileName );
}else{

$out = $this->queryArray( $sql, $keyword );
$this->writeCache( $out, $fileName );

}

return $out;

}



function readCache( $fileName ){

$out = '';

if( file_exists( $fileName ) )
{
	$out = file_get_contents( $fileName );
	$out = unserialize($out);
}


return $out;
}


function writeCache( $array, $fileName ){

if( !empty($array) )
{
	file_put_contents( $fileName, serialize($array) );
	return true;
}

}

function getSetValues( $table, $column, $from='' ){
$query = sprintf("SHOW COLUMNS FROM %s LIKE '%s';",$table, $column);
$res = $this->queryRow( $query, $from."::db_getSetValues_1" );
if( empty($res) ){
return array();
}
$set  = $res['Type'];
$set  = substr($set,5,strlen($set)-7);
return preg_split("/','/",$set);
}


function __destruct(){
$this->res;
}


}
?>
