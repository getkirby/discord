<?php

use Kirby\Discord\Author;
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

	describe('should have an author', function () {
		it('should be creatable from array', function () {
			$response = Discord::submit(
				webhook: 'https://discord.com/api/webhooks/xxx/xxx',
				author: $author = [
					'icon' => 'https://getkirby.com/icon.png',
					'name' => 'Test author',
					'url'  => 'https://getkirby.com'
				],
				dryrun: true
			);

			expect($response['embeds'][0]['author'])->toBe([
				'icon_url' => $author['icon'],
				'name'     => $author['name'],
				'url'      => $author['url']
			]);
		});

		it('should be creatable from object', function () {
			$response = Discord::submit(
				webhook: 'https://discord.com/api/webhooks/xxx/xxx',
				author: $author = new Author(
					icon: 'https://getkirby.com/icon.png',
					name: 'Test author',
					url: 'https://getkirby.com'
				),
				dryrun: true
			);

			expect($response['embeds'][0]['author'])->toBe([
				'icon_url' => $author->icon,
				'name'     => $author->name,
				'url'      => $author->url
			]);
		});
	});

	it('should have an avatar', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			avatar: $avatar = 'https://example.com/avatar.jpg',
			dryrun: true
		);

		expect($response['avatar_url'])->toBe($avatar);
	});

	it('should have content', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			content: $content = 'This is some test content',
			dryrun: true
		);

		expect($response['content'])->toBe($content);
	});

	it('should have a description', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			description: $description = 'Test Description',
			dryrun: true
		);

		expect($response['embeds'][0]['description'])->toBe($description);
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

	it('should have a footer', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			footer: $footer = 'Test footer',
			dryrun: true
		);

		expect($response['embeds'][0]['footer']['text'])->toBe($footer);
	});

	it('should have an image', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			image: $image = 'https://example.com/image.jpg',
			dryrun: true
		);

		expect($response['embeds'][0]['image']['url'])->toBe($image);
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
		it('should be creatable from string', function () {
			$response = Discord::submit(
				webhook: 'https://discord.com/api/webhooks/xxx/xxx',
				timestamp: $ts = '2025-01-17T09:55:24.000Z',
				dryrun: true
			);

			expect($response['embeds'][0]['timestamp'])->toBe($ts);
		});

		it('should be creatable from DateTime object', function () {
			$response = Discord::submit(
				webhook: 'https://discord.com/api/webhooks/xxx/xxx',
				timestamp: new DateTime('2025-01-01'),
				dryrun: true
			);

			expect($response['embeds'][0]['timestamp'])->toBe('2025-01-01T00:00:00.000Z');
		});
	});

	it('should have a title', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			title: $title = 'Test',
			dryrun: true
		);

		expect($response['embeds'][0]['title'])->toBe($title);
	});

	it('should have a username', function () {
		$response = Discord::submit(
			webhook: 'https://discord.com/api/webhooks/xxx/xxx',
			username: $username = 'test user',
			dryrun: true
		);

		expect($response['username'])->toBe($username);
	});
});
