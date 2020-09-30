<?php

declare(strict_types = 1);

include 'ObjectsFromCsv.php';

$objectsFromCsv = new ObjectsFromCsv();

$results = $objectsFromCsv->run('Card');

var_dump($results);
