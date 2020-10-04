<?php

declare(strict_types = 1);

class CardController
{
	public function __construct()
	{
		$this->cardObjectCRUD = new ModelObjectCRUD('Card');
		$this->incrementalIdGenerator = new IncrementalIdGenerator('Card');
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
		$id = $this->incrementalIdGenerator->getNext();

		$card = new Card(
			$id,
			$_POST['category'],
			$_POST['question'],
			$_POST['answer']
		);

		$this->cardObjectCRUD->create($card);

		$this->incrementalIdGenerator->set($id);
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
