<?php

namespace Gbk\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\UserModel;

class UserController extends AbstractController {
    public function login(): string {
        if (!$this->request->isPost()) {
                return ('here will be login form');
//            return $this->render('login.twig', []);
        }

        $params = $this->request->getParams();

        if (!$params->has('email')) {
            $params = ['errorMessage' => 'No info provided.'];
                return ('no info!');
//            return $this->render('login.twig', $params);
        }

        $email = $params->getString('email');
        $userModel = new UserModel($this->db);

        try {
            $customer = $customerModel->getByEmail($email);
        } catch (NotFoundException $e) {
            $this->log->warn('Customer email not found: ' . $email);
            $params = ['errorMessage' => 'Email not found.'];
            return $this->render('login.twig', $params);
        }

        setcookie('user', $customer->getId());

        $newController = new BookController($this->di, $this->request);
        return $newController->getAll();
    }
}