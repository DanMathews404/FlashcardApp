<?php

declare(strict_types = 1);

class Validator
{
    public function validateCsvHeaders (array $expectedHeaders, array $headers): void
    {
        try {
            if ($headers !== $expectedHeaders){
                throw new Exception();
        	}
        } catch (Throwable $e) {
            echo "The headers of the csv were not the expected headers.\n";
            echo "Expected headers: " . implode(',', $expectedHeaders);
            echo "\n";
            echo "Actual headers: " . implode(',', $headers);
            echo "\n";
            exit();
        }
    }

	public function validateParamTypeString($param)
	{
        try {
            if (
				$param->getType() == null ||
				$param->getType()->getName() == 'string'
			){
				return;
			} else {
                throw new Exception();
            }
        } catch (Throwable $e){
            echo "All constructor parameters in the class must be of unspecified type, or specified as a string type\n";
            exit();
        }
	}

    public function validateReadableFiles(array $filenames): void
    {
		$inaccessibleFilenames = false;

		foreach ($filenames as $filename){
            if (!is_readable($filename)){
	            echo "The required file " . $filename . " was not found to be readable.\n";
				$inaccessibleFilenames = true;
			}
		}

		if ($inaccessibleFilenames){
            exit();
		}
    }

	public function validateClassConstructorAndParamsExist(object $reflectionClass): void
	{
        try {
            $reflectionClass->getConstructor()->getParameters();
        } catch (Throwable $e) {
            echo "Constructor in class not found\n";
            exit();
        }
		try {
			if ($reflectionClass->getConstructor()->getParameters() == null) {
				throw new Exception();
			}
		} catch (Throwable $e) {
			echo "No constructor parameters found.\n";
			exit();
		}
	}
}
