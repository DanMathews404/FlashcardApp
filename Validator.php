<?php

class Validator
{
    public function validateCsvHeaderNames (array $expectedHeaders, array $headers): void
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
            if ($param->getType()->getName() !== 'string'){
                throw new Exception();
            }
        } catch (Throwable $e){
            echo "Type of anything but string not allowed\n";
            exit();
        }
	}
}
