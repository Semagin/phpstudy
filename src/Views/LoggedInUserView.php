<?php 
namespace Gbk\Views;


class LoggedInUserView
{

  function render(): string {
    return ('
        <div id="loginspace">
          <form id="loginform" action="" method="post">
              '.$_SESSION['login_name'].'
              <input type="hidden" name="action" value="logout">
              <input type="hidden" name="goto" value="/1">
              <input type="submit" value="Log out">
          </form>
        </div>
    ');
  }
  
  public function postFormRender()
  {
        ob_start();
        include_once $_SERVER['DOCUMENT_ROOT'].'/src/Views/PostFormView.html.php';
        return ob_get_clean();
  }
}