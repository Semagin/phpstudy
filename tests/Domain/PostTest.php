<?php

namespace Gbk\Tests\Domain\Post;

use Gbk\Domain\Post;
use PHPUnit_Framework_TestCase;

/**
 * 	Test class Post
 */
class PostTest extends PHPUnit_Framework_TestCase
{
	private $postForTest;

	public function setUp()
	{
	$this->postForTest = new Post (1,'hot');
	$this->postForTest->setPostId(1);
    $this->postForTest->setUserName('kolobok');
    $this->postForTest->setPostDate(date('y-m-d'));
	}
	
	public function testGetPostId()
	{
		$this->assertSame (1, $this->postForTest->getPostId(),"OOOOPS!");
	}
	
	public function testGetPost()
	{
		$this->assertSame ('hot', $this->postForTest->getPost(),"OOOOPS!");
	}	
	public function testGetUserId()
	{
		$this->assertSame (1, $this->postForTest->getUserId(),"OOOOPS!");
	}
	public function testGetUserName()
	{
		$this->assertSame ('kolobok', $this->postForTest->getUserName(),"OOOOPS!");
	}
	public function testGetPostDate()
	{
		$this->assertSame (date('y-m-d'), $this->postForTest->getPostDate(),"OOOOPS!");
	}
}