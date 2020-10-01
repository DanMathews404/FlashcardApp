<?php

declare(strict_types = 1);

class App
{
	public function __construct()
	{
		spl_autoload_register(function ($class){
    		include $class . '.php';
		});
	}

	public function run()
	{
		$cardModel = new Model('Card');

		$cards = $cardModel->getData();

		$cardsView = new CardsView($cards);

		$cardsView->display();
	}
}
