<?php
include_once $_SERVER['DOCUMENT_ROOT'] .  '/includes/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
include 'book.html.php';

if (isset($_SESSION['loggedIn'])) {
    include 'postform.html.php';
}
 