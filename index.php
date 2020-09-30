<?php

declare(strict_types = 1);

include 'Validator.php';

class CsvToObjectArray
{
	public function __construct()
	{
		$this->validator = new Validator();
	}

	public function read($className)
	{
		include $className . ".php";

		$csvFileName = $className . "s.csv";

		$handle = fopen($csvFileName, 'r');

		$headers = fgetcsv($handle);

		$expectedHeaders = [];

		$class = new ReflectionClass($className);
		$classConstructorParams = $class->getConstructor()->getParameters();
		foreach($classConstructorParams as $param){
			$this->validator->validateParamTypeString($param);
			array_push($expectedHeaders, $param->name);
		}

		$this->validator->validateCsvHeaderNames($expectedHeaders, $headers);

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
}

$csvToObjectArray = new CsvToObjectArray();
$results = $csvToObjectArray->read('Card');
var_dump($results);
