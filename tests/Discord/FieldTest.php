<?php

use Kirby\Discord\Field;

describe('Field', function () {
	it('from array', function () {
		$field = Field::from([
			'name' => 'Name',
			'value' => 'Value',
		]);

		expect($field->toArray())->toBe([
			'name'   => 'Name',
			'value'  => 'Value',
			'inline' => false,
		]);
	});

	it('from object', function () {
		$field = Field::from(new Field(name: 'Name', value: 'Value'));

		expect($field->toArray())->toBe([
			'name'   => 'Name',
			'value'  => 'Value',
			'inline' => false,
		]);
	});
});
