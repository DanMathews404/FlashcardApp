<?php

declare(strict_types = 1);

namespace Flashcard\Controller;

use Flashcard\Card;
use Flashcard\LazyObjectCRUD;

class CardController
{
	protected LazyObjectCRUD $cardObjectCRUD;

	public function __construct()
	{
		$this->cardObjectCRUD = new LazyObjectCRUD();
	}

	public function index(): array
	{
		return $this->cardObjectCRUD->read();
	}

	public function show(string $id): Card
	{
        return $this->cardObjectCRUD->get($id);
	}

	//TODO use union types when available in php 8 to throw void or error string or exception etc.
	public function create(string $category, string $question, string $answer): ?Card //| void
	{
		$card = new Card(null, $category, $question, $answer);

        $createdCard = $this->cardObjectCRUD->create($card);

		if (get_class($createdCard) == 'Flashcard\Card'){
            return $createdCard;
        } else {
//		    return throw new \Exception("returned object was not of the Card class");
		    return null;
        }
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

        return null;
	}
}
