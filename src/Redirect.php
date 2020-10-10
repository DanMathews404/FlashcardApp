<?php

declare(strict_types = 1);

namespace Flashcard;

class Redirect
{
	protected string $domain;

	public function __construct()
	{
		if (null == getenv('APP_DOMAIN')){
			echo 'no app_domain registered in env file for redirect';
			exit();
		} else {
			$this->domain = getenv('APP_DOMAIN');
		}
	}

	public function go(string $uri): void
	{
		if ($this->domain == "localhost"){
			header("Location: http://localhost:" . $_SERVER['SERVER_PORT'] . $uri);
		} else {
			header("Location: http://" . $this->domain . $uri);
		}
	}
}
