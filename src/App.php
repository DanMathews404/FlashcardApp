<?php

declare(strict_types = 1);

namespace Flashcard;

use Flashcard\Controller\CardController;
use Flashcard\Controller\CardControllerViewWrapper;

include '.env.php';

class App
{
	protected CardController $cardController;

	protected Redirect $redirect;

	public function __construct()
	{
		$this->redirect = new Redirect();

		$this->cardController = new CardController();

		$this->cardControllerViewWrapper = new CardControllerViewWrapper($this->cardController, $this->redirect);
	}

	public function run()
	{
		$uri = $_SERVER['REQUEST_URI'];

		if (preg_match('/^\/api\/.*/', $uri)) {
			//Card API Routes

			header('Content-Type: application/json');

			if (preg_match('/^\/api\/index$/', $uri) == 1) {
				$response = $this->cardController->index();
				http_response_code(200);
			} elseif (preg_match('/^\/api\/create$/', $uri) == 1) {
				$response = $this->cardController->create($_POST['category'], $_POST['question'], $_POST['answer']);
				http_response_code(201);
			} elseif (preg_match('/^\/api\/delete$/', $uri) == 1) {
				$response = $this->cardController->delete($_POST['id']);
				http_response_code(204);
			} elseif (preg_match('/(?<=^\/api\/show\/)[0-9]+$/', $uri, $matches) == 1) {
				$response = $this->cardController->show($matches[0]);
				http_response_code(200);
			} else {
				http_response_code(404);
				$response = 'Endpoint not found';
			}

			echo json_encode($response);
		} else {
			//Card Web Routes

			if (preg_match('/^\/index$/', $uri) == 1) {
				$this->cardControllerViewWrapper->index();
			} elseif (preg_match('/^\/createForm$/', $uri) == 1) {
				$this->cardControllerViewWrapper->createForm();
			} elseif (preg_match('/^\/create$/', $uri) == 1) {
				$this->cardControllerViewWrapper->create($_POST['category'], $_POST['question'], $_POST['answer']);
			} elseif (preg_match('/^\/delete$/', $uri) == 1) {
				$this->cardControllerViewWrapper->delete($_POST['id']);
			} elseif (preg_match('/(?<=^\/show\/)[0-9]+$/', $uri, $matches) == 1) {
				$this->cardControllerViewWrapper->show($matches[0]);
			} else {
				$this->redirect->sendTo("/index");
			}
		}
	}
}
