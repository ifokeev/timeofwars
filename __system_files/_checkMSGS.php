<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

error_reporting(E_ALL);

$t_mtime = split( " ", microtime() );
$time    = ( (intval( substr( $t_mtime[1], -6) ) + $t_mtime[0]) * 1000000 );

$files = scandir($db_config[DREAM]['web_root'].'/chat');
foreach($files as $file){
if (preg_match("/.txt/i", $file)) {

$msg    = file ($db_config[DREAM]['web_root'].'/chat/'.$file);
$fp     = fopen($db_config[DREAM]['web_root'].'/chat/'.$file, 'w');

if( !empty($msg) ){
foreach ($msg as $row) {
//начало
list($msg_time, $msg_text) = split('>>', $row);

if (($msg_time>($time - 300000000))&&(($msg_time - $time)<500000000000)) {
$row = trim($row)."\n";
fwrite($fp, $row);
}

//конец
}
}

fclose($fp);

//echo $file."\n";

}



}

?>
