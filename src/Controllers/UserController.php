<?php

namespace Gbk\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\UserModel;
use Gbk\Views\LoginView;

class UserController extends AbstractController {
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
}