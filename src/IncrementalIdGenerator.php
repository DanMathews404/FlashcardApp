<?php

declare(strict_types = 1);

namespace Flashcard;

class IncrementalIdGenerator
{
	protected $className;

	protected $startOfLine;

	public function __construct(string $className)
	{
		$this->validator = new Validator();

		$this->filename = 'src/IncrementalIdGenerator.csv';

		$this->className = $className;

		$this->validator->validateReadableFiles([$this->filename]);

		$this->validator->validateWritableFiles([$this->filename]);

		$this->validator->validateHeadersAreExpected(['model', 'id'], $this->filename);
	}

	public function getNext(): string
	{
		$handle = fopen($this->filename, 'r+');

		$this->findClassLine($handle);

		fclose($handle);

		$id = intval($this->classLine[1]) + 1;

		return strval($id);
	}

	public function set(string $id): void
	{
		$handle = fopen($this->filename, 'r+');

		$this->findClassLine($handle);

		fseek($handle, $this->startOfLine);

		fputcsv($handle, [$this->className, $id]);

		fclose($handle);
	}

	protected function findClassLine($handle): void
	{
		$found = false;

		$line = null;

		$startOfLine = null;

		while ($line !== false){
			$startOfLine = ftell($handle);

			$line = fgetcsv($handle);

			if ($line[0] == $this->className){
				$found = true;
				break;
			}
		}

		if ($found == false){
			echo "No line matching class '" . $this->className . "' in '" . $this->filename . "'";
			exit();
		}

		$this->classLine = $line;
		$this->startOfLine = $startOfLine;
	}
}
