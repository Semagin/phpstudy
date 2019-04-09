<?php 
namespace Gbk\Views;


class RegView
{

function render(): string {
  return ('
    <form action="adduser" method="post">
      <div>
        <label for="login_name">Login Name: <input type="text" name="login_name"
            id="login_name" value=""></label>
      </div>
      <div>
        <label for="view_name">View Name: <input type="text" name="view_name"
            id="view_name" value=""></label>
      </div>
      <div>
        <label for="email">Email: <input type="text" name="email"
            id="email" value=""></label>
      </div>
      <div>
        <label for="webpage">Webpage: <input type="text" name="webpage"
            id="webpage" value=""></label>
      </div>
      <div>
        <label for="password">Set password: <input type="password"
            name="passwd" id="password"></label>
        <input type="hidden" name="id" value="">
        <input type="hidden" name="action" value="newlogin">
        <p><input type="submit" value="register"></p>
      </div>
    </form>
  ');
}



}