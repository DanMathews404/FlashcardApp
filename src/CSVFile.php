<?php

declare(strict_types = 1);

namespace Flashcard;

class CSVFile extends File
{
	public string $name;

	public array $headers;

	public function __construct(string $name, bool $readable = true, bool $writable = true)
	{
		parent::__construct($name, $readable, $writable);

		$this->headers = $this->getHeaders();

		return $this;
	}

	protected function getHeaders(): array
	{
		$handle = fopen($this->name, 'r');

		$headers = fgetcsv($handle);

		if (!is_array($headers)){
			throw new \Exception("Could not read the headers of '" . $this->name . "'");
		}

		fclose($handle);

		return $headers;
	}
}