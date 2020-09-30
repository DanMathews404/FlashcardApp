<?php

declare(strict_types = 1);

include 'Validator.php';

class CsvToObjectArray
{
	protected string $csvFilename;

	protected array $expectedCsvHeaders = [];

	protected array $actualCsvHeaders = [];

	public function __construct()
	{
		$this->validator = new Validator();
	}

	public function read($className)
	{
		include $className . ".php";

		$this->csvFilename = $className . "s.csv";

		$reflectionClass = new ReflectionClass($className);

		$handle = fopen($this->csvFilename, 'r');

		$this->actualCsvHeaders = fgetcsv($handle);

		$classConstructorParams = $reflectionClass->getConstructor()->getParameters();

		foreach($classConstructorParams as $param){
			$this->validator->validateParamTypeString($param);
			array_push($this->expectedCsvHeaders, $param->name);
		}

		$this->validator->validateCsvHeaders($this->expectedCsvHeaders, $this->actualCsvHeaders);

		$this->results = [];

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
}

$csvToObjectArray = new CsvToObjectArray();
$results = $csvToObjectArray->read('Card');
var_dump($results);
