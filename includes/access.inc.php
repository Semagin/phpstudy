<?php

function userIsLoggedIn()
{
    if ((isset($_POST['action']) and $_POST['action'] == 'login') or (isset($_POST['action']) and $_POST['action'] == 'newlogin')) {
        if (!isset($_POST['login_name']) or $_POST['login_name'] == '' or !isset($_POST['passwd']) or $_POST['passwd'] == '') {
            $GLOBALS['loginError'] = 'Please fill in both fields';
            return FALSE;
        }
        $passwd = md5($_POST['passwd'] . 'gbk');
        if (databaseContainsAuthor($_POST['login_name'], $passwd)) {
            session_start();
            $_SESSION['loggedIn'] = TRUE;
            $_SESSION['login_name'] = $_POST['login_name'];
            $_SESSION['passwd'] = $passwd;
            $_SESSION['userId'] = getUserId($_POST['login_name']);
            return TRUE;
        }
        else {
            session_start();
            unset($_SESSION['loggedIn']);
            unset($_SESSION['login_name']);
            unset($_SESSION['passwd']);
            unset($_SESSION['userId']);
            $GLOBALS['loginError'] = 'The specified login_name address or passwd was incorrect.';
            return FALSE;
        }
    }
    if (isset($_POST['action']) and $_POST['action'] == 'logout') {
        session_start();
        unset($_SESSION['loggedIn']);
        unset($_SESSION['login_name']);
        unset($_SESSION['passwd']);
        unset($_SESSION['userId']);
        header('Location: ' . $_POST['goto']);
        exit();
    }
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        return databaseContainsAuthor($_SESSION['login_name'], $_SESSION['passwd']);
    }
}

function databaseContainsAuthor($login_name, $passwd)
{
    include 'db.inc.php';
    try {
        $sql = 'SELECT COUNT(*) FROM users
        WHERE login_name = :login_name AND passwd = :passwd';
        $s = $pdo->prepare($sql);
        $s->bindValue(':login_name', $login_name);
        $s->bindValue(':passwd', $passwd);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Error searching for author.';
        include 'error.html.php';
        exit();
    }
    $row = $s->fetch();
    if ($row[0] > 0) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}

function getUserId($login_name)
{
   include 'db.inc.php';
   try {
        $sql = 'SELECT user_id FROM users where login_name=:login_name';
        $s = $pdo->prepare($sql);
        $s->bindValue(':login_name', $login_name);
        $s->execute();
    }
    catch (PDOException $e) {
        $error = 'Error searching for author.';
        include 'error.html.php';
        exit();
    }
    $row = $s->fetch();
    if ($row[0] > 0) {
        return $row[0];
    }
}