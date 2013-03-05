CakePHP Caching Behaviour
==============================

Caching Behaviour for CakePHP 2.1+

Use it if you want to wrap model methods with cache.
For example you can use this for heavy model methods,
that can't change output value for some time, but you need to invoke them very often.

## Installation

	cd my_cake_app/app
	git clone git://github.com/imsamurai/cakephp-caching-behavior.git Plugin/Caching

or if you use git add as submodule:

	cd my_cake_app
	git submodule add "git://github.com/imsamurai/cakephp-caching-behavior.git" "app/Plugin/Caching"

then add plugin loading in Config/bootstrap.php

	CakePlugin::load('Caching');

## Configuration

Attach behaviour to model:

	public $actsAs = array(
	      'Caching.Caching' => array(
	        'cache' => <valid cache config or name>, // optional
			'cachedObject' => <name of object class> // optional
	      )
	);

If cache is not specified in config and method `cache()` used 'default' cache config.
By default for 'cachedObject' used 'Caching.CachedObject' that stored in Lib folder. You can use your own class, that
must be in Lib folder of app or plugin. But remember that your class must have same interface.

## Usage

After attaching behavior to your model you can do (assuming your model has methods `something()` and `somethingElse()`):

	$Model->cached()->something(/*args*/);

or

	$Model->cached(/*cache name*/)->something(/*args*/);

or

	$CachedModel = $Model->cached(/*cache name or empty*/);
	$CachedModel->something(/*args*/);
    $CachedModel->somethingElse(/*args*/);

`$Model->cached()` returns object-wrapper that use magick methods and caching. So if expire date is ok,
and you invoke same cached methods with same arguments and same cache config then model method calls
only once.