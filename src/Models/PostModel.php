<?php

namespace Gbk\Models;

use Gbk\Exceptions\NotFoundException;
class PostModel extends AbstractModel {
   public function saveUserPost (Post $userpost)
    {
        if (isset($this->userid)){
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
            if ($this->pictureId) {
                try {
                    $sql = 'insert into posts set
                    user_id = :id,
                    user_text = :text,
                    post_date = :date,
                    pic_id = :picId';
                    $s = $pdo->prepare($sql);
                    $s->bindValue('id', $this->userid);
                    $s->bindValue('text',$this->post);
                    $s->bindValue('date', date('y-m-d'));
                    $s->bindValue('picId',$this->pictureId);
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
                    //echo $sql;
                    $s = $pdo->prepare($sql);
                    $s->bindValue('id', $this->userid);
                    $s->bindValue('text',$this->post);
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
    }
    private function savePicture()
    {
        try {
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
            $sql = 'INSERT INTO user_pictures SET picture = :filedata, extension = :fileExt';
            $s = $pdo->prepare($sql);
            $s->bindValue(':filedata', $this->picture);
            $s->bindValue(':fileExt', $this->pictureFilenameExt);
            $s->execute();
            return $pdo->lastInsertId();
        }
        catch (PDOException $e) {
            $error = 'Ошибка при сохранении файла в базе данных!';
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
            exit();
        }
    }
    public function getPosts($sortby, $perpage=1, $startpage=1) 
    {
    $postarray = array();
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        $select = 'SELECT users.view_name, posts.user_text, posts.post_date, user_pictures.picture, user_pictures.pic_id, user_pictures.extension';
        $from   = ' FROM users, posts left outer join user_pictures on user_pictures.pic_id=posts.pic_id';
        $where  = ' WHERE users.user_id=posts.user_id '.$sortby.' limit '.$perpage." offset ".$startpage;
        try {
            $sql = $select . $from . $where;
//      echo $sql;
            $s = $pdo->prepare($sql);
            $s->execute();
        }
        catch (PDOException $e){
            $error = 'Error fetching posts.';
            include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
            exit();
        }
        foreach ($s as $row) {
            $userpost = new UserPost();
            $userpost->setPost($row['user_text']);
            $userpost->setUserName($row['view_name']);
            $userpost->setPostDate($row['post_date']);
            $userpost->setPicture($row['picture']);
            $userpost->setPictureId($row['pic_id']);
            $userpost->setPictureFilenameExt($row['extension']);
            $postarray[] = array($userpost);
        }
    }

}
