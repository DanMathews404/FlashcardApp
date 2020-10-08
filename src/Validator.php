<?php

declare(strict_types = 1);

namespace Flashcard;

class Validator
{
	public function validReflectionClass(string $className): ?\ReflectionClass
	{
		try {
			return new \ReflectionClass(__NAMESPACE__ . '\\' . $className);
		} catch (\Throwable $e){
			echo "The Class was not found. It must be in the same namespace as the validator";
			exit();
		}
	}

	public function validateParamsTypeString(array $params): void
	{
		foreach ($params as $param) {
			try {
				if (
					$param->getType() == null ||
					$param->getType()->getName() == 'string'
				){
					continue;
				} else {
					throw new \Exception();
				}
			} catch (\Throwable $e){
				echo "All constructor parameters in the class must be of unspecified type, or specified as a string type<br>";
				exit();
			}
		}
	}

	public function validateReadableFiles(array $filenames): void
	{
		$inaccessibleFilenames = false;

		foreach ($filenames as $filename){
			if (!is_readable($filename)){
				echo "The required file " . $filename . " was not found to be readable.<br>";
				$inaccessibleFilenames = true;
			}
		}

		if ($inaccessibleFilenames){
			exit();
		}
	}

	public function validateWritableFiles(array $filenames): void
	{
		$inaccessibleFilenames = false;

		foreach ($filenames as $filename){
			if (!is_writable($filename)){
				echo "The required file " . $filename . " was not found to be writable.<br>";
				$inaccessibleFilenames = true;
			}
		}

		if ($inaccessibleFilenames){
			exit();
		}
	}

	public function validateClassConstructorAndParamsExist(\ReflectionClass $reflectionClass): void
	{
		try {
			$reflectionClass->getConstructor()->getParameters();
		} catch (\Throwable $e) {
			echo "Constructor in class not found<br>";
			exit();
		}
		try {
			if ($reflectionClass->getConstructor()->getParameters() == null) {
				throw new \Exception();
			}
		} catch (\Throwable $e) {
			echo "No constructor parameters found.<br>";
			exit();
		}
	}

	public function validateParamsAgainstCsv(array $params, string $csvFilename)//: void
	{
		$expectedCsvHeaders = [];

		$count = 0;

		foreach($params as $param){
			$expectedCsvHeaders[$count] = $param->name;

			++$count;
		}

		$this->validateHeadersAreExpected($expectedCsvHeaders, $csvFilename);

		return $expectedCsvHeaders;
	}

	public function validateHeadersAreExpected(array $expectedCsvHeaders, string $csvFilename): void
	{
		$handle = fopen($csvFilename, 'r');

		$actualCsvHeaders = fgetcsv($handle);

		fclose($handle);

		try {
			if ($actualCsvHeaders !== $expectedCsvHeaders){
				throw new \Exception();
			}
		} catch (\Throwable $e) {
			echo "The headers of the csv were not the expected headers.<br>";
			echo "Expected headers: " . implode(',', $expectedCsvHeaders);
			echo "<br>";
			echo "Actual headers: " . implode(',', $actualCsvHeaders);
			echo "<br>";
			exit();
		}
	}
}
