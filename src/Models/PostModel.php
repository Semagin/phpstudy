<?php

namespace Gbk\Models;

use Gbk\Domain\Post;
use Gbk\Exceptions\NotFoundException;
use PDO;

class PostModel extends AbstractModel {
   
   const CLASSNAME = '\Gbk\Domain\Post';

   /**
    * saves user post (without picture)
    * @param  Post   $userpost 
    * @return nothing
    */
   public function saveUserPost (Post $userpost)
    {
        if (($userpost->getUserId())){
            $db=$this->db;
            if (($userpost->getPictureId())) {
                try {
                    $sql = 'insert into posts set
                    user_id = :id,
                    user_text = :text,
                    post_date = :date,
                    pic_id = :picId';
                    $s = $db->prepare($sql);
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
                    $s = $db->prepare($sql);
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
    }
    
    /**
     * save picture data for user post
     * @param  Post   $userpost 
     * @return nothing
     */
    public function savePicture(Post $userpost)
    {
        try {
            $sql = 'INSERT INTO user_pictures SET picture = :filedata, extension = :fileExt';
            $s = $this->db->prepare($sql);
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
    /**
     * gets array of posts
     * @param  integer $startpage 
     * @param  string  $sortby   in SQL format
     * @param  integer $perpage   posts per page
     * @return array of posts
     */
    public function getPostsPage($startpage=1, $sortby='', $perpage=5): array
    {
        $postarray = array();
        $select = 'SELECT posts.post_id, users.view_name as username,users.user_id as userid, posts.user_text as post, posts.post_date as postdate, user_pictures.picture, user_pictures.pic_id as pictureId, user_pictures.extension as pictureFilenameExt';
        $from   = ' FROM users, posts left outer join user_pictures on user_pictures.pic_id=posts.pic_id';
        $where  = ' WHERE users.user_id=posts.user_id '.$sortby.' limit '.$perpage." offset ".($startpage*$perpage-5);
            $sql = $select . $from . $where;
            $sth=$this->db->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
            return $result;
    }

    /**
     * @return amount of all posts
     */
    public function countAllPosts () 
    {
        $sql = 'SELECT count(*) from posts';
        try{
            $s = $this->db->prepare($sql);
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
