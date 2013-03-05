<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 05.03.2013
 * Time: 12:45:16
 *
 */
App::uses('ICachedObject', 'Caching.Lib');

/**
 * Caching wrapper for Subject methods
 */
class CachedObject implements ICachedObject {

	/**
	 * Cached object
	 *
	 * @var object
	 */
	protected $_Subject = null;

	/**
	 * Cache name or config
	 *
	 * @var string|array
	 */
	protected $_cache = null;

	/**
	 * Constructor
	 *
	 * @param object $Subject
	 * @param string|array $cache
	 * @throws InvalidArgumentException
	 */
	public function __construct($Subject, $cache) {
		if (!is_object($Subject)) {
			throw new InvalidArgumentException('Subject of ICachedObject must be object!');
		}
		$this->_Subject = $Subject;
		$this->_cache = $cache;
	}

	/**
	 * Wrapper for Subject methods
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($name, $arguments) {
		$callback = array($this->_Subject, $name);
		if (method_exists($this->_Subject, $name)) {
			return $this->_invokeCached($name, $callback, $arguments);
		} else {
			return call_user_func_array($callback, $arguments);
		}
	}

	/**
	 * Wrapper for Subject property get
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		return $this->_Subject->{$name};
	}

	/**
	 * Wrapper for Subject property set
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		$this->_Subject->{$name} = $value;
	}

	/**
	 * Wrapper for Subject property isset
	 *
	 * @param string $name
	 * @return bool
	 */
	public function __isset($name) {
		return isset($this->_Subject->{$name});
	}

	/**
	 * Do not need to wrap cached wrapper
	 *
	 * @return ICachedObject
	 */
	public function cached() {
		return $this;
	}

	/**
	 * Save value to cache
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return bool True if success
	 */
	protected function _cacheSave($key, $value) {
		return Cache::write($key, $value, $this->_cache);
	}

	/**
	 * Get value from cache
	 *
	 * @param string $key
	 *
	 * @return mixed Null if not found
	 */
	protected function _cacheRead($key) {
		return Cache::read($key, $this->_cache);
	}

	/**
	 * Generate caching key
	 *
	 * @param string $name Method or property name
	 * @param array $value Value, default array()
	 * @return string Key for caching
	 */
	protected function _cacheKey($name, $value = array()) {
		return get_class($this->_Subject) . $name . md5(serialize($value));
	}

	/**
	 * If data exist in cache - returns it, otherwise
	 * invokes $callback, save to cache and return value
	 *
	 * @param string $name Method or property name
	 * @param callable $callback Data source
	 * @param array $arguments Arguments for callback
	 * @return mixed
	 */
	protected function _invokeCached($name, callable $callback, array $arguments = array()) {
		$cacheKey = $this->_cacheKey($name, $arguments);
		$data = $this->_cacheRead($cacheKey);
		if ($data) {
			return $data;
		}
		$data = call_user_func_array($callback, $arguments);
		$this->_cacheSave($cacheKey, $data);
		return $data;
	}

}