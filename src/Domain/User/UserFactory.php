<?php

namespace Gbk\Domain\User;

use Gbk\Domain\User;
use Gbk\Exceptions\NotFoundException;

class UserFactory {
    public static function factory($type, $user_id,$loginname, $view_name, $email, $homepage) {
        $classname = ucfirst($type);
        // $classname = __NAMESPACE__ . '\\' . ucfirst($type);
        // print_r($classname);
        // print_r(class_exists($classname));
        // if (!class_exists($classname)) {
        // 	print_r('no class!');
        //     // throw new \NotFoundException('Wrong type.');
        // }
        
        // return new $classname($user_id, $loginname, $view_name, $email, $homepage);
        return new Moderator($user_id, $loginname, $view_name, $email, $homepage);
    }
}