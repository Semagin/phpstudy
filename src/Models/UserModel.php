<?php

namespace Gbk\Models;

use Gbk\Domain\User;
use Gbk\Domain\User\UserFactory;
use Gbk\Exceptions\NotFoundException;

class UserModel extends AbstractModel {
    public function get(int $userId): User {
        $query = 'SELECT * FROM users WHERE user_id = :user';
        $sth = $this->db->prepare($query);
        $sth->execute(['user' => $userId]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }

        return UserFactory::factory(
            $row['user_type_id'],
            $row['user_id'],
            $row['login_name'],
            $row['view_name'],
            $row['email'],
            $row['homepage']
        );
    }

    public function getByEmail(string $email): User {
        $query = 'SELECT * FROM users WHERE email = :user';
        $sth = $this->db->prepare($query);
        $sth->execute(['user' => $email]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }

        return UserFactory::factory(
            $row['user_type_id'],
            $row['user_id'],
            $row['login_name'],
            $row['view_name'],
            $row['email'],
            $row['homepage']
        );
    }
    /**
     * register new user and login him
     */
    public function regUser() {
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

        try {
            $sql = 'INSERT INTO users SET
                user_type_id = 1,
                login_name = :login_name,
                view_name = :view_name,
                homepage = :webpage,
                email = :email';
            $s = $this->db->prepare($sql);
            $s->bindValue(':login_name', $_POST['login_name']);
            $s->bindValue(':view_name', $_POST['view_name']);
            $s->bindValue(':webpage', $_POST['webpage']);
            $s->bindValue(':email', $_POST['email']);
            $s->execute();
        }
        catch (PDOException $e) {
            $error = 'Error adding submitted author.';
            include 'error.html.php';
            exit();
        }
        $authorid = $this->db->lastInsertId();
        if ($_POST['passwd'] != '') {
            $password = md5($_POST['passwd'] . 'gbk');
            try {
                $sql = 'UPDATE users SET
                passwd = :password
                WHERE user_id = :id';
                $s = $this->db->prepare($sql);
                $s->bindValue(':password', $password);
                $s->bindValue(':id', $authorid);
                $s->execute();
            }
            catch (PDOException $e) {
                $error = 'Error setting author password.';
                include 'error.html.php';
                exit();
            }
        }
    }
 }