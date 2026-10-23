<?php

namespace Kirby\Discord;

/**
 * Field information for a Discord webhook request
 *
 * @copyright Kirby Team <mail@getkirby.com>
 * @license   https://opensource.org/licenses/MIT
 */
class Field
{
	public function __construct(
		public string $name,
		public mixed $value,
		public bool $inline = false
	) {
	}

	/**
	 * Creates a field from an array of constructor arguments
	 * or passes through an existing field object
	 *
	 * @param self|array{name: string, value: mixed, inline?: bool} $field
	 */
	public static function from(self|array $field): static
	{
		return match (true) {
			is_array($field) => new static(...$field),
			default          => $field
		};
	}

	/**
	 * Converts the field to the format of the Discord API
	 */
	public function toArray(): array
	{
		return [
			'name'   => $this->name,
			'value'  => $this->value,
			'inline' => $this->inline
		];
	}
}
