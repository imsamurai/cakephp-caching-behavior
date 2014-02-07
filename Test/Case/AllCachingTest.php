<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: Feb 7, 2014
 * Time: 4:31:03 PM
 * Format: http://book.cakephp.org/2.0/en/development/testing.html
 */

/**
 * AllCachingTest
 */
class AllCachingTest extends PHPUnit_Framework_TestSuite {

	/**
	 * 	All Caching tests suite
	 *
	 * @return PHPUnit_Framework_TestSuite the instance of PHPUnit_Framework_TestSuite
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All Caching Tests');
		$basePath = App::pluginPath('Caching') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($basePath);

		return $suite;
	}

}
