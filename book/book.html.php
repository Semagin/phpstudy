<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>guestbook</title>
  </head>
  <body>
    <h1>Resent posts</h1>
    <?php if (isset($posts)): ?>
      <table>
        <tr><th>Post ID</th><th>Post text</th><th>Post Date</th></tr>
        <?php foreach ($posts as $post): ?>
        <tr valign="top">
          <td><?php markdownout($post['post_id']); ?></td>
          <td>
          <?php markdownout($post['text']); ?>
          </td>
          <td><?php markdownout($post['post_date']); ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
    <p><a href="..">Return to home</a></p>
<!--    <?php  if (isset($_SESSION['loggedIn'])) include 'logout.inc.html.php'; ?>-->
  </body>
</html>
