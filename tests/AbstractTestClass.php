<?php

namespace Gbk\Tests;

use PHPUnit_Framework_TestCase;
use InvalidArgumentException;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase {
	
	protected function mock(string $className) {
		if (strpos($className, '\\') !== 0) {
			$className = '\\' . $className;
		}
		if (!class_exists($className)) {
			$className = '\Gbk\\' . trim($className, '\\');
			if (!class_exists($className)) {
				throw new InvalidArgumentException("Class $className not found.");
			}
		}
		return $this->getMockBuilder($className)->disableOriginalConstructor()->getMock();
	}
}