<?php

namespace Gbk\Tests\Domain\User;

use Gbk\Domain\User\UserFactory;
use PHPUnit_Framework_TestCase;

/**
 * 
 */
class UserFactoryTest extends PHPUnit_Framework_TestCase
{
	
	public function testFactory () {
		$testUser = UserFactory::factory('moderator',1,'ironman','tony','1@1.1','www');
		$this->assertInstanceOf('Gbk\Domain\User\moderator',$testUser, 'superuser should create User/SuperUser object');
		$testUser = UserFactory::factory('poster',1,'ironman','tony','1@1.1','www');
		$this->assertInstanceOf('Gbk\Domain\User\poster',$testUser, 'superuser should create User/SuperUser object');
		$testUser = UserFactory::factory('viewer',1,'ironman','tony','1@1.1','www');
		$this->assertInstanceOf('Gbk\Domain\User\viewer',$testUser, 'superuser should create User/SuperUser object');

	}
}