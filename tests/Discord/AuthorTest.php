<?php

namespace Kirby\Discord;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Author::class)]
class AuthorTest extends TestCase
{
	public function testFromArray(): void
	{
		$author = Author::from([
			'name' => 'Test Author'
		]);

		$this->assertSame([
			'icon_url' => null,
			'name'     => 'Test Author',
			'url'      => null,
		], $author->toArray());
	}

	public function testFromNull(): void
	{
		$this->assertNull(Author::from(null));
	}

	public function testFromObject(): void
	{
		$author = Author::from(new Author(name: 'Test Author'));

		$this->assertSame([
			'icon_url' => null,
			'name'     => 'Test Author',
			'url'      => null,
		], $author->toArray());
	}

	public function testGravatar(): void
	{
		$this->assertSame(
			'https://www.gravatar.com/avatar/bbe034b4f830b3b6643c24be59461f03a4077e7f77bf53a1ba674dc0a5ace7e4?d=',
			Author::gravatar('test@getkirby.com')
		);
	}
}
