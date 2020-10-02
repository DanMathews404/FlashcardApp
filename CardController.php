<?php

declare(strict_types = 1);

class CardController
{
	public function __construct()
	{
		$this->cardObjectCRUD = new ModelObjectCRUD('Card');
	}

	public function index()
	{
		$cards = $this->cardObjectCRUD->read();

		$cardsView = new CardsView($cards);

		$cardsView->display();
	}

	public function show($id)
	{
		//show individual record
	}

	public function create()
	{
		//return create view
	}

	public function store()
	{
		//store new record
	}

	public function edit()
	{
		//return edit view
	}

	public function update()
	{
		//update record
	}

	public function delete()
	{
		//remove record
	}
}
