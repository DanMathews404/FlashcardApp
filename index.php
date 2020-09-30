<?php

declare(strict_types = 1);

include 'Validator.php';

class CsvToObjectArray
{
	protected object $validator;

	protected array $expectedCsvHeaders;


	public function __construct()
	{
		$this->validator = new Validator();
	}


	public function read(string $className): array
	{
		include $className . ".php";

		$csvFilename = $className . "s.csv";

		$handle = fopen($csvFilename, 'r');

		$actualCsvHeaders = fgetcsv($handle);

		$this->setExpectedCsvHeadersFromClassConstructor($className);

		$this->validator->validateCsvHeaders($this->expectedCsvHeaders, $actualCsvHeaders);

		$results = [];

		$count = 0;

		while (!feof($handle)){
			$row = fgetcsv($handle);

			if (!$row){
				continue;
			}

			$results[$count] = new Card(...$row);

			++$count;
		}

		fclose($handle);

		return $results;
	}


	protected function setExpectedCsvHeadersFromClassConstructor(string $className): void
	{
		$this->expectedCsvHeaders = [];

		$reflectionClass = new ReflectionClass($className);

		$classConstructorParams = $reflectionClass->getConstructor()->getParameters();

		$count = 0;

		foreach($classConstructorParams as $param){

			$this->validator->validateParamTypeString($param);

			$this->expectedCsvHeaders[$count] = $param->name;

			++$count;

		}

		return;
	}
}

$csvToObjectArray = new CsvToObjectArray();
$results = $csvToObjectArray->read('Card');
var_dump($results);
