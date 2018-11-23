<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="guestbook2.css">
    <title>Log In</title>
  </head>
  <body>
    <h1>Log In</h1>
    <p>Please log in to view the page that you requested.</p>
    <?php if (isset($loginError)): ?>
      <p><?php htmlout($loginError); ?></p>
    <?php endif; ?>
    <form action="/index.php" method="post">
      <div>
        <label for="login_name">Login: <input type="text" name="login_name"
            id="login"></label>
      </div>
      <div>
        <label for="passwd">Password: <input type="password"
            name="passwd" id="password"></label>
      </div>
      <div>
        <input type="hidden" name="action" value="login">
        <input type="submit" value="Log in">
      </div>
    </form>
    <p><a href="/">home</a></p>
  </body>
</html>