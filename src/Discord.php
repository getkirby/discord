<?php

namespace Kirby\Discord;

use DateTime;
use DateTimeZone;
use Kirby\Http\Remote;
use Kirby\Toolkit\Str;

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
	 * Shortens a text to Discord's character limit for that part;
	 * Discord rejects the whole message if one part is too long
	 * @internal
	 */
	public static function shorten(string|null $text, int $limit): string|null
	{
		if ($text === null || Str::length($text) <= $limit) {
			return $text;
		}

		return Str::substr($text, 0, $limit - 1) . '…';
	}

	/**
	 * Sends a message with an embed to the webhook;
	 * returns the request data instead in dryrun mode
	 *
	 * @param Author|array{name: string, url?: string|null, icon?: string|null}|null $author
	 * @param array<Field|array{name: string, value: mixed, inline?: bool}> $fields
	 * @param $timeout Seconds to wait for Discord; defaults to Kirby's `remote.timeout` option
	 * @throws \Exception when the request fails or times out
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
		int|null $timeout = null,
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

		// Discord rejects fields without a value
		// and more than 25 fields per embed
		$fields = array_map(fn ($field) => Field::from($field), $fields);
		$fields = array_filter($fields, fn ($field) => $field->isEmpty() === false);
		$fields = array_slice(array_values($fields), 0, 25);

		$embed = static::filter([
			'author'      => static::filter(Author::from($author)?->toArray() ?? []),
			'color'       => $color,
			'description' => static::shorten($description, 4096),
			'fields'      => array_map(fn ($field) => $field->toArray(), $fields),
			'footer'      => static::filter(['text' => static::shorten($footer, 2048)]),
			'image'       => static::filter(['url'  => $image]),
			'thumbnail'   => static::filter(['url'  => $thumbnail]),
			'timestamp'   => $timestamp,
			'title'       => static::shorten($title, 256),
		]);

		$data = static::filter([
			'avatar_url' => $avatar,
			'content'    => static::shorten($content, 2000),
			'embeds'     => $embed !== [] ? [$embed] : null,
			'username'   => static::shorten($username, 80),
		]);

		if ($dryrun === true) {
			return $data;
		}

		$options = [
			'data'    => json_encode($data),
			'headers' => ['Content-Type' => 'application/json'],
			'method'  => 'POST',
		];

		// only override the timeout of the `remote` option if requested
		if ($timeout !== null) {
			$options['timeout'] = $timeout;
		}

		return Remote::request($webhook, $options);
	}
}
