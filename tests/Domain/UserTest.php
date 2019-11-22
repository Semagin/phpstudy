<?php

namespace Gbk\Domain;

use Gbk\Domain\User;
use PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase {
	public function testGetId () {
		$tester = new User (1,"qwe","qwe","qwe","qwe");
		$this->assertSame(1, $tester->getId());
	}
}