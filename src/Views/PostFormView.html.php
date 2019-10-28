<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>

    <h3>Type your message here:</h3>
    <form action="" method="post" enctype="multipart/form-data">
      <div>
        <label for="text">Text: <input type="text" name="text"
            id="login"></label> <br>
        <label for="upload">Select file to upload:
        <input type="file" id="upload" name="upload"></label>
      </div>
      <div>
        <input type="hidden" name="action" value="upload">
      </div>
        <input type="submit" value="postit">
    </form>
