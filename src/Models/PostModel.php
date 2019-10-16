<?php

namespace Gbk\Models;
use Gbk\Domain\Post;
use Gbk\Exceptions\NotFoundException;

use PDO;
class PostModel extends AbstractModel {
   const CLASSNAME = '\Gbk\Domain\Post';

   public function saveUserPost (Post $userpost)
    {
        // print_r($userpost);
        if (($userpost->getUserId())){
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
            if (($userpost->getPictureId())) {
                try {
                    $sql = 'insert into posts set
                    user_id = :id,
                    user_text = :text,
                    post_date = :date,
                    pic_id = :picId';
                    $s = $pdo->prepare($sql);
                    $s->bindValue('id', $userpost->getUserId());
                    $s->bindValue('text',$userpost->getPost());
                    $s->bindValue('date', date('y-m-d'));
                    $s->bindValue('picId',$userpost->getPictureId());

                    $s->execute();
                } 
                catch (PDOException $e) {
                    $error = 'Error submitting post.';
                    include 'error.html.php';
                    exit();
                }
            }
            else {
                try {
                    $sql = 'insert into posts set
                    user_id = :id,
                    user_text = :text,
                    post_date = :date';
                    // print_r ($sql);
                    $s = $pdo->prepare($sql);
                    $s->bindValue('id', $userpost->getUserId());
                    $s->bindValue('text',$userpost->getPost());
                    $s->bindValue('date', date('y-m-d'));
                    $s->execute();
                } 
                catch (PDOException $e) {
                    $error = 'Error submitting post.';
                    include 'error.html.php';
                    exit();
                }
            }                  
        }
        // print_r($userpost->userid);
    }
    public function savePicture(Post $userpost)
    {
        try {
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
            $sql = 'INSERT INTO user_pictures SET picture = :filedata, extension = :fileExt';
            $s = $pdo->prepare($sql);
            $s->bindValue(':filedata', $userpost->getPicture());
            $s->bindValue(':fileExt', $userpost->getPictureFilenameExt());
            $s->execute();
            return $pdo->lastInsertId();
        }
        catch (PDOException $e) {
            $error = 'Ошибка при сохранении файла в базе данных!';
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
            exit();
        }
    }

    public function getPostsPage($startpage=1, $sortby='', $perpage=5): array
    {
        $postarray = array();
        $select = 'SELECT posts.post_id, users.view_name as username, posts.user_text as post, posts.post_date as postdate, user_pictures.picture, user_pictures.pic_id as pictureId, user_pictures.extension as pictureFilenameExt';
        $from   = ' FROM users, posts left outer join user_pictures on user_pictures.pic_id=posts.pic_id';
        $where  = ' WHERE users.user_id=posts.user_id '.$sortby.' limit '.$perpage." offset ".($startpage*$perpage-5);
            $sql = $select . $from . $where;
            // echo $sql;
            $sth=$this->db->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
            // print_r($result);
            return $result;
    }

    public function countAllPosts () 
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';         
        $sql = 'SELECT count(*) from posts';
        try{
            $s = $pdo->prepare($sql);
            $s->execute();
        }
        catch (PDOException $e) {
            $error = 'Error fetching posts.';
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
            exit();
        }
        return($s->fetch()[0]);
    }


}
