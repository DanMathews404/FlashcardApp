<?php

declare(strict_types = 1);

namespace Flashcard\View;

class View
{
	public function display(string $file, array $data = null): void
	{
		include 'template.php';
		include $file;
	}
}