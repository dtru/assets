UpSolution assets module
========================

Usage
-----

**STEP 1**. Describe static files in *config/assets.php*:

```php
return array(
	'cms' => array(
		'jquery' => array(
			'core' => array(
				'files' => array('assets/cms/js/jquery-1.7.2.min.js'),
			),
		),

		// Twitter bootstrap
		'bootstrap' => array(
			'style' => array(
				'files' => array('assets/cms/css/bootstrap.css'),
			),
			'script' => array(
				'files' => array('assets/cms/js/bootstrap.js'),
				'requires' => array('jquery'),
			),
		),
	),
);
```

**STEP 2**. Add required files (in Controller or somewhere else):

```php
Assets::instance('cms')->add('bootstrap');
```

**STEP 3**. Grab the code to paste to page

```php
echo Assets::instance('cms');
```

OR 

```php
$code = Assets::instance('cms')->output();
```
