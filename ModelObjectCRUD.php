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

		$this->reflectionClass = $this->validator->validReflectionClass($className);

		$this->validator->validateClassConstructorAndParamsExist($this->reflectionClass);

		$this->classConstructorParams = $this->reflectionClass->getConstructor()->getParameters();

		$this->validator->validateParamsTypeString($this->classConstructorParams);

		$this->validator->validateParamsAgainstCsv($this->classConstructorParams, $this->csvFilename);
	}



	public function read(): array
	{
		$handle = fopen($this->csvFilename, 'r');

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

	public function create(object $object): void
	{
		$this->validator->validateObjectIsInstanceOfClass($object, $this->className);

		$fields = [];

		foreach ($this->classConstructorParams as $param){
			$paramName = $param->name;

			$fields[$param->name] = $object->$paramName;
		}

		$handle = fopen($this->csvFilename, 'a');

		//TODO fputcsv doesn't put double quotes around everything, this feels inconsistent - replace with fwrite?
		fputcsv($handle, $fields);

		fclose($handle);
	}
}
