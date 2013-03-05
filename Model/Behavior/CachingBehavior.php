<?

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 05.03.2013
 * Time: 12:02:25
 * Format: http://book.cakephp.org/2.0/en/models/behaviors.html
 */
App::uses('ICachedObject', 'Caching.Lib');

class CachingBehavior extends ModelBehavior {

	/**
	 * Contains configuration for each model
	 *
	 * @var array
	 */
	public $config = array();

	/**
	 * Initialize Caching Behavior
	 *
	 * @param Model $Model Model which uses behaviour
	 * @param array $config Behaviour config
	 */
	public function setup(Model $Model, $config = array()) {
		parent::setup($Model, $config);
		$this->config[$Model->alias] = $config + array(
			'cache' => 'default',
			'cachedObject' => 'Caching.CachedObject'
		);
	}

	/**
	 * Returns cache object wrapper for model
	 *
	 * @param Model $Model
	 * @param string|array $cache
	 * @return ICachedObject
	 */
	public function cached(Model $Model, $cache = null) {
		list($plugin, $class) = pluginSplit($this->config[$Model->alias]['cachedObject'], true);
		App::uses($class, $plugin . 'Lib');

		if (is_null($cache)) {
			$cache = $this->config[$Model->alias]['cache'];
		}

		if (!in_array('ICachedObject', class_implements($class), true)) {
			throw new RuntimeException("Class '$class' must implement interface ICachedObject");
		}

		return new $class($Model, $cache);
	}

}