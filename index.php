<?php
/**
 * Created by PhpStorm.
 * User: ManOfWind
 * Date: 7/22/2016
 * Time: 3:33 PM
 */



// Make sure we are running PHP5.
if (version_compare(phpversion(), '5.6', '<') === true)
{
    exit('Divergent requires PHP 5.4 or newer.');
}
ob_start();


/**
 * Key to include DIVERGENT
 *
 */
define('DIVERGENT', true);

/**
 * Directory Seperator
 *
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Divergent Root Directory
 *
 */
define('DIVERGENT_DIR', dirname(__FILE__) . CDF_DS);

require(DIVERGENT_DIR . 'Kerel' . DS . 'Bootstrap.php');

ob_end_flush();
