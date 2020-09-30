<?php

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
}
