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
});
