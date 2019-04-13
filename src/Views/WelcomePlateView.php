<?php 
namespace Gbk\Views;


class WelcomePlateView
{

  function render(): string {
    
    return ('
      <p id="loginform">You are not logged in <br>
    please <a href="login">login </a> or <a href="/register">register</a>  to leave a message </p>
    <h1 id="welcomephrase">Welcome to my guestbook!</h1>
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
}