<?php declare(strict_types = 1);

namespace WebChemistry\Utility\Doctrine\Association;

use Doctrine\Common\Collections\Collection;
use WebChemistry\Utility\Arrays;
use WebChemistry\Utility\Entity\ArraySynchronized;

final class ArrayCollectionSynchronizer
{

	public const REMOVE = 0b0001;
	public const ADD = 0b0010;

	public static function synchronize(
		Collection $collection,
		array $values,
		int $options = self::ADD | self::REMOVE
	): ArraySynchronized
	{
		return self::synchronizeByComparator($collection, $values, null, $options);
	}

	public static function synchronizeByComparator(
		Collection $collection,
		array $values,
		?callable $comparator = null,
		int $options = self::ADD | self::REMOVE
	): ArraySynchronized
	{
		$synchronized = Arrays::synchronize($comparator, $collection->toArray(), $values);

		if ($options & self::REMOVE) {
			foreach ($synchronized->getRemoved() as $key => $_) {
				$collection->remove($key);
			}
		}

		if ($options & self::ADD) {
			foreach ($synchronized->getAdded() as $element) {
				$collection->add($element);
			}
		}

		return $synchronized;
	}

}
