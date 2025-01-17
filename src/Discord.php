<?php

namespace Kirby\Discord;

use Kirby\Http\Remote;

/**
 * Sends a webhook to a Discord channel
 *
 * @author Kirby Team <mail@getkirby.com>
 * @license MIT
 * @link https://getkirby.com
 */
class Discord
{
	public static function submit(
		string $webhook,
		int|string|null $color = null,
		Author|array|null $author = null,
		string|null $title = null,
		string|null $description = null,
		string|null $image = null,
		array $fields = [],
		string|null $footer = null,
		string|null $username = null,
		string|null $avatar = null,
		bool $dryrun = false,
	): Remote|array {
		if (is_string($color) === true) {
			$color = hexdec(str_replace('#', '', $color));
		}

		$embed = [
			'author'      => Author::from($author)?->toArray(),
			'color'       => $color,
			'description' => $description,
			'fields'      => array_map(fn ($field) => Field::from($field), $fields),
			'footer'      => ['text' => $footer],
			'image'       => ['url'  => $image],
			'title'       => $title,
		];

		$data = [
			'avatar_url' => $avatar,
			'content'    => null,
			'embeds'     => [$embed],
			'username'   => $username,
		];

		if ($dryrun === true) {
			return $data;
		}

		return Remote::post(
			$webhook,
			[
				'data'    => json_encode($data),
				'headers' => ['Content-Type' => 'application/json'],
			]
		);
	}
}
