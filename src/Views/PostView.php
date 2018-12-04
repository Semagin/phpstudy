<?php 

namespace Gbk\Views;

// use Gbk\Domain\Post;

class PostView
{
    // function __construct()
    // {
    //     # code...
    // }
    function render (array $posts):string
    {
        ob_start();
        include_once $_SERVER['DOCUMENT_ROOT'].'/src/Views/PostRender.html.php';
        return ob_get_clean();
    }
}







