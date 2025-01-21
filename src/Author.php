<?php

namespace Kirby\Discord;

/**
 * Author information for a Discord webhook request
 *
 * @author Kirby Team <mail@getkirby.com>
 * @license MIT
 * @link https://getkirby.com
 */
class Author
{
	public function __construct(
		public string $name,
		public string|null $url = null,
		public string|null $icon = null
	) {
	}

	public static function gravatar(
		string $email,
		string|null $default = null
	): string {
		$address = strtolower(trim($email));
		$hash    = hash('sha256', $address);

		return 'https://www.gravatar.com/avatar/' . $hash . '?d=' . $default;
	}

	public static function from(self|array|null $author): static|null
	{
		return match (true) {
			$author === null  => null,
			is_array($author) => new static(...$author),
			default           => $author
		};
	}

	public function toArray(): array
	{
		return [
			'icon_url'  => $this->icon,
			'name'      => $this->name,
			'url'       => $this->url,
		];
	}
}
