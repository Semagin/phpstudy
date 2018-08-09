
<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; 
 require 'PageNavigator.php';
 require_once 'UserPost.php';
define("PERPAGE", 5);
//name of first parameter in query string
define("OFFSET", "offset");
define("SORTING", "sortby");
/*get query string - name should be same as first parameter name
passed to the page navigator class*/
$offset=@$_GET[OFFSET];
$sortby=@$_GET[SORTING];
print_r($sortby);
//check variable
if (!isset($_COOKIE['sortbyname'])) {
setcookie('sortbyname',"desc",time()+3600);
}
if (!isset($_COOKIE['sortbydate'])) {
setcookie('sortbydate',"desc",time()+3600);
}
if (!isset($_COOKIE['sortby'])) {
setcookie('sortby',"date",time()+3600);
}
if (!isset($offset))
{
  $totaloffset=0;
}
else
{
  //clean variable here
  //then calc record offset
  $totaloffset = $offset * PERPAGE;

}
if (!isset($sortby))
{
      if ($_COOKIE['sortbyname']=='desc' && $_COOKIE['sortby']=='name') {
          $tablesort="ORDER BY users.view_name asc";
      }
             elseif ($_COOKIE['sortbyname']=='asc'&& $_COOKIE['sortby']=='name')
       {
          $tablesort="ORDER BY users.view_name desc";
       }
      if ($_COOKIE['sortbydate']=='desc' && $_COOKIE['sortby']=='date') {
          $tablesort="ORDER BY posts.post_date asc";
      }
             elseif ($_COOKIE['sortbydate']=='asc'&& $_COOKIE['sortby']=='date')
       {
          $tablesort="ORDER BY posts.post_date desc";
       }
}
else
{
  switch ($sortby) {
     case '1':
       if ($_COOKIE['sortbyname']=='desc') {
          $tablesort="ORDER BY users.view_name asc";
          setcookie('sortbyname',"asc",time()+3600);
          setcookie('sortby',"name",time()+3600);
          break;
       }
       elseif ($_COOKIE['sortbyname']=='asc')
       {
          $tablesort="ORDER BY users.view_name desc";
          setcookie('sortbyname',"desc",time()+3600);
          setcookie('sortby',"name",time()+3600);
          break;
       }
       break;
     case '2':
        if ($_COOKIE['sortbydate']=='desc') {
          $tablesort="ORDER BY posts.post_date asc";
          setcookie('sortbydate',"asc",time()+3600);
          setcookie('sortby',"date",time()+3600);
          break;
       }
       elseif ($_COOKIE['sortbyname']=='asc')
       {
          $tablesort="ORDER BY posts.post_date desc";
          setcookie('sortbydate',"desc",time()+3600);
          setcookie('sortby',"date",time()+3600);
          break;
       }
       $tablesort="ORDER BY posts.post_date desc";
       break;
     
     default:
        $tablesort="";
       break;
   } 
}
    $pagename = basename($_SERVER["PHP_SELF"]);

   ?>
    
    <h1>Resent posts</h1>
      <div id="tablecontainer">
        <div id="tableheader">
          <div id= "headerlabel"><?php echo "<a href=".$pagename."?"."sortby=1".">User name</a>"; ?></div>
          <div id= "headerlabel">Post text</div>
          <div id= "headerlabel"><?php echo "<a href=".$pagename."?"."sortby=2".">Post date</a>"; ?></div>
        </div>
    <?php  
//          print_r($_COOKIE['sortby']);
          $pageposts = new UserPosts();
          $pageposts->getposts($tablesort,PERPAGE,$totaloffset);
          $pageposts->showposts();
          ?>
      </div>
    <?php 
    $totalcount = $pageposts->countAllPosts();
    $numpages = ceil($totalcount/PERPAGE);
//create if needed
    if($numpages > 1)
    {
//create navigator
      $nav = new PageNavigator($pagename, $totalcount, PERPAGE, $totaloffset);
//is the default but make explicit
      $nav->setFirstParamName(OFFSET);
      echo $nav->getNavigator();
    }
?>
    <p><a href="..">Return to home</a></p>