<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class LazyObjectCRUDTest extends TestCase
{
	public function testCanBeCreatedFromValidClassName(): void
	{
		$this->assertInstanceOf(
            'Flashcard\LazyObjectCRUD',
            new Flashcard\LazyObjectCRUD('Card')
		);
	}

	public function testCannotBeCreatedFromArray(): void
	{
		$this->expectException(TypeError::class);

		new Flashcard\LazyObjectCRUD([1]);
	}
}
