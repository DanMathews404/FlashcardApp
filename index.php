<?php

declare(strict_types = 1);

include 'ObjectsFromCsv.php';

$colourObjectsFromCsv = new ObjectsFromCsv('Colour');

$results = $colourObjectsFromCsv->run();

var_dump($results);
