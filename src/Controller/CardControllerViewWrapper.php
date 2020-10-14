<?php

declare(strict_types = 1);

namespace Flashcard\Controller;

use Flashcard\Redirect;
use Flashcard\View\View;

class CardControllerViewWrapper
{
	protected CardController $cardController;

	protected Redirect $redirect;

	protected View $view;

	public function __construct(CardController $cardController, Redirect $redirect)
	{
		$this->cardController = $cardController;

		$this->redirect = $redirect;

		$this->view = new View();
	}

	public function index(): void
	{
		$cards = $this->cardController->index();

		$data = ['cards' => $cards];

		$this->view->display('Card/index.php', $data);
	}

	public function show(...$params): void
	{
		$card = $this->cardController->show(...$params);

		$data = ['cards' => [$card]];

		$this->view->display('Card/index.php', $data);
	}

	public function createForm(): void
	{
		$this->view->display('Card/createForm.php');
	}

	public function create(...$params): void
	{
		$this->cardController->create(...$params);

		$this->redirect->sendTo("/index");
	}

	public function updateForm(): void
	{
		//return update form view
	}

	public function update(): void
	{
		//update record
	}

	public function delete(...$params): void
	{
		$this->cardController->delete(...$params);

		$this->redirect->sendTo("/index");
	}
}
