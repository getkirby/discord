<?php

namespace Kirby\Discord;

/**
 * Author information for a Discord webhook request
 *
 * @copyright Kirby Team <mail@getkirby.com>
 * @license   https://opensource.org/licenses/MIT
 */
class Author
{
	public function __construct(
		public string $name,
		public string|null $url = null,
		public string|null $icon = null
	) {
	}

	/**
	 * Creates an author from an array of constructor arguments
	 * or passes through an existing author object
	 *
	 * @param self|array{name: string, url?: string|null, icon?: string|null}|null $author
	 */
	public static function from(self|array|null $author): static|null
	{
		return match (true) {
			$author === null  => null,
			is_array($author) => new static(...$author),
			default           => $author
		};
	}

	/**
	 * Returns the Gravatar URL for an email address,
	 * e.g. to use it as author icon
	 */
	public static function gravatar(
		string $email,
		string|null $default = null
	): string {
		$address = strtolower(trim($email));
		$hash    = hash('sha256', $address);

		return 'https://www.gravatar.com/avatar/' . $hash . '?d=' . rawurlencode($default ?? '');
	}

	/**
	 * Converts the author to the format of the Discord API
	 */
	public function toArray(): array
	{
		return [
			'icon_url'  => $this->icon,
			'name'      => Discord::shorten($this->name, 256),
			'url'       => $this->url,
		];
	}
}
