<?php

declare(strict_types = 1);

namespace Flashcard\View;

class View
{
	public function display($file, $data = null): void
	{
	    $filename = $file;
	    include $filename;
	}
}