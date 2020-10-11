<?php

declare(strict_types = 1);

namespace Flashcard;

use Flashcard\Controller\CardController;

include '.env.php';

class App
{
	protected CardController $cardController;

	protected Redirect $redirect;

	public function __construct()
	{
		$this->cardController = new CardController();

		$this->redirect = new Redirect();
	}

	public function run()
	{
		$uri = $_SERVER['REQUEST_URI'];

		if (preg_match('/^\/index$/', $uri) == 1) {
			$this->cardController->index();
		} elseif (preg_match('/^\/createForm$/', $uri) == 1) {
			$this->cardController->createForm();
		} elseif (preg_match('/^\/create$/', $uri) == 1) {
			$this->cardController->create($_POST['category'], $_POST['question'], $_POST['answer']);
		} elseif (preg_match('/^\/delete$/', $uri) == 1) {
			$this->cardController->delete($_POST['id']);
		} else {
			$this->redirect->sendTo("/index");
		}
	}
}
