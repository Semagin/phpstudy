<?php

namespace Gbk\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\PostModel;
use Gbk\Views\PostView;

class PostController extends AbstractController {
    
    public function showPosts(): string {
        $params = $this->request->getParams();
        $cookies = $this->request->getCookies();
        $pagePostsModel = new PostModel($this->db);
        $posts = $pagePostsModel->getPosts($params,$cookies);
        $render = new PostView();

        return $render->render($posts);
    }
}