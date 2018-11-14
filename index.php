<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="guestbook2.css">
  <title>My guestbook</title>
</head>
<body>
<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('name');
$log->pushHandler(new StreamHandler('/vagrant/log.log', Logger::WARNING));
//$log->addWarning('Foo');
//$log->addError('Bar');

if (!isset($_COOKIE['sorting'])) {
    $_COOKIE['sorting'] = 0;
}
if (!userIsLoggedIn()) {
    include $_SERVER['DOCUMENT_ROOT'] . '/login/welcomepage.html.php';
}

// for submitting registration new user
if (isset($_GET['adduser'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
    try {
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
    catch (PDOException $e) {
        $error = 'Error adding submitted author.';
        include 'error.html.php';
        exit();
    }
    $authorid = $pdo->lastInsertId();
    if ($_POST['passwd'] != '') {
        $password = md5($_POST['passwd'] . 'gbk');
        try {
            $sql = 'UPDATE users SET
            passwd = :password
            WHERE user_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':password', $password);
            $s->bindValue(':id', $authorid);
            $s->execute();
        }
        catch (PDOException $e) {
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
if (isset($_GET['reguser'])) {
    $pageTitle = 'New Author';
    $action = 'adduser';
    $login_name = '';
    $view_name = '';
    $webpage = '';
    $email = '';
    $id = '';
    $button = 'Register new account'; 
    include $_SERVER['DOCUMENT_ROOT'] . '/login/form.html.php';
    exit();
}
// for user post
if (isset($_POST['text'])) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/book/UserPost.php';
    $newpost = new UserPost();
    $newpost->setPost($_POST['text']);
    $newpost->setUserId($_SESSION['userId']);
    if ($_FILES['upload']['name']) {
        switch ($_FILES['upload']['type']) {
        case 'image/jpeg':
            $newpost->setPictureFilenameExt('jpeg');
            break;
        case 'image/png':
            $newpost->setPictureFilenameExt('png');
            break;
        case 'image/gif':
            $newpost->setPictureFilenameExt('gif');
            break;
        default:
            echo ("nonononono");
            header('Location: .');
            exit();
            break;
        }
        $newpost->setPicture(file_get_contents($_FILES['upload']['tmp_name']));
        $newpost->setPictureTmpFilename($_FILES['upload']['tmp_name']);
        $newpost->setPictureId($newpost->savePicture());
    }
    
    $newpost->saveUserPost();
    header('Location: .');
    exit();
}
// Display user session details
if (isset($_SESSION['loggedIn'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/login/logout.inc.html.php';
  }  
// Display guestbook body
include $_SERVER['DOCUMENT_ROOT'] . '/book/index.php';
  ?>
    
</body>
</html>
