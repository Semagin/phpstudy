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
//            return $this->render('login.twig', []);
        }
                return ('here will be login form!!!');    
        $params = $this->request->getParams();

        if (!$params->has('email')) {
            $params = ['errorMessage' => 'No info provided.'];
                return ('no info!');
//            return $this->render('login.twig', $params);
        }

        $email = $params->getString('email');
        $userModel = new UserModel($this->db);

        try {
            $user = $userModel->getByEmail($email);
        } catch (NotFoundException $e) {
            $this->log->warn('User email not found: ' . $email);
            $params = ['errorMessage' => 'Email not found.'];
            return $this->render('login.twig', $params);
        }

        setcookie('user', $user->getId());
// if login was successful, show posts
//        $newController = new BookController($this->di, $this->request);
 //       return $newController->getAll();
        return 'show me posts';
    }
    public function showRegisterForm() : string {
            $regForm = new RegView();
                return ($regForm->render());
    }

    public function showWelcomePlate() : string {
        // if ($this->request->getParams()) {
        //     # code...
        // }
        if ($this->request->getParams()->getString('action')==='newlogin') {
            $userModel = new UserModel($this->db);
            $userModel->regUser();

            // print_r($_POST['login_name']);
        }
        // if (!$this->request->isPost()) {
        //     print_r('try to login!');
        // }
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';
        if (!userIsLoggedIn()) {
            // print_r('NOT LOGIN!');
            $welcomeForm = new WelcomePlateView();
            return ($welcomeForm->render());
        }
        $welcomeForm = new LoggedInUserView();
        return ($welcomeForm->render());
    }

    public function showPostForm() : string {
        // require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';
        if (isset($_SESSION['loggedIn'])) {
            $postForm = new LoggedInUserView();
            return ($postForm->postFormRender());
        }
        return('');
    }
}