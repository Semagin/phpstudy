<?php include_once $_SERVER['DOCUMENT_ROOT'] .    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php htmlout($pageTitle); ?></title>
  </head>
  <body>
    <h1><?php htmlout($pageTitle); ?></h1>
    <form action="?<?php htmlout($action); ?>" method="post">
      <div>
        <label for="login_name">Login Name: <input type="text" name="login_name"
            id="login_name" value="<?php htmlout($login_name); ?>"></label>
      </div>
      <div>
        <label for="view_name">View Name: <input type="text" name="view_name"
            id="view_name" value="<?php htmlout($view_name); ?>"></label>
      </div>
      <div>
        <label for="email">Email: <input type="text" name="email"
            id="email" value="<?php htmlout($email); ?>"></label>
      </div>
      <div>
        <label for="webpage">Webpage: <input type="text" name="webpage"
            id="webpage" value="<?php htmlout($webpage); ?>"></label>
      </div>
      <div>
        <label for="password">Set password: <input type="password"
            name="passwd" id="password"></label>
        <input type="hidden" name="id" value="<?php
            htmlout($id); ?>">
        <input type="hidden" name="action" value="newlogin">
        <p><input type="submit" value="<?php htmlout($button); ?>"></p>
      </div>
    </form>
  </body>
</html>
