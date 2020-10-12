<?php

declare(strict_types = 1);

namespace Flashcard;

class Card
{
	public ?string $id;

	public string $category;

	public string $question;

	public string $answer;

	public function __construct(?string $id, string $category, string $question, string $answer)
	{
		$this->id = $id;
		$this->category = $category;
		$this->question = $question;
		$this->answer = $answer;
	}
}
