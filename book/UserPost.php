<?php
class UserPost{
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
 	public function __construct($post=""){
 	}
//////////////////////////////////////////////////////////////////
//destructor
//////////////////////////////////////////////////////////////////
	public function __destruct(){
	}
	public function getPostId (){
		return $this->postid;
	}
	public function getPictureTmpFilename()
    {
        return $this->pictureTmpFilename; 
    }
    public function getUserName (){
		return $this->username;
	}	public function getUserId (){
		return $this->userid;
	}
	public function getPost() {
		return $this->post;
	}
	public function getPicture() {
		return $this->picture;
	}
	public function getPostDate() {
		return $this->postdate;
    }
	public function getPictureFilenameExt() {
		return $this->pictureFilenameExt;
    }
    
    public function setPictureTmpFilename($fname)
    {
        $this->pictureTmpFilename = $fname; 
    }
   	public function setPictureFilenameExt($pic) {

        if (preg_match('/^image\/p?jpeg$/i', $pic))
        {
            $ext = '.jpg';
        }
        else if (preg_match('/^image\/gif$/i', $pic))
        {
            $ext = '.gif';
        }
        else if (preg_match('/^image\/(x-)?PNG$/i',$pic))
        {
            $ext = '.png';
        }
        else
        {
            $ext = '.unknown';
        }
        $this->pictureFilenameExt = $ext;
    }
	public function setPictureId ($picId){
		$this->pictureId = $picId;
	}
	public function setPost ($posttext){
		$this->post = $posttext;
	}
	public function setUserName ($name){
		$this->username = $name;
	}
	public function setUserId ($id){
		$this->userid = $id;
	}
	public function setPostId ($postid){
		$this->postid = $postid;
	}
	public function setPostDate ($postdate){
		$this->postdate = $postdate;
	}

	public function setPicture ($postpicture){
        $this->picture = $postpicture;
	}
	public function saveUserPost ()
	{
		if (isset($this->userid)){

	 		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	  		try {
		      $sql = 'insert into posts set
		      user_id = :id,
		      user_text = :text,
		      post_date = :date,
              pic_id = :picId';
		      //echo $sql;
		      $s = $pdo->prepare($sql);
		      $s->bindValue('id', $this->userid);
		      $s->bindValue('text',$this->post);
		      $s->bindValue('date', date('y-m-d'));
              $s->bindValue('picId',$this->pictureId);
		      $s->execute();
		    } catch (PDOException $e) {
		      $error = 'Error submitting post.';
		      include 'error.html.php';
		      exit();
		    }  
		}
}
public function savePicture()
{
        
        try
    {
 		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        $sql = 'INSERT INTO user_pictures SET picture = :filedata';
        $s = $pdo->prepare($sql);
        $s->bindValue(':filedata', $this->picture);
        $s->execute();
        return $pdo->lastInsertId();
    }
    catch (PDOException $e)
    {
        $error = 'Ошибка при сохранении файла в базе данных!';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
        exit();
    }
    }
}



///////////////////////////////////////////////////////////////////////////////
class UserPosts {
	private $postarray = array();
 	public function __construct($perpage=1, $startpage=1){
 	}
//////////////////////////////////////////////////////////////////
//destructor
//////////////////////////////////////////////////////////////////
	public function __destruct(){
		unset($this->postarray);
	}
	
	public function getPosts($sortby, $perpage=1, $startpage=1) {
  		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  		$select = 'SELECT users.view_name, posts.user_text, posts.post_date, user_pictures.picture';
		$from   = ' FROM users, posts left outer join user_pictures on user_pictures.pic_id=posts.pic_id';
  		$where  = ' WHERE users.user_id=posts.user_id '.$sortby.' limit '.$perpage." offset ".$startpage;
		
		try
  		{
	    	$sql = $select . $from . $where;
//    	echo $sql;
	    	$s = $pdo->prepare($sql);
	    	$s->execute();
		}
		catch (PDOException $e)
		{
		    $error = 'Error fetching posts.';
		    include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		    exit();
		}

		foreach ($s as $row)
		{
		    $userpost = new UserPost();
		    $userpost->setPost($row['user_text']);
		    $userpost->setUserName($row['view_name']);
		    $userpost->setPostDate($row['post_date']);
            $userpost->setPicture($row['picture']);
            $userpost->setPictureFilenameExt($row['picture']);
		    $this->postarray[] = array($userpost);
	  	}
  	}
  	public function showPosts () {
  		foreach ($this->postarray as $posttoshow) {

        	echo "<div id=\"tableRow\">       		<div id=\"postid1\">";
        	echo markdownout($posttoshow[0]->getUserName());
        	echo "    </div>
          	<div id=\"userpost\">";
			echo markdownout($posttoshow[0]->getPost());
			$pic = $posttoshow[0]->getPicture();
            $shortfilename = '/pics/'. time() . '.png';
            $filename = $_SERVER['DOCUMENT_ROOT'] .$shortfilename;
//            $filename = $_SERVER['DOCUMENT_ROOT'] . '/pics/'. time() . $_SERVER['REMOTE_ADDR'] . $posttoshow[0]->getPictureFilenameExt();
            $filestream = fopen ($filename,'w');
            $num = fwrite($filestream, $pic);
/*            if (!is_uploaded_file($posttoshow[0]->getPicture()) or
            !copy($posttoshow[0]->picture, $filename))
            {
                    $error = "He удалось сохранить файл под именем $filename!";
                    include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
                    exit();
        }
  */ //     echo strlen($pic);
//            header('Content-length: ' . strlen($pic));
  //          header("Content-type: image/png");
    //        header("Content-disposition: inline");
//            header("Content-disposition: inline; filename=$filename");
//            echo $pic;
//            echo $shortfilename;
            if ($num) {echo " <img src=\"".$shortfilename."\" />";}
            echo "	</div>
        	<div id=\"postdate\">";
         	echo markdownout($posttoshow[0]->getPostDate());
         	echo "</div></div>";
  		}
  	}
  	public function countAllPosts () {
  		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';  		
		$sql = 'SELECT count(*) from posts';
		try
  		{
	    	$s = $pdo->prepare($sql);
	    	$s->execute();
		}
		catch (PDOException $e)
		{
		    $error = 'Error fetching posts.';
		    include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		    exit();
		}
			return($s->fetch()[0]);
  	}

}