<?php 
namespace Gbk\Views;


class LoggedInUserView
{

  function render(): string {
    return ('
      <p>
      <form action="" method="post">
        <div id="loginform">
          '.$_SESSION['login_name'].'
          <input type="hidden" name="action" value="logout">
          <input type="hidden" name="goto" value="/1">
          <input type="submit" value="Log out">
        </div>
      </form>
      </p>
    ');

// not here


  //   return ('
  //     <h1>Log In</h1>
  //     <p>Please log in to view the page that you requested.</p>
  //     <form action="/index.php" method="post">
  //       <div>
  //         <label for="login_name">Login: <input type="text" name="login_name"
  //             id="login"></label>
  //       </div>
  //       <div>
  //         <label for="passwd">Password: <input type="password"
  //             name="passwd" id="password"></label>
  //       </div>
  //       <div>
  //         <input type="hidden" name="action" value="login">
  //         <input type="submit" value="Log in">
  //       </div>
  //     </form>
  //     <p><a href="/">home</a></p>
  // ');
  // }
  }
  public function postFormRender()
  {
        ob_start();
        include_once $_SERVER['DOCUMENT_ROOT'].'/src/Views/PostFormView.html.php';
        return ob_get_clean();
  }
}