<?php

declare(strict_types = 1);

namespace Flashcard;

use Flashcard\File\CSVFile;

class IncrementalIdGenerator
{
	protected string $className;

	protected int $startOfLine;

	protected array $classLine;

	protected CSVFile $csvFile;

	protected Redirect $redirect;

	public function __construct(string $className)
	{
		$this->validator = new Validator();

		$this->csvFile = new CSVFile ("src/IncrementalIdGenerator.csv");

		$this->className = $className;

		$this->csvFile->validateHeaders(['model', 'id']);
	}

	public function getNext(): string
	{
		$handle = fopen($this->csvFile->name, 'r+');

		$this->findClassLine($handle);

		fclose($handle);

		$id = intval($this->classLine[1]) + 1;

		return strval($id);
	}

	public function set(string $id): void
	{
		$handle = fopen($this->csvFile->name, 'r+');

		$this->findClassLine($handle);

		fseek($handle, $this->startOfLine);

		fputcsv($handle, [$this->className, $id]);

		fclose($handle);
	}

    /**
     * @param $handle
     */
    protected function findClassLine($handle): void
	{
		$found = false;

		$line = null;

		$startOfLine = 0;

		while ($line !== false){
			$startOfLine = ftell($handle);

			$line = fgetcsv($handle);

			if ($line[0] == $this->className){
				$found = true;
				break;
			}
		}

		if ($found == false){
			echo "No line matching class '" . $this->className . "' in '" . $this->csvFile->name . "'";
			exit();
		}

		$this->classLine = $line;
		$this->startOfLine = $startOfLine;
	}
}
