<?
Error_Reporting(0);

define('AUTHDREAM',    1   );
define('DREAM',        1   );
define('DREAM_IMAGES', 100 );
define('SEPARATOR',    '/' );
define('SQL_PREFIX'	, 'timeofwars_' );

$currentcity = $db_id_default = DREAM;

$db_config =
array(
1   => array( 'name' => 'TimeOfWars', 'cityName' => 'Dream Town', 'server' => '[основной url]', 'other' => '[url для статики (js/css/images)]', 'db_hostname' => 'localhost', 'db_username' => 'root', 'db_password' => '', 'db_name' => 'tow', 'web_root' => '/var/www/tow/' ),
100 => array( 'name' => 'images', 'server' => '[url для картинок]','web_root'	=> '/var/www/tow/images' ),
101 => array( 'server' => '[сервер для загрузки картиинок (используется для аватаров)]', 'user' => 'ftpuser', 'pass' => 'ftppass' ),
);

set_include_path( $db_config[$currentcity]['web_root'] . SEPARATOR );

include('includes/theme.php');
include('includes/themedefine.php');
?>
