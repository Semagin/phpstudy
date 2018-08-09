<?php
class UserPost{
		//data members
	private $postid;
	private $userid;
	private $username;
	private $post;
	private $picture;
	private $postdate;
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
		$this->post = $postpicture;
	}
	public function saveUserPost ()
	{
		if (isset($this->userid)){

	 		include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
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
		    } catch (PDOException $e) {
		      $error = 'Error submitting post.';
		      include 'error.html.php';
		      exit();
		    }  
		}
	}
}

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
  		$select = 'SELECT users.view_name, posts.user_text, posts.post_date';
		$from   = ' FROM posts, users';
  		$where  = ' WHERE users.user_id=posts.user_id '.$sortby.' limit '.$perpage." offset ".$startpage;
		
		try
  		{
	    	$sql = $select . $from . $where;
	    	echo $sql;
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