<?php

namespace uk\org\brentso\concertmanagement\features\pages;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

require_once 'vendor/autoload.php';

class Login extends Page {

	protected $path = '/wp-login.php?';

	protected $elements = array (
		'Login Form' => 'form#loginform',
		'Username Field' => 'input#user_login',
		'Password Field' => 'input#user_pass'
	);

	private $adminUser = 'testadmin';
	private $adminPassword = '*zlGWWiHumMK1L8e5fqy4(NA';

	public function login() {
		$this->getElement('Username Field')->setValue($this->adminUser);
		$this->getElement('Password Field')->setValue($this->adminPassword);
		$this->getElement('Login Form')->submit();
		return true;
	}

}
