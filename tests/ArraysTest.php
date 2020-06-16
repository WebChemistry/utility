<?php declare(strict_types = 1);

namespace WebChemistry\Utility\Testing\Unit;

use Codeception\Test\Unit;
use LogicException;
use WebChemistry\Utility\Arrays;

class ArraysTest extends Unit
{

	public function testSynchronize(): void
	{
		$diff = Arrays::synchronize(
			['foo', 'remove'],
			['foo', 'add']
		);

		$this->assertSame(['add'], array_values($diff->getAdded()));
		$this->assertSame(['remove'], array_values($diff->getRemoved()));
		$this->assertSame(['foo', 'add'], array_values($diff->getResult()));
	}

	public function testDefaults(): void
	{
		$values = Arrays::defaults(
			['key' => 'foo', 'key2' => 'foo'],
			['key' => 'bar']
		);

		$this->assertSame(['key' => 'bar', 'key2' => 'foo'], $values);
	}

	public function testInvalidDefaults(): void
	{
		$this->expectException(LogicException::class);

		Arrays::defaults(
			['key' => 'foo', 'key2' => 'foo'],
			['key' => 'bar', 'key3' => 'key']
		);
	}

}
