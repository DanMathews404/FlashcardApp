<?php

declare(strict_types = 1);

namespace Flashcard\Controller;

use Flashcard\LazyObjectCRUD;
use Flashcard\Redirect;
use Flashcard\View\View;

class CardController
{
	protected LazyObjectCRUD $cardObjectCRUD;

	protected Redirect $redirect;

	protected View $view;

	public function __construct()
	{
		$this->cardObjectCRUD = new LazyObjectCRUD();

		$this->redirect = new Redirect();

		$this->view = new View();
	}

	public function index(): void
	{
		$cards = $this->cardObjectCRUD->read();

		$data = ['cards' => $cards];

		$this->view->display('Card/index.php', $data);
	}

	public function show(string $id): void
	{
		//show individual record
	}

	public function createForm()
	{
		$this->view->display('Card/createForm.php');
	}

	public function create(string $category, string $question, string $answer)
	{
		$this->cardObjectCRUD->create($category, $question, $answer);

		$this->redirect->sendTo("/index");
	}

	public function edit()
	{
		//return edit view
	}

	public function update()
	{
		//update record
	}

	public function delete(string $id)
	{
		$this->cardObjectCRUD->delete($id);

		$this->redirect->sendTo("/index");
	}
}