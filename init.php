<?php defined('SYSPATH') or die('No direct script access.');

// Static file serving (CSS, JS, images)
Route::set('assets/serve', 'assets/<file>', array('file' => '[a-zA-Z\d\_\-\/\.]+\.[a-z\d]{2,4}'))
	->defaults(array(
	'controller' => 'Assets',
	'action'     => 'serve',
	'file'       => NULL,
));
