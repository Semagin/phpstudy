<?php

namespace Gbk\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\PostModel;
use Gbk\Views\PostView;

class PostController extends AbstractController {
    
    public function showPosts(): string {
        
        $userController = new UserController($this->di, $this->request);
        $returnPage = $userController->showWelcomePlate();

        $params = $this->request->getParams();
        $cookies = $this->request->getCookies();
        $pagePostsModel = new PostModel($this->db);
        // $posts = $pagePostsModel->getPostsPage($params,$cookies);
        $posts = $pagePostsModel->getPostsPage();
        // $rndr = new NotFoundException();
        $rndr = new PostView();
        return $returnPage.($rndr->render($posts));
    }
}