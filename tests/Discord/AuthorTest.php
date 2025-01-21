<?php

use Kirby\Discord\Author;

describe('Author', function () {
	it('from array', function () {
		$author = Author::from([
			'name' => 'Test Author'
		]);

		expect($author->toArray())->toBe([
			'icon_url' => null,
			'name'     => 'Test Author',
			'url'      => null,
		]);
	});

	it('from null', function () {
		$author = Author::from(null);

		expect($author)->toBe(null);
	});

	it('from object', function () {
		$author = Author::from(new Author(name: 'Test Author'));

		expect($author->toArray())->toBe([
			'icon_url' => null,
			'name'     => 'Test Author',
			'url'      => null,
		]);
	});

	it('gravatar', function () {
		$gravatar = Author::gravatar('test@getkirby.com');

		expect($gravatar)->toBe('https://www.gravatar.com/avatar/bbe034b4f830b3b6643c24be59461f03a4077e7f77bf53a1ba674dc0a5ace7e4?d=');
	});
});
