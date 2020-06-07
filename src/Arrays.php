<?php declare(strict_types = 1);

namespace WebChemistry\Utility;

use Traversable;
use WebChemistry\Utility\Entity\ArraySynchronized;

final class Arrays
{

	/**
	 * @param mixed[] $previous
	 * @param mixed[] $current
	 */
	public static function synchronize(iterable $previous, iterable $current, ?callable $comparator = null): ArraySynchronized
	{
		$comparator ??= [self::class, 'strictComparator'];

		$added = self::iterableToArray($current);
		$removed = self::iterableToArray($previous);
		$result = $added;
		foreach ($removed as $key => $value) {
			foreach ($added as $key1 => $value1) {
				if ($comparator($value, $value1)) {
					unset($removed[$key]);
					unset($added[$key1]);
				}
			}
		}
		
		return new ArraySynchronized($added, $removed, $result);
	}

	/**
	 * @param mixed $first
	 * @param mixed $second
	 */
	private static function strictComparator($first, $second): bool
	{
		return $first === $second;
	}

	private static function iterableToArray(iterable $iterable): array
	{
		return $iterable instanceof Traversable ? iterator_to_array($iterable) : (array) $iterable;
	}

}
