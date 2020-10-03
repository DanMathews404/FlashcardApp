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
		$this->cardController->index();
	}
}
