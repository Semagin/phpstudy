<?php 

namespace Gbk\Views;

// use Gbk\Domain\Post;

class PostView
{
    function render (array $posts, $page):string
    {
        ob_start();
        include_once $_SERVER['DOCUMENT_ROOT'].'/src/Views/PostRender.html.php';
        return ob_get_clean();
    }
}







