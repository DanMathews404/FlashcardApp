<?php

declare(strict_types = 1);

namespace Flashcard;

class CardController
{
	public function __construct()
	{
		$this->cardObjectCRUD = new LazyObjectCRUD();
	}

	public function index(): void
	{
		$cards = $this->cardObjectCRUD->read();

		$cardsView = new CardsView($cards);

		$cardsView->display();
	}

	public function show($id)
	{
		//show individual record
	}

	public function createForm()
	{
		include 'createForm.php';
	}

	public function create()
	{
		$this->cardObjectCRUD->create();

		$this->redirect = new Redirect();

		$this->redirect->go("/index");
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
