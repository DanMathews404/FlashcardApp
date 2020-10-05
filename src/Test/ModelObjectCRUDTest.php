<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ModelObjectCRUDTest extends TestCase
{
	public function testCanBeCreatedFromValidClassName(): void
	{
		$this->assertInstanceOf(
			'Flashcard\ModelObjectCRUD',
			new Flashcard\ModelObjectCRUD('Card')
		);
	}

	public function testCannotBeCreatedFromArray(): void
	{
		$this->expectException(TypeError::class);

		new Flashcard\ModelObjectCRUD([1]);
	}
}
