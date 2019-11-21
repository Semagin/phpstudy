<?php

namespace Gbk\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\UserModel;
use Gbk\Views\LoginView;
use Gbk\Views\RegView;
use Gbk\Views\WelcomePlateView;
use Gbk\Views\LoggedInUserView;

class UserController extends AbstractController {
    
    /**
     * show login page
     * @return  login form
     */
    public function login(): string {
        if (!$this->request->isPost()) {
            $loginForm = new LoginView();
                return ($loginForm->render());
        }
        return ('');
    }
    
    /**
     * show form new user registration
     * @return regform page
     */
    public function showRegisterForm() : string {
            $regForm = new RegView();
                return ($regForm->render());
    }
    
    /**
     * show default welcomeplate and check is logged in user
     * @return welcomeplate
     */
    public function showWelcomePlate() : string {
        if ($this->request->getParams()->getString('action')==='newlogin') {
            $userModel = new UserModel($this->db);
            $userModel->regUser();
        }
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';
        if (!userIsLoggedIn($this->db)) {
            $welcomeForm = new WelcomePlateView();
            return ($welcomeForm->render());
        }
        $welcomeForm = new LoggedInUserView();
        return ($welcomeForm->render());
    }
    
    /**
     * show postform for logged in users
     * @return [type] [description]     
     */
    public function showPostForm() : string {
        if (isset($_SESSION['loggedIn'])) {
            $postForm = new LoggedInUserView();
            return ($postForm->postFormRender());
        }
        return('');
    }
}