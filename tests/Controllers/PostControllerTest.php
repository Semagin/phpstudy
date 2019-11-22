<?php
namespace Gbk\Tests\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\PostModel;
use Gbk\Views\PostView;
use Gbk\Views\PageNavigatorView;
use Gbk\Domain\Post;
use Gbk\Tests\ControllerTestCase;

class PostControllerTest extends ControllerTestCase {
	
	private function getController (Request $request = null): PostController {
		if ($request === null) {
			$request = $this->mock('Core\Request');
		}
		return new PostController($this->di, $request);
	}



}