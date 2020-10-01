<?php

declare(strict_types = 1);

class Card extends Model
{
	public $id;

	public $category;

	public $question;

	public $answer;

	public function __construct(string $id, string $category, string $question, string $answer)
	{
		$this->id = $id;
		$this->category = $category;
		$this->question = $question;
		$this->answer = $answer;
	}
}
