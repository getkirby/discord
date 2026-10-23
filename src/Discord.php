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
	 * Removes the parts without content from the request data
	 */
	protected static function filter(array $data): array
	{
		return array_filter(
			$data,
			fn ($value) => match (true) {
				is_string($value) => trim($value) !== '',
				is_array($value)  => $value !== [],
				default           => $value !== null
			}
		);
	}

	/**
	 * Sends a message with an embed to the webhook;
	 * returns the request data instead in dryrun mode
	 *
	 * @param Author|array{name: string, url?: string|null, icon?: string|null}|null $author
	 * @param array<Field|array{name: string, value: mixed, inline?: bool}> $fields
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

		$embed = static::filter([
			'author'      => static::filter(Author::from($author)?->toArray() ?? []),
			'color'       => $color,
			'description' => $description,
			'fields'      => array_map(fn ($field) => Field::from($field)->toArray(), $fields),
			'footer'      => static::filter(['text' => $footer]),
			'image'       => static::filter(['url'  => $image]),
			'thumbnail'   => static::filter(['url'  => $thumbnail]),
			'timestamp'   => $timestamp,
			'title'       => $title,
		]);

		$data = static::filter([
			'avatar_url' => $avatar,
			'content'    => $content,
			'embeds'     => $embed !== [] ? [$embed] : null,
			'username'   => $username,
		]);

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
