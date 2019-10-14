<?php

namespace Gbk\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\PostModel;
use Gbk\Views\PostView;
use Gbk\Views\PageNavigatorView;
define("PERPAGE", 5);

class PostController extends AbstractController {
    
    public function showPosts($page): string {
        $userController = new UserController($this->di, $this->request);
        $returnPage = $userController->showWelcomePlate();

        $params = $this->request->getParams();
        // print_r($this->request);
        $cookies = $this->request->getCookies();
        $pagePostsModel = new PostModel($this->db);
        // $posts = $pagePostsModel->getPostsPage($params,$cookies);
        $posts = $pagePostsModel->getPostsPage($page);
        // $rndr = new NotFoundException();
        $rndr = new PostView();
        $pagename = '';
        // $pagename = basename($_SERVER["PHP_SELF"]);
        $totalcount = $pagePostsModel->countAllPosts();
        $numpages = ceil($totalcount/PERPAGE);
        //create if needed
//        print_r($numpages);
        if($numpages > 1) {
            //create navigator
            $nav = new PageNavigatorView($pagename, $totalcount, PERPAGE, $page*PERPAGE-5);
            //is the default but make explicit
            $nav->setFirstParamName($page*PERPAGE-5);
            $nav->getNavigator();
            return $returnPage.($rndr->render($posts,$page)).($nav->getNavigator());
        }
        return $returnPage.($rndr->render($posts));
    }
}