<?php
namespace Gbk\Domain;

class Post {

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
   
}