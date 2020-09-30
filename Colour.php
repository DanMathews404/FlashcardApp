<?php

class Colour
{
	public function __construct(string $id, string $colour, string $season)
	{
		$this->id = $id;
		$this->colour = $colour;
		$this->season = $season;
	}
}
