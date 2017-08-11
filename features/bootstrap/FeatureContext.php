<?php

namespace uk\org\brentso\concertmanagement\features\bootstrap;

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\MinkExtension\Context\MinkAwareContext;
use Behat\Mink\Mink;

use uk\org\brentso\concertmanagement\features\pages;

require_once 'vendor/autoload.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends PageObjectContext implements MinkAwareContext
{

	/**
	 * @var Mink
	 */
	private $mink;

	/**
	 * @var array
	 */
	private $minkParameters;

	private $dashboard;
	private $login;

	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 */
	public function __construct(
		pages\Dashboard $dashboard,
		pages\Login $login
		)
	{
		$this->dashboard = $dashboard;
		$this->login = $login;
	}

	/**
	 * @Given I visit the administration page
	 */
	public function iVisitTheAdministrationPage()
	{
		$this->dashboard->open();
	}

	/**
	 * @When I look at the menu
	 */
	public function iLookAtTheMenu()
	{
		// nothing to do
	}

	/**
	 * @Then I can see the Concert menu item
	 */
	public function iCanSeeTheConcertMenuItem()
	{
		$this->dashboard->concert_post_type_exists();
	}

	/**
	 * @Given I visit the login page
	 */
	public function iVisitTheLoginPage()
	{
		$this->login->open();
	}

	/**
	 * @When I submit valid credentials
	 */
	public function iSubmitValidCredentials()
	{
		$this->login->login();
	}

	/**
	 * @Then I should be taken to the dashboard page
	 */
	public function iShouldBeTakenToTheDashboardPage()
	{
		$this->dashboard->isOpen();
	}

	/**
	 * {@inheritdoc}
	 */
	public function setMink(Mink $mink)
	{
		$this->mink = $mink;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setMinkParameters(array $parameters)
	{
		$this->minkParameters = $parameters;
	}


}
