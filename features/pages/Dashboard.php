<?php

namespace uk\org\brentso\concertmanagement\features\pages;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

require_once 'vendor/autoload.php';

class Dashboard extends Page {

	protected $path = '/wp-admin/';

	protected $elements = array (
		'Concert Posts Menu Item' => 'li#menu-posts-concert'
	);

	public function concert_post_type_exists() {
		$this->getElement('Concert Posts Menu Item'); // will throw exception if absent
		return true;
	}

}
