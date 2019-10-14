<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="guestbook2.css">
  <title>My guestbook</title>
</head>
<body>
<!-- <script src="app.js"></script>
<script src=""></script> -->
<?php
use Gbk\Core\Config;
use Gbk\Core\Router;
use Gbk\Core\Request;
use Gbk\Utils\DependencyInjector;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
require_once __DIR__ . '/vendor/autoload.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
$config = new Config();
$dbConfig = $config->get('db');
$db = new PDO(
    'mysql:host=127.0.0.1;dbname=gbk',
    $dbConfig['user'],
    $dbConfig['password']
);

$log = new Logger('gbk');
$logFile = $config->get('log');
$log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));

$di = new DependencyInjector();
$di->set('PDO',$db);
$di->set('Utils/config',$config);
$di->set('Logger',$log);

$router = new Router($di);
$responce = $router-> route(new Request());
echo $responce;
// exit();
// //---------------------------------------------------------------------------------

// // for user post
// if (isset($_POST['text'])) {
//     require_once $_SERVER['DOCUMENT_ROOT'] . '/book/UserPost.php';
//     $newpost = new UserPost();
//     $newpost->setPost($_POST['text']);
//     $newpost->setUserId($_SESSION['userId']);
//     if ($_FILES['upload']['name']) {
//         switch ($_FILES['upload']['type']) {
//         case 'image/jpeg':
//             $newpost->setPictureFilenameExt('jpeg');
//             break;
//         case 'image/png':
//             $newpost->setPictureFilenameExt('png');
//             break;
//         case 'image/gif':
//             $newpost->setPictureFilenameExt('gif');
//             break;
//         default:
//             echo ("nonononono");
//             header('Location: .');
//             exit();
//             break;
//         }
//         $newpost->setPicture(file_get_contents($_FILES['upload']['tmp_name']));
//         $newpost->setPictureTmpFilename($_FILES['upload']['tmp_name']);
//         $newpost->setPictureId($newpost->savePicture());
//     }
    
//     $newpost->saveUserPost();
//     header('Location: .');
//     exit();
// }
// // Display user session details
// if (isset($_SESSION['loggedIn'])) {
//     include $_SERVER['DOCUMENT_ROOT'] . '/login/logout.inc.html.php';
//   }  
// // Display guestbook body
// include $_SERVER['DOCUMENT_ROOT'] . '/book/index.php';
  ?>
    
</body>
</html>
