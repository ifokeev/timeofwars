<?php
require_once('classes' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $db_config[1]['name'].'TPL.class.php');

$options = array(
                'template_path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tow_templates',
                'cache_path'    => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache',
                'debug'         => false,
                );

$tow_tpl =& new TimeOfWarsTPL($options);
?>