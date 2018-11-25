<?php

namespace Gbk\Models;

use Gbk\Domain\User;
use Gbk\Domain\User\UserFactory;
use Gbk\Exceptions\NotFoundException;

class GbkModel extends AbstractModel {
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
}