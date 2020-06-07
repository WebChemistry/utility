<?php declare(strict_types = 1);

namespace WebChemistry\Utility\Testing\Unit;

use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use WebChemistry\Utility\Doctrine\Association\ArrayCollectionSynchronizer;

class DoctrineArrayCollectionTest extends Unit
{

	public function testArrayCollection(): void
	{
		$arrayCollection = new ArrayCollection(['foo', 'remove']);

		ArrayCollectionSynchronizer::synchronize($arrayCollection, ['foo', 'add']);

		$this->assertSame(['foo', 'add'], array_values($arrayCollection->toArray()));
	}

	public function testArrayCollectionOnlyRemove(): void
	{
		$arrayCollection = new ArrayCollection(['foo', 'remove']);

		ArrayCollectionSynchronizer::synchronize($arrayCollection, ['foo', 'add'], ArrayCollectionSynchronizer::REMOVE);

		$this->assertSame(['foo'], array_values($arrayCollection->toArray()));
	}

	public function testArrayCollectionOnlyAdd(): void
	{
		$arrayCollection = new ArrayCollection(['foo', 'remove']);

		ArrayCollectionSynchronizer::synchronize($arrayCollection, ['foo', 'add'], ArrayCollectionSynchronizer::ADD);

		$this->assertSame(['foo', 'remove', 'add'], array_values($arrayCollection->toArray()));
	}

}
