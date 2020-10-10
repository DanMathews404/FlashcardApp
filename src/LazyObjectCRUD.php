<?php

declare(strict_types = 1);

namespace Flashcard;

class LazyObjectCRUD
{
	protected File $csvFile;

	protected File $classFile;

	protected Validator $validator;

	protected \ReflectionClass $reflectionClass;

	protected array $classConstructorParams;

	protected IncrementalIdGenerator $incrementalIdGenerator;


	public function __construct(string $className = null)
	{
		if ($className == null) {
			$callingFileName = debug_backtrace()[0]['file'];

			preg_match('/[^\\\]+(?=Controller.php)/', $callingFileName, $matches);

			if ($matches) {
				$className = $matches[0];
			} else {
				echo 'lazyObjectCRUD called from an incompatible filename';
				exit();
			}
		}

		$this->validator = new Validator();

		$this->incrementalIdGenerator = new IncrementalIdGenerator('Card');

		$this->csvFile = new CSVFile("src/" .  $className . "s.csv");

		$this->classFile = new File("src/" . $className . ".php");

		$this->reflectionClass = $this->validator->validReflectionClass($className);

		$this->validator->validateClassConstructorAndParamsExist($this->reflectionClass);

		$this->classConstructorParams = $this->reflectionClass->getConstructor()->getParameters();

		$this->validator->validateParamsTypeString($this->classConstructorParams);

		$this->validateParamsAgainstHeaders();
	}



	public function read(): array
	{
		$handle = fopen($this->csvFile->name, 'r');

		fgetcsv($handle);

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

	public function create(...$params): void
	{
		$id = $this->incrementalIdGenerator->getNext();

		$params[0] = $id;

		for ($i = 1; $i < count($this->csvFile->headers); $i++){
			$params[$i] = $_POST[$this->csvFile->headers[$i]];
		}

		$object = $this->reflectionClass->newInstance(...$params);

		$fields = $this->getFieldDataFromObject($object);

		$handle = fopen($this->csvFile->name, 'a+');

		fseek($handle, fstat($handle)['size'] - 1);

		$lastCharacter = fread($handle, 1);

		if($lastCharacter !== "\n"){
			fwrite($handle, "\n");
		}

		//TODO fputcsv doesn't put double quotes around everything, this feels inconsistent - replace with fwrite?
		fputcsv($handle, $fields);

		fclose($handle);

		$this->incrementalIdGenerator->set($id);
	}

	protected function getFieldDataFromObject(object $object): array
	{
		$fields = [];

		foreach ($this->classConstructorParams as $param){
			$paramName = $param->name;

			$fields[$paramName] = $object->$paramName;
		}

		return $fields;
	}

	public function validateParamsAgainstHeaders(): void
	{
		$expectedCsvHeaders = [];

		$count = 0;

		foreach($this->classConstructorParams as $param){
			$expectedCsvHeaders[$count] = $param->name;

			++$count;
		}

		$this->csvFile->validateHeaders($expectedCsvHeaders);
	}
}
