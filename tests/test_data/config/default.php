<?php
return array(
	// JQuery
	'jquery' => array(
		'file' => 'assets/test/jquery/jquery-1.7.2.min.js',
	),

	// MooTools
	'mootools' => array(
		'core' => array(
			'file' => 'assets/test/mootools/mootools-core-1.4.5.js',
		),
		'more' => array(
			'file' => 'assets/test/mootools/mootools-more-1.4.js',
			'reqiures' => array('mootools.core'),
		),
	),

	// Twitter bootstrap
	'bootstrap' => array(
		'style' => array(
			'file' => 'assets/test/bootstrap/bootstrap.css',
		),
		'script'  => array(
			'file' => 'assets/test/bootstrap/bootstrap.js',
			'requires' => array('jquery'),
		),
	),

	// Some widgets
	'widgets' => array(
		'slider' => array(
			'js' => array(
				'file' => 'assets/test/widgets/slider/slider.js',
				'requires' => array('mootools.more'),
			),
			'css' => array(
				'file' => 'assets/test/widgets/slider/slider.css',
				'requires' => array('bootstrap'),
			),
		),
	),
);
