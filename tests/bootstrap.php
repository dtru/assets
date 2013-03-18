<?php
/**
 * WARNING:
 * This bootstrap file can be used as a part of UpSolution Application only and cannot be used by itself.
 */

chdir(dirname(__FILE__).'/..');

/**
 * Active version of UpSolution/Kohana can be easily switched at this point.
 */
$version = array(
	'upsolution' => '2.0',
	'kohana'     => '3.2',
);

/**
 * Defining document root
 */
define('DOCROOT',  realpath('../../../site/0-unittest/www').DIRECTORY_SEPARATOR);

/**
 * Loading boot config
 */
if (file_exists(DOCROOT.'../config/boot.config.php'))
{
	$boot_config = require DOCROOT.'../config/boot.config.php';
}


/**
 * Initializing main bootstrap
 */
require DOCROOT.'../../../upsolution/'.$version['upsolution'].'/core/bootstrap.php';


define('SUPPRESS_REQUEST', TRUE);

