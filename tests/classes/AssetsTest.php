<?php

class AssetsTest extends Unittest_TestCase {

	protected $_config_group = 'default';

	public function test_add_by_config_definition()
	{
		$assets = Assets::instance($this->_config_group, $this->get_sample_config($this->_config_group));

		$assets->add('mootools.core');

		$this->assertEquals(
			array(
				'assets/test/mootools/mootools-core-1.4.5.js'
			),
			$assets->scripts()
		);

		$assets->add('widgets.slider.js');
		$this->assertEquals(
			array(
				'assets/test/mootools/mootools-core-1.4.5.js',
				'assets/test/mootools/mootools-more-1.4.js',
				'assets/test/widgets/slider/slider.js',
			),
			$assets->scripts(),
			'Check that required files are added in proper order'
		);

		$assets->remove_all();
	}

	protected function get_sample_config($config_name = 'default')
	{
		return Kohana::load(dirname(__FILE__).'/../test_data/config/'.$config_name.'.php');
	}

}
