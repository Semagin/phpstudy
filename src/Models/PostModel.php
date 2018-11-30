<?php

namespace Gbk\Models;
use Gbk\Domain\Post;
use Gbk\Exceptions\NotFoundException;

use PDO;
class PostModel extends AbstractModel {
   const CLASSNAME = '\Gbk\Domain\Post';

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

    public function getPostsPage($sortby='desc', $perpage=1, $startpage=1): array
    {
        $postarray = array();
        $select = 'SELECT users.view_name, posts.user_text, posts.post_date, user_pictures.picture, user_pictures.pic_id, user_pictures.extension';
        $from   = ' FROM users, posts left outer join user_pictures on user_pictures.pic_id=posts.pic_id';
        $where  = ' WHERE users.user_id=posts.user_id '.'ORDER BY posts.post_date '.$sortby.' limit '.$perpage." offset ".$startpage;
            $sql = $select . $from . $where;
      // echo $sql;
            $sth=$this->db->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
            // print_r($result);
            return $result;
    }

}
