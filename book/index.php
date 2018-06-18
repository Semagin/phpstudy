<?php
include_once $_SERVER['DOCUMENT_ROOT'] .  '/includes/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // The basic SELECT statement
  $select = 'SELECT post_id, user_text, post_date';
  $from   = ' FROM posts';
  $where  = ' WHERE TRUE';

  try
  {
    $sql = $select . $from . $where;
    $s = $pdo->prepare($sql);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching posts.';
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $posts[] = array('post_id' => $row['post_id'], 'text' => $row['user_text'], 'post_date' => $row['post_date']);
  }

  include 'book.html.php';
  if (isset($_SESSION['loggedIn']))
 {
    include 'postform.html.php';
  }
  exit();
