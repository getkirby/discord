<?php

namespace Kirby\Discord;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Field::class)]
class FieldTest extends TestCase
{
	public function testFromArray(): void
	{
		$field = Field::from([
			'name'  => 'Name',
			'value' => 'Value',
		]);

		$this->assertSame([
			'name'   => 'Name',
			'value'  => 'Value',
			'inline' => false,
		], $field->toArray());
	}

	public function testFromObject(): void
	{
		$field = Field::from(new Field(name: 'Name', value: 'Value'));

		$this->assertSame([
			'name'   => 'Name',
			'value'  => 'Value',
			'inline' => false,
		], $field->toArray());
	}
}
