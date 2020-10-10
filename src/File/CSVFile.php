<?php

declare(strict_types = 1);

namespace Flashcard\File;

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

	public function validateHeaders(array $expectedHeaders): void
	{
		if ($this->headers !== $expectedHeaders){
			throw new \Exception("In the csv '" . $this->name . "' the actual headers (" . implode(', ', $this->headers) . ") were not the expected headers (" . implode(', ', $expectedHeaders) . ")");
		}
	}
}