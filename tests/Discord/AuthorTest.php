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

	public function testGravatarWithDefault(): void
	{
		$hash = 'bbe034b4f830b3b6643c24be59461f03a4077e7f77bf53a1ba674dc0a5ace7e4';

		$this->assertSame(
			'https://www.gravatar.com/avatar/' . $hash . '?d=mp',
			Author::gravatar('test@getkirby.com', 'mp')
		);

		// image URLs need to be encoded to not break the query
		$this->assertSame(
			'https://www.gravatar.com/avatar/' . $hash . '?d=https%3A%2F%2Fexample.com%2Favatar.png%3Fsize%3D80%26v%3D2',
			Author::gravatar('test@getkirby.com', 'https://example.com/avatar.png?size=80&v=2')
		);
	}
}
