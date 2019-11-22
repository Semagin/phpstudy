<?php
namespace Gbk\Tests\Controllers;

use Gbk\Utils\DependencyInjector;
use Gbk\Core\Config;

abstract class ControllerTestCase extends AbstractTestCase {
	protected $di;

	public function setUp() {
		$this->di = new DependencyInjector();
		$this->di->set('PDO', $this->mock(PDO::class));
   		$this->di->set('Utils\Config', $this->mock(Config::class));
	}
}