<?php


defined('DIVERGENT') or exit('NO DICE!');


@ini_set('memory_limit', '-1');
@set_time_limit(0);

if (!isset($_SERVER['HTTP_USER_AGENT']))
{
	$_SERVER['HTTP_USER_AGENT'] = '';
}

// Start the debug
define('DIVERGENT_MEM_START', memory_get_usage());
define('DIVERGENT_TIME_START', array_sum(explode(' ', microtime())));

// Fix for foreign characters when server is set to receive other charset (http://www.w3.org/International/O-HTTP-charset)
header('Content-type: text/html; charset=utf-8');

require_once(DIVERGENT_DIR . 'App' . DS . 'Config' . DS . 'Constant.php');

require_once(DIVERGENT_DIR_LIB . 'autoload.php');



?>