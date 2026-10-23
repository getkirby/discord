<?php

namespace Kirby\Discord;

use DateTime;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Discord::class)]
class DiscordTest extends TestCase
{
	protected const string WEBHOOK = 'https://discord.com/api/webhooks/xxx/xxx';

	public function testSubmitDryrun(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			dryrun: true
		);

		$this->assertSame([
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
		], $response);
	}

	public function testSubmitWithAuthorArray(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			author: $author = [
				'icon' => 'https://getkirby.com/icon.png',
				'name' => 'Test author',
				'url'  => 'https://getkirby.com'
			],
			dryrun: true
		);

		$this->assertSame([
			'icon_url' => $author['icon'],
			'name'     => $author['name'],
			'url'      => $author['url']
		], $response['embeds'][0]['author']);
	}

	public function testSubmitWithAuthorObject(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			author: $author = new Author(
				icon: 'https://getkirby.com/icon.png',
				name: 'Test author',
				url: 'https://getkirby.com'
			),
			dryrun: true
		);

		$this->assertSame([
			'icon_url' => $author->icon,
			'name'     => $author->name,
			'url'      => $author->url
		], $response['embeds'][0]['author']);
	}

	public function testSubmitWithAvatar(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			avatar: $avatar = 'https://example.com/avatar.jpg',
			dryrun: true
		);

		$this->assertSame($avatar, $response['avatar_url']);
	}

	public function testSubmitWithColor(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			color: '#ebc747',
			dryrun: true
		);

		$this->assertSame(0xebc747, $response['embeds'][0]['color']);
	}

	public function testSubmitWithContent(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			content: $content = 'This is some test content',
			dryrun: true
		);

		$this->assertSame($content, $response['content']);
	}

	public function testSubmitWithDescription(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			description: $description = 'Test Description',
			dryrun: true
		);

		$this->assertSame($description, $response['embeds'][0]['description']);
	}

	public function testSubmitWithFields(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			fields: [
				[
					'name'  => 'Field A',
					'value' => 'Value A'
				],
				[
					'name'   => 'Field B',
					'value'  => 'Value B',
					'inline' => true
				]
			],
			dryrun: true
		);

		$this->assertSame([
			[
				'name'   => 'Field A',
				'value'  => 'Value A',
				'inline' => false
			],
			[
				'name'   => 'Field B',
				'value'  => 'Value B',
				'inline' => true
			]
		], $response['embeds'][0]['fields']);
	}

	public function testSubmitWithFooter(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			footer: $footer = 'Test footer',
			dryrun: true
		);

		$this->assertSame($footer, $response['embeds'][0]['footer']['text']);
	}

	public function testSubmitWithImage(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			image: $image = 'https://example.com/image.jpg',
			dryrun: true
		);

		$this->assertSame($image, $response['embeds'][0]['image']['url']);
	}

	public function testSubmitWithThumbnail(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			thumbnail: $thumb = 'https://example.com/thumb.jpg',
			dryrun: true
		);

		$this->assertSame($thumb, $response['embeds'][0]['thumbnail']['url']);
	}

	public function testSubmitWithTimestampObject(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			timestamp: new DateTime('2025-01-01'),
			dryrun: true
		);

		$this->assertSame('2025-01-01T00:00:00.000Z', $response['embeds'][0]['timestamp']);
	}

	public function testSubmitWithTimestampString(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			timestamp: $ts = '2025-01-17T09:55:24.000Z',
			dryrun: true
		);

		$this->assertSame($ts, $response['embeds'][0]['timestamp']);
	}

	public function testSubmitWithTitle(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			title: $title = 'Test',
			dryrun: true
		);

		$this->assertSame($title, $response['embeds'][0]['title']);
	}

	public function testSubmitWithUsername(): void
	{
		$response = Discord::submit(
			webhook: static::WEBHOOK,
			username: $username = 'test user',
			dryrun: true
		);

		$this->assertSame($username, $response['username']);
	}
}
