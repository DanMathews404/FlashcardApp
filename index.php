<?php

declare(strict_types = 1);

include 'Card.php';
include 'Validator.php';

class CsvToObjectArray
{
	public function read($csvFileName, $className)
	{
		$handle = fopen($csvFileName, 'r');

		$headers = fgetcsv($handle);

		$validator = new Validator();

		$expectedHeaders = [];

		$class = new ReflectionClass($className);
		$classConstructorParams = $class->getConstructor()->getParameters();
		foreach($classConstructorParams as $param){
			$validator->validateParamTypeString($param);
			array_push($expectedHeaders, $param->name);
		}

		$validator->validateCsvHeaderNames($expectedHeaders, $headers);

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
$results = $csvToObjectArray->read('db.csv', 'Card');
var_dump($results);
