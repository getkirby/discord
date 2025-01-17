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

	it('should have fields', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			fields: [
				[
					'name' => 'Field A',
					'value' => 'Value A'
				],
				[
					'name' => 'Field B',
					'value' => 'Value B',
					'inline' => true
				]
			],
			dryrun: true
		);

		expect($response['embeds'][0]['fields'])->toBe([
			[
				'name' => 'Field A',
				'value' => 'Value A',
				'inline' => false
			],
			[
				'name' => 'Field B',
				'value' => 'Value B',
				'inline' => true
			]
		]);

	});

});
