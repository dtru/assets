<?php defined('SYSPATH') or die('No direct script access.');

// Static file serving (CSS, JS, images)
Route::set('assets/serve', 'assets/<file>', array('file' => '[a-z\d\_\-\/\.]+\.[a-z\d]{2,4}'))
	->defaults(array(
	'controller' => 'assets',
	'action'     => 'serve',
	'file'       => NULL,
));
