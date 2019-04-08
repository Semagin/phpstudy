<p>
<form action="" method="post">
  <div id="loginform">
  	<?php echo "username:".$_SESSION['login_name'];?>
    <input type="hidden" name="action" value="logout">
    <input type="hidden" name="goto" value="/">
    <input type="submit" value="Log out">
  </div>
</form>
</p>