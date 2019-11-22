<?php

namespace Gbk\Domain\User;

use Gbk\Domain\User;
use Gbk\Exceptions\NotFoundException;

class UserFactory {
    public static function factory($type, $user_id,$loginname, $view_name, $email, $homepage) {
        $classname = ucfirst($type);
        $classname = __NAMESPACE__ . '\\' . ucfirst($type);
        if (!class_exists($classname)) {
            throw new \NotFoundException('Wrong type.');
        }
        return new $classname($user_id, $loginname, $view_name, $email, $homepage);
    }
}