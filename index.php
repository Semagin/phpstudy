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
        ?>
    </body>
</html>
