<?php 
namespace Gbk\Views;

class WelcomePlateView
{

  function render(): string {
    return ('
    <div>
      <div id="welcomephrase">Welcome to my guestbook!</div>
      <div id="loginform">You are not logged in please <a href="login">login </a> or <a href="/register">register</a>  to leave a message </div>
    </div>
    ');
  }
}