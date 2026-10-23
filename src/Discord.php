<?php

namespace Kirby\Discord;

use DateTime;
use DateTimeZone;
use Kirby\Http\Remote;

/**
 * Sends a webhook to a Discord channel
 *
 * @copyright Kirby Team <mail@getkirby.com>
 * @license   https://opensource.org/licenses/MIT
 */
class Discord
{
	/**
	 * Sends a message with an embed to the webhook;
	 * returns the request data instead in dryrun mode
	 */
	public static function submit(
		string $webhook,
		Author|array|null $author = null,
		string|null $avatar = null,
		int|string|null $color = null,
		string|null $content = null,
		string|null $description = null,
		bool $dryrun = false,
		array $fields = [],
		string|null $footer = null,
		string|null $image = null,
		string|null $thumbnail = null,
		DateTime|string|null $timestamp = null,
		string|null $title = null,
		string|null $username = null,
	): Remote|array {
		if (is_string($color) === true) {
			$color = hexdec(str_replace('#', '', $color));
		}

		// Discord expects the timestamp in UTC;
		// convert a copy to keep the passed object intact
		if ($timestamp instanceof DateTime) {
			$timestamp = (clone $timestamp)
				->setTimezone(new DateTimeZone('UTC'))
				->format('Y-m-d\TH:i:s.v\Z');
		}

		$embed = [
			'author'      => Author::from($author)?->toArray(),
			'color'       => $color,
			'description' => $description,
			'fields'      => array_map(fn ($field) => Field::from($field)->toArray(), $fields),
			'footer'      => ['text' => $footer],
			'image'       => ['url'  => $image],
			'thumbnail'   => ['url'  => $thumbnail],
			'timestamp'   => $timestamp,
			'title'       => $title,
		];

		$data = [
			'avatar_url' => $avatar,
			'content'    => $content,
			'embeds'     => [$embed],
			'username'   => $username,
		];

		if ($dryrun === true) {
			return $data;
		}

		return Remote::request(
			$webhook,
			[
				'data'    => json_encode($data),
				'headers' => ['Content-Type' => 'application/json'],
				'method'  => 'POST',
			]
		);
	}
}
