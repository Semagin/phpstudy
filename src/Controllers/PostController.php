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
        // $sortDirection="asc";
        $params = $this->request->getParams();
        // if ($params->has("sortby")) {
        //     $sortDirection = ($params->getString("sortby")=="1") ? "asc" : "desc" ;
        // }
        // print_r($sortDirection);
        // print_r($params->getString("sortby"));
        $cookies = $this->request->getCookies();
        $pagePostsModel = new PostModel($this->db);
        // $posts = $pagePostsModel->getPostsPage($params,$cookies);
        $sortby=@$_GET["sortby"];
        if (!isset ($_COOKIE['sortby']) or !isset ($_COOKIE['sortbyname']) or !isset ($_COOKIE['sortbydate'])) {
            $tablesort="ORDER BY posts.post_date asc";
            setcookie('sortbydate',"asc",time()+3600);
            setcookie('sortbyname',"asc",time()+3600);
            setcookie('sortby',"date",time()+3600);

        }
        elseif (!isset($sortby)) {
            if ($_COOKIE['sortbyname']=='desc' && $_COOKIE['sortby']=='name') {
                $tablesort="ORDER BY users.view_name desc";
            }
            elseif ($_COOKIE['sortbyname']=='asc'&& $_COOKIE['sortby']=='name') {
                $tablesort="ORDER BY users.view_name asc";
            }
            if ($_COOKIE['sortbydate']=='desc' && $_COOKIE['sortby']=='date') {
                  $tablesort="ORDER BY posts.post_date desc";
            }
            elseif ($_COOKIE['sortbydate']=='asc'&& $_COOKIE['sortby']=='date') {
                  $tablesort="ORDER BY posts.post_date asc";
            }
        }
        else {
            switch ($sortby) {
                case '1':
                    if (!isset ($_COOKIE['sortbyname']) or $_COOKIE['sortbyname']=='desc') {
                        $tablesort="ORDER BY users.view_name asc";
                        setcookie('sortbyname',"asc",time()+3600);
                        setcookie('sortby',"name",time()+3600);
                        break;
                    }
                    elseif ($_COOKIE['sortbyname']=='asc') {
                        $tablesort="ORDER BY users.view_name desc";
                        setcookie('sortbyname',"desc",time()+3600);
                        setcookie('sortby',"name",time()+3600);
                        break;
                    }
                    break;
                case '2':
                    if (!isset ($_COOKIE['sortbydate']) or $_COOKIE['sortbydate']=='desc') {
                        $tablesort="ORDER BY posts.post_date asc";
                        setcookie('sortbydate',"asc",time()+3600);
                        setcookie('sortby',"date",time()+3600);
                        break;
                    }
                    elseif ($_COOKIE['sortbydate']=='asc') {
                        $tablesort="ORDER BY posts.post_date desc";
                        setcookie('sortbydate',"desc",time()+3600);
                        setcookie('sortby',"date",time()+3600);
                        break;
                    }
                    break;
                default:
                    $tablesort="";
                break;
            } 
        }
        $posts = $pagePostsModel->getPostsPage($page, $tablesort);
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