<?php
if (!isset($_COOKIE['sortbyname'])) {
    setcookie('sortbyname',"desc",time()+3600);
}
if (!isset($_COOKIE['sortbydate'])) {
    setcookie('sortbydate',"desc",time()+3600);
}
if (!isset($_COOKIE['sortby'])) {
    setcookie('sortby',"date",time()+3600);
}
?>
<p id="loginform">You are not logged in <br>
    please <a href="login/login.html.php">login </a> or <a href="?reguser">register</a>  to leave a message </p>
    <h1 id="welcomephrase">Welcome to my guestbook!</h1>
