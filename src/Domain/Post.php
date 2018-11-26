<?php
class Post {
{
        //data members
    private $postid;
    private $userid;
    private $username;
    private $post;
    private $picture;
    private $pictureId;
    private $pictureFilenameExt;
    private $postdate;
    private $pictureTmpFileName;
//////////////////////////////////////////////////////////////////
//constructor
/////////////////////////////////////////////////////////////////
    public function __construct($post="")
    {
    }
//////////////////////////////////////////////////////////////////
//destructor
//////////////////////////////////////////////////////////////////
    public function __destruct()
    {
    }
    public function getPostId ()
    {
        return $this->postid;
    }
    public function getPictureTmpFilename()
    {
        return $this->pictureTmpFilename; 
    }
    public function getUserName ()
    {
        return $this->username;
    }   
    public function getUserId ()
    {
        return $this->userid;
    }
    public function getPost()
    {
        return $this->post;
    }
    public function getPicture()
    {
        return $this->picture;
    }
    public function getPictureId()
    {
        return $this->pictureId;
    }
    public function getPostDate()
    {
        return $this->postdate;
    }
    public function getPictureFilenameExt()
    {
        return $this->pictureFilenameExt;
    }
    
    public function setPictureTmpFilename($fname)
    {
        $this->pictureTmpFilename = $fname; 
    }
    public function setPictureFilenameExt($pic)
    {

        $this->pictureFilenameExt = $pic;
    }
    public function setPictureId ($picId)
    {
        if (!$picId) {
            $this->pictureId = 0;
        }
        else {
            $this->pictureId = $picId;
        }
    }
    public function setPost ($posttext)
    {
        $this->post = $posttext;
    }
    public function setUserName ($name)
    {
        $this->username = $name;
    }
    public function setUserId ($id)
    {
        $this->userid = $id;
    }
    public function setPostId ($postid)
    {
        $this->postid = $postid;
    }
    public function setPostDate ($postdate)
    {
        $this->postdate = $postdate;
    }
    public function setPicture ($postpicture)
    {
        $this->picture = $postpicture;
    }
    public function saveUserPost ()
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
    public function savePicture()
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
}