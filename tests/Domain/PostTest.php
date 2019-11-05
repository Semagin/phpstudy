<?php

namespace Gbk\Tests\Domain\Post;

use Gbk\Domain\Post;
use PHPUnit_Framework_TestCase;

/**
 * 	Test class Post
 */
class PostTest extends PHPUnit_Framework_TestCase
{
	
	public function testGetPostId()
	{
		$post = new Post();
		$post->setPostId(1);
		$this->assertSame (1, $post->getPostId(),"OOOOPS!");
	}
}