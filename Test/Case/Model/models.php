<?

/**
 * Models for testing
 *
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 05.03.2013
 * Time: 12:14:01
 *
 */
class CachingBehaviorTestModel extends Model {

	/**
	 * Do not use table
	 *
	 * @var bool
	 */
	public $useTable = false;

	/**
	 * Behaviors
	 *
	 * @var array
	 */
	public $actsAs = array(
		'Caching.Caching'
	);

	/**
	 * Some method
	 *
	 * @param int $la
	 * @param int $lo
	 * @return int
	 */
	public function something($la, $lo) {
		return (int) $la + (int) $lo;
	}

}

class CachingBehaviorTestModel2 extends CachingBehaviorTestModel {

	/**
	 * Behaviors
	 *
	 * @var array
	 */
	public $actsAs = array(
		'Caching.Caching' => array(
			'cache' => 'somecachename',
			'cachedObject' => 'CachedObjectTest'
		)
	);

}

class CachingBehaviorTestModel3 extends CachingBehaviorTestModel {

	/**
	 * Behaviors
	 *
	 * @var array
	 */
	public $actsAs = array(
		'Caching.Caching' => array(
			'cachedObject' => 'CachedObjectTest'
		)
	);

}

App::uses('CachedObject', 'Caching.Lib');

class CachedObjectTest extends CachedObject {

	public function cacheConfig() {
		return $this->_cache;
	}

}