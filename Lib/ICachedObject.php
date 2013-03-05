<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 05.03.2013
 * Time: 14:24:43
 *
 */
interface ICachedObject {

	/**
	 * Constructor
	 *
	 * @param object $Subject
	 * @param string|array $cache
	 * @throws InvalidArgumentException
	 */
	public function __construct($Subject, $cache);

	/**
	 * Do not need to wrap cached wrapper
	 *
	 * @return ICachedObject
	 */
	public function cached();
}