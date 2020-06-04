<?php declare(strict_types = 1);

namespace WebChemistry\Utility\Doctrine\Association;

use Doctrine\Common\Collections\Collection;

final class ArrayCollectionSynchronizer
{

	public static function synchronize(Collection $collection, array $values): void
	{
		$collectionArray = $collection->toArray();

		// adding
		foreach ($values as $value) {
			$key = array_search($value, $collectionArray, true);

			if ($key === false) {
				$collection->add($value);
			} else {
				unset($collectionArray[$key]);
			}
		}

		// removing
		foreach ($collectionArray as $key => $_) {
			$collection->remove($key);
		}
	}
	
}
