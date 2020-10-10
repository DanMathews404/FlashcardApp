<?php

declare(strict_types = 1);

namespace Flashcard;

class Validator
{
	public function validReflectionClass(string $className): \ReflectionClass
	{
		try {
			return new \ReflectionClass(__NAMESPACE__ . '\\' . $className);
		} catch (\Throwable $e){
			throw new \Exception("The Class was not found. It must be in the same namespace as the validator");
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
}
