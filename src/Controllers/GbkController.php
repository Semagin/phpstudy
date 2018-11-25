<?php

namespace Gbk\Controllers;

use Gbk\Exceptions\NotFoundException;
use Gbk\Models\GbkModel;

class GbkController extends AbstractController {
    
    public function showPosts(): string {
        $params = $this->request->getParams();
        $gbkModel = new GbkModel($this->db);


/*        $userModel = new GbkModel($this->db);

        try {
            $user = $userModel->getByEmail($email);
        } catch (NotFoundException $e) {
            $this->log->warn('User email not found: ' . $email);
            $params = ['errorMessage' => 'Email not found.'];
            return $this->render('login.twig', $params);
        }
*/
//        setcookie('user', $user->getId());
// if login was successful, show posts
//        $newController = new BookController($this->di, $this->request);
 //       return $newController->getAll();
        return 'show me posts';
    }
}