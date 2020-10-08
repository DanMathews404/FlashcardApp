<?php

declare(strict_types = 1);

namespace Flashcard;

class LazyObjectCRUD
{
	protected $className;

	protected $csvFilename;

	protected $classFilename;

	protected $validator;

	protected $reflectionClass;

	protected $expectedCsvHeaders;

	protected $classConstructorParams;



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

		$this->className = $className;

		$this->csvFilename = "src//" . $className . "s.csv";

		$this->classFilename = "src//" . $className . ".php";

		$this->validator->validateReadableFiles([$this->csvFilename, $this->classFilename]);

		$this->reflectionClass = $this->validator->validReflectionClass($className);

		$this->validator->validateClassConstructorAndParamsExist($this->reflectionClass);

		$this->classConstructorParams = $this->reflectionClass->getConstructor()->getParameters();

		$this->validator->validateParamsTypeString($this->classConstructorParams);

		$this->params = $this->validator->validateParamsAgainstCsv($this->classConstructorParams, $this->csvFilename);
	}



	public function read(): array
	{
		$handle = fopen($this->csvFilename, 'r');

		$headers = fgetcsv($handle);

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

		for ($i = 1; $i < count($this->params); $i++){
			$params[$i] = $_POST[$this->params[$i]];
		}

		$object = $this->reflectionClass->newInstance(...$params);

		$fields = $this->getFieldDataFromObject($object);

		$handle = fopen($this->csvFilename, 'a+');

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

	protected function getFieldDataFromObject($object): array
	{
		$fields = [];

		foreach ($this->classConstructorParams as $param){
			$paramName = $param->name;

			$fields[$paramName] = $object->$paramName;
		}

		return $fields;
	}
}
