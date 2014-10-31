<?php
/**
 * TODO Look at https://github.com/alxlit/kohana-assets examples of vendor compiler usages
 */

class US_Assets {

	/**
	 * @var string default instance name
	 */
	public static $default = 'default';

	/**
	 * @var array Assets instances
	 */
	public static $instances = array();

	/**
	 * Get a singleton Assets instance.
	 *
	 * @param string $name Instance name
	 * @param array $config Predefault config for this instance
	 * @return Assets
	 */
	public static function instance($name = NULL, $config = NULL)
	{
		if ($name === NULL)
		{
			// Use the default instance name
			$name = Assets::$default;
		}

		if ( ! isset(Assets::$instances[$name]))
		{
			if ($config === NULL)
			{
				$config = Kohana::$config->load('assets')->$name;
			}

			// Create the Assets instance
			new Assets($name, $config);
		}

		return Assets::$instances[$name];
	}

	/**
	 * @var string Instance name
	 */
	protected $_instance;

	/**
	 * @var array Instance files configuration
	 */
	protected $config;

	/**
	 * @var array Included styles
	 */
	protected $_styles = array();

	/**
	 * @var array Included scripts
	 */
	protected $_scripts = array();

	/**
	 * @param $name
	 * @param $config
	 */
	protected function __construct($name, $config)
	{
		// Set the instance name
		$this->_instance = $name;

		// Set configuration
		$this->config = $config;

		// Store the Assets instance
		Assets::$instances[$name] = $this;
	}

	/**
	 * Add static file or group of files.
	 *
	 *     // Add predefined file (or group of files) from config including all dependencies.
	 *     $assets->add('jquery');
	 *
	 *     // Add static file inside the APPPATH
	 *     $assets->add('assets/admin/css/something.css');
	 *     $assets->add('vendor/something/css/something.css');
	 *
	 *     // Add all the files inside the specified directory (including subdirectories)
	 *     $assets->add('assets/admin/css/*');
	 *
	 *     // Add remote file
	 *     $assets->add('http://html5shim.googlecode.com/svn/trunk/html5.js');
	 *
	 * @param string $path
	 * @return self
	 * @throws Kohana_Exception
	 */
	public function add($path)
	{
		if (strpos($path, '/') === FALSE)
		{
			// Add predefined file from config
			$this->add_config_entry($path);
		}
		elseif (substr($path, -1) == '*')
		{
			// TODO Add all the files inside the specified directory
		}
		elseif (Valid::url($path))
		{
			// TODO Add remote file
		}
		else
		{
			$this->add_file($path);
			// TODO Add specified file by its path
		}

		return $this;
	}

	/**
	 * Add predefined config entry
	 *
	 * @param string $path
	 * @return mixed
	 * @throws Kohana_Exception
	 */
	protected function add_config_entry($path)
	{

		$entry = Arr::path($this->config, $path);
		if ( ! isset($entry) OR ! is_array($entry))
		{
			throw new Kohana_Exception('Assets entry :path not found in config', array(
				':path' => $path
			));
		}

		// Recursively add group children
		if ( ! isset($entry['files']) AND ! isset($entry['file']))
		{
			foreach ($entry as $key => $child)
			{
				if (is_array($child))
				{
					$this->add($path.'.'.$key);
				}
			}
			return;
		}

		// Add dependencies
		if (isset($entry['requires']) AND is_array($entry['requires']))
		{
			foreach ($entry['requires'] as $requirement)
			{
				$this->add($requirement);
			}
		}

		// Asset can be connected with a single file
		if (isset($entry['file']))
		{
			$this->add_file($entry['file']);
		}
		elseif (isset($entry['files']))
		{
			foreach ($entry['files'] as $assets_file)
			{
				$this->add_file($assets_file);
			}
		}
	}

	/**
	 * Simply add file by its path skipping duplicates.
	 *
	 * @param string $file_name Path to the file
	 * @throws Kohana_Exception if the file has unknown format
	 */
	protected function add_file($file_name)
	{
		if ( ! preg_match('~\.(css|js)$~', $file_name, $matches))
		{
			throw new Kohana_Exception('Unknown assets format: :file_name', array(
				':file_name' => $file_name
			));
		}

		switch ($matches[1])
		{
			case 'js':
				$container = & $this->_scripts;
				break;
			case 'css':
				$container = & $this->_styles;
				break;
		}

		if ( ! in_array($file_name, $container))
		{
			$container[] = $file_name;
		}
	}

	/**
	 * Get list of scripts
	 */
	public function scripts()
	{
		return $this->_scripts;
	}

	/**
	 * Get list of styles
	 */
	public function styles()
	{
		return $this->_styles;
	}

	public function __toString()
	{
		return $this->output();
	}

	/**
	 * Output inclusions of added files.
	 */
	public function output($indents = 2)
	{
		$output = array();

		foreach ($this->_styles as $style)
		{
			$output[] = HTML::style($style);
		}

		foreach ($this->_scripts as $script)
		{
			$output[] = HTML::script($script);
		}

		return implode("\n".str_repeat("\t", $indents), $output);
	}

	public function remove_file($file_name)
	{}

	public function remove_all()
	{
		$this->_scripts = array();
		$this->_styles = array();
	}

}
