<?php

declare(strict_types = 1);

class IncrementalIdGenerator
{
	public function __construct(string $className)
	{
		$this->filename = 'IncrementalIdGenerator.csv';

		$this->className = $className;

//		$this->validator->validateReadableFiles([$this->filename]);

//		$this->reflectionClass = $this->validator->validReflectionClass($className);

//		$this->validator->validateClassConstructorAndParamsExist($this->reflectionClass);

//		$this->classConstructorParams = $this->reflectionClass->getConstructor()->getParameters();

//		$this->validator->validateParamsTypeString($this->classConstructorParams);

//		$this->validator->validateParamsAgainstCsv($this->classConstructorParams, $this->csvFilename);
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
		while ($line !== false){
			$startOfLine = ftell($handle);

			$line = fgetcsv($handle);

			if ($line[0] == $this->className){
				break;
			}
		}

		$this->classLine = $line;
		$this->startOfLine = $startOfLine;
	}
}
