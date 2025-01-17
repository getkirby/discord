<?php

use Kirby\Discord\Discord;

describe('Discord', function () {
	it('should return an array on dryrun', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			dryrun: true
		);

		expect($response)->toBe([
			'avatar_url' => null,
			'content'    => null,
			'embeds'     => [
				[
					'author'      => null,
					'color'       => null,
					'description' => null,
					'fields'      => [],
					'footer'      => ['text' => null],
					'image'       => ['url' => null],
					'title'       => null
				]
			],
			'username' => null,
		]);
	});
});
