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
					'thumbnail'   => ['url' => null],
					'timestamp'   => null,
					'title'       => null,
				]
			],
			'username' => null,
		]);
	});

	it('should have content', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			content: $content = 'This is some test content',
			dryrun: true
		);

		expect($response['content'])->toBe($content);
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

	it('should have a thumbnail', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			thumbnail: $thumb = 'https://example.com/thumb.jpg',
			dryrun: true
		);

		expect($response['embeds'][0]['thumbnail']['url'])->toBe($thumb);
	});

	describe('should have a timestamp', function () {

		it('from string', function () {
			$response = Discord::submit(
				webhook: 'https://discord.com/api/webhooks/xxx/xxx',
				timestamp: $ts = '2025-01-17T09:55:24.000Z',
				dryrun: true
			);

			expect($response['embeds'][0]['timestamp'])->toBe($ts);
		});

		it('from DateTime object', function () {
			$response = Discord::submit(
				webhook: 'https://discord.com/api/webhooks/xxx/xxx',
				timestamp: new DateTime('2025-01-01'),
				dryrun: true
			);

			expect($response['embeds'][0]['timestamp'])->toBe('2025-01-01T00:00:00.000Z');
		});

	});

});
