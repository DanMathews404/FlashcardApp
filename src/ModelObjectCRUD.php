<?php

declare(strict_types = 1);

namespace Flashcard;

class ModelObjectCRUD
{
	protected $className;

	protected File $csvFile;

	protected File $classFile;

	protected Validator $validator;

	protected \ReflectionClass $reflectionClass;

	protected $expectedCsvHeaders;

	protected $classConstructorParams;



	public function __construct(string $className)
	{
		$this->validator = new Validator();

		$this->className = $className;

		$this->csvFile = new CSVFile("src/" .  $className . "s.csv");

		$this->classFile = new File("src/" . $className . ".php");

		$this->reflectionClass = $this->validator->validReflectionClass($className);

		$this->validator->validateClassConstructorAndParamsExist($this->reflectionClass);

		$this->classConstructorParams = $this->reflectionClass->getConstructor()->getParameters();

		$this->validator->validateParamsTypeString($this->classConstructorParams);

//		$this->validator->validateParamsAgainstCsv($this->classConstructorParams, $this->csvFile->name);

		$this->validateParamsAgainstHeaders();
	}



	public function read(): array
	{
		$handle = fopen($this->csvFile->name, 'r');

		$headers = fgetcsv($handle);

		$results = [];

		$count = 0;

		while (!feof($handle)){
			$row = fgetcsv($handle);

			if (!$row){
				continue;
			}

			$results[$count] = $this->reflectionClass->newInstance(...$row);

			++$count;
		}

		fclose($handle);

		return $results;
	}

	public function create(Card $object): void
	{
		$this->validator->validateObjectIsInstanceOfClass($object, $this->className);

		$fields = $this->getFieldDataFromObject($object);

		$handle = fopen($this->csvFile->name, 'a');

		//TODO fputcsv doesn't put double quotes around everything, this feels inconsistent - replace with fwrite?
		fputcsv($handle, $fields);

		fclose($handle);
	}

	protected function getFieldDataFromObject($object): array
	{
		$fields = [];

		foreach ($this->classConstructorParams as $param){
			$paramName = $param->name;

			$fields[$paramName] = $object->$paramName;
		}

		return $fields;
	}

	public function validateParamsAgainstHeaders(): void
	{
		$expectedCsvHeaders = [];

		$count = 0;

		foreach($this->classConstructorParams as $param){
			$expectedCsvHeaders[$count] = $param->name;

			++$count;
		}

		if ($this->csvFile->headers !== $expectedCsvHeaders){
			throw new \Exception("In the csv '" . $this->csvFile->name . "' the actual headers (" . implode(',', $this->csvFile->headers) . ") were not the expected headers (" . implode(',', $expectedCsvHeaders) . ")");
		}
	}
}
