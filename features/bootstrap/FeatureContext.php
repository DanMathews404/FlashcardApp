<?php

use Behat\Behat\Context\ClosuredContextInterface,
	Behat\Behat\Context\TranslatedContextInterface,
	Behat\Behat\Context\BehatContext,
	Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
	Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
	/**
	 * Initializes context.
	 * Every scenario gets its own context object.
	 *
	 * @param array $parameters context parameters (set them up through behat.yml)
	 */
	public function __construct(array $parameters)
	{
		// Initialize your context here
	}

	/**
	 * @Given /^I am on the "([^"]*)" page$/
	 */
	public function iAmOnThePage($page)
	{
		require 'vendor/autoload.php';

		$this->app = new Flashcard\App();
	}

	/**
	 * @Then /^I should receive a list of flashcards$/
	 */
	public function iShouldReceiveAListOfFlashcards()
	{
		if (!is_a($this->app->cardController->cardObjectCRUD->read()[0], 'Flashcard\Card')){
			throw new Exception("LazyObjectCRUD didn't return a Card object to CardController index");
		}
	}
}
