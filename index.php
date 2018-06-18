<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

if (!userIsLoggedIn())
{
  include 'welcomepage.html.php';
}

// for submitting registration new user
if (isset($_GET['adduser']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  try
  {
    $sql = 'INSERT INTO users SET
        user_type_id = 1,
        login_name = :login_name,
        view_name = :view_name,
        homepage = :webpage,
        email = :email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':login_name', $_POST['login_name']);
    $s->bindValue(':view_name', $_POST['view_name']);
    $s->bindValue(':webpage', $_POST['webpage']);
    $s->bindValue(':email', $_POST['email']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted author.';
    include 'error.html.php';
    exit();
  }

  $authorid = $pdo->lastInsertId();

  if ($_POST['passwd'] != '')
  {
    $password = md5($_POST['passwd'] . 'gbk');

    try
    {
      $sql = 'UPDATE users SET
          passwd = :password
          WHERE user_id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':password', $password);
      $s->bindValue(':id', $authorid);
      $s->execute();
    }
    catch (PDOException $e)
    {
      $error = 'Error setting author password.';
      include 'error.html.php';
      exit();
    }
  }
  userIsLoggedIn();
  header("Location: .");
  exit();
}

// for new user registration
if (isset($_GET['reguser']))
{
  $pageTitle = 'New Author';
  $action = 'adduser';
  $login_name = '';
  $view_name = '';
  $webpage = '';
  $email = '';
  $id = '';
  $button = 'Register new account'; 
  include 'form.html.php';
  exit();
}
// Display guestbook body
 if (isset($_SESSION['loggedIn']))
 {
    include 'logout.inc.html.php';

 }