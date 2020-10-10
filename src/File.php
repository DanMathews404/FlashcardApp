<?php

declare(strict_types = 1);

namespace Flashcard;

class File
{
	public string $name;

	public function __construct(string $name, bool $readable = true, bool $writable = true)
	{
		$this->name = $name;

		$this->validateActions($readable, $writable);

		return $this;
	}

	protected function validateActions(bool $readable, bool $writable): void
	{
		if ($readable){
			$this->validateReadable();
		}

		if ($writable){
			$this->validateWritable();
		}
	}

	protected function validateReadable(): void
	{
		if (!is_readable($this->name)){
			throw new \Exception("The required file '" . $this->name . "' was not found to be readable");
		}
	}

	protected function validateWritable(): void
	{
		if (!is_writable($this->name)){
			throw new \Exception("The required file '" . $this->name . "' was not found to be writable");
		}
	}
}