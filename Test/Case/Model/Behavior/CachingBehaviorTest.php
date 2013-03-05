<?

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 05.03.2013
 * Time: 12:13:44
 * Format: http://book.cakephp.org/2.0/en/development/testing.html
 */
App::uses('Model', 'Model');
App::uses('CachingBehavior', 'Caching.Model/Behavior');

require_once dirname(__DIR__) . DS . 'models.php';

class CachingBehaviorTest extends CakeTestCase {

	/**
	 * Cache config
	 *
	 * @var string
	 */
	public $cacheConfig = null;

	public function setUp() {
		parent::setUp();
		$this->cacheConfig = 'CachingBehaviorTest';
		Cache::config($this->cacheConfig, array(
			'engine' => 'File',
			'prefix' => 'CachingBehaviorTest',
			'path' => CACHE,
			'mask' => 0777,
			'serialize' => true,
			'duration' => '+1 second'
		));
	}

	public function testCache() {
		$Model = $this->getMock('CachingBehaviorTestModel', array(
			'something'
		));
		$value = 5;
		$Model->expects($this->once())->method('something')->will($this->returnValue($value));

		for ($i = 0; $i < 2; $i++) {
			$this->assertSame($value, $Model->cached($this->cacheConfig)->something(2, 3));
		}
	}

	public function testCacheExpired() {
		$Model = $this->getMock('CachingBehaviorTestModel', array(
			'something'
		));
		$value = 5;
		$Model->expects($this->exactly(2))->method('something')->will($this->returnValue($value));

		for ($i = 0; $i < 2; $i++) {
			$this->assertSame($value, $Model->cached($this->cacheConfig)->something(3, 2));
			sleep(2);
		}
	}

	public function testGlobalCache() {
		$Model = new CachingBehaviorTestModel2();
		$CachedModel = $Model->cached();
		$this->assertSame($Model->actsAs['Caching.Caching']['cache'], $CachedModel->cacheConfig());
	}

	public function testDefaultCache() {
		$Model = new CachingBehaviorTestModel3();
		$CachedModel = $Model->cached();
		$this->assertSame('default', $CachedModel->cacheConfig());
	}

}