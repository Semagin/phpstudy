<?php

namespace Gbk\Domain;

class User {
	private $user_id;
	private $login_name;
	private $view_name;
	private $email;
	private $homepage;

	public function __construct ($userid, $loginname, $viewname, $useremail, $userhomepage)
	{
		$this->user_id=$userid;
		$this->login_name = $loginname;
		$this->view_name = $viewname;
		$this->email = $useremail;
		$this->homepage = $userhomepage;
	}

	public function getId(): int
	{
		return $this->user_id;
	}
}