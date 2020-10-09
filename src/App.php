<?php

declare(strict_types = 1);

namespace Flashcard;

include '.env.php';

class App
{
	public function __construct()
	{
		$this->cardController = new CardController();
	}

	public function run()
	{
		$uri = $_SERVER['REQUEST_URI'];

		if (preg_match('/^\/index$/', $uri) == 1) {
			$this->cardController->index();
		} elseif (preg_match('/^\/createForm$/', $uri) == 1) {
			$this->cardController->createForm();
		} elseif (preg_match('/^\/create$/', $uri) == 1) {
			$this->cardController->create();
		} else {
			$this->redirect = new Redirect();
			$this->redirect->go("/index");
		}
	}
}
