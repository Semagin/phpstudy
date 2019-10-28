<?php

namespace Gbk\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\PostModel;
use Gbk\Views\PostView;
use Gbk\Views\PageNavigatorView;
use Gbk\Domain\Post;
define("PERPAGE", 5);

class PostController extends AbstractController {
    
    public function showPosts($page): string {

        $userController = new UserController($this->di, $this->request);
        $returnPage = $userController->showWelcomePlate();
        if (isset($_POST['text'])) {
            $this->saveNewPost();
        }
        $params = $this->request->getParams();
        $cookies = $this->request->getCookies();
        $pagePostsModel = new PostModel($this->db);
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
        $rndr = new PostView();
        $pagename = '';
        $totalcount = $pagePostsModel->countAllPosts();
        $numpages = ceil($totalcount/PERPAGE);
        //create if needed
        if($numpages > 1) {
            //create navigator
            $nav = new PageNavigatorView($pagename, $totalcount, PERPAGE, $page*PERPAGE-5);
            //is the default but make explicit
            $nav->setFirstParamName($page*PERPAGE-5);
            $nav->getNavigator();
            return $returnPage.($rndr->render($posts,$page)).($userController->showPostForm()).($nav->getNavigator());
        }
        return $returnPage.($rndr->render($posts));
    }
    public function saveNewPost()
    {
        // create post structure and save it with saveUserPost
        
        if (isset($_POST['text'])) {
        $newpost = new Post();
        $newpost->setPost($_POST['text']);
        $newpost->setUserId($_SESSION['userId']);
        $newPostModel = new PostModel($this->db);
        if ($_FILES['upload']['name']) {
            switch ($_FILES['upload']['type']) {
            case 'image/jpeg':
                $newpost->setPictureFilenameExt('jpeg');
                break;
            case 'image/png':
                $newpost->setPictureFilenameExt('png');
                break;
            case 'image/gif':
                $newpost->setPictureFilenameExt('gif');
                break;
            default:
                echo ("nonononono");
                header('Location: .');
                exit();
                break;
            }
            $newpost->setPicture(file_get_contents($_FILES['upload']['tmp_name']));
            $newpost->setPictureTmpFilename($_FILES['upload']['tmp_name']);
            $newpost->setPictureId($newPostModel->savePicture($newpost));
        }
        // print_r($newpost);
        $newPostModel->saveUserPost($newpost);
        // header('Location: .');
        // exit();
        }
    }
}