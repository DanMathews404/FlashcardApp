<?php

declare(strict_types = 1);

class App
{
	public function __construct()
	{
		spl_autoload_register(function ($class){
    		include $class . '.php';
		});

		$this->cardController = new CardController();
	}

	public function run()
	{
		$uri = $_SERVER[REQUEST_URI];

		if (preg_match('/^\/index$/', $uri) == 1) {
			$this->cardController->index();
		}

		if (preg_match('/^\/createForm$/', $uri) == 1) {
			$this->cardController->createForm();
		}

		if (preg_match('/^\/create$/', $uri) == 1) {
			$this->cardController->create();
		}
	}
}
