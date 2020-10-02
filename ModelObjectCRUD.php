<?php

declare(strict_types = 1);

class ModelObjectCRUD
{
	protected string $className;

	protected string $csvFilename;

	protected string $classFilename;

	protected object $validator;

	protected object $reflectionClass;

	protected array $expectedCsvHeaders;

	protected array $classConstructorParams;



	public function __construct(string $className)
	{
		$this->validator = new Validator();

		$this->className = $className;

		$this->csvFilename = $className . "s.csv";

		$this->classFilename = $className . ".php";

		$this->validator->validateReadableFiles([$this->csvFilename, $this->classFilename]);

		$this->reflectionClass = new ReflectionClass($className);

		$this->validator->validateClassConstructorAndParamsExist($this->reflectionClass);

		$this->classConstructorParams = $this->reflectionClass->getConstructor()->getParameters();

		$this->setExpectedCsvHeadersFromClassConstructor();
	}



	public function read(): array
	{
		$handle = fopen($this->csvFilename, 'r');

		$actualCsvHeaders = fgetcsv($handle);

		$this->validator->validateCsvHeaders($this->expectedCsvHeaders, $actualCsvHeaders);

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



	protected function setExpectedCsvHeadersFromClassConstructor(): void
	{
		$this->expectedCsvHeaders = [];

		$count = 0;

		foreach($this->classConstructorParams as $param){
			$this->validator->validateParamTypeString($param);

			$this->expectedCsvHeaders[$count] = $param->name;

			++$count;
		}

		return;
	}
}
