<?php declare(strict_types = 1);

namespace WebChemistry\Utility\Entity;

use ArrayIterator;
use Exception;
use IteratorAggregate;
use Traversable;

final class ArraySynchronized implements IteratorAggregate
{

	/** @var mixed[] */
	private array $added;

	/** @var mixed[] */
	private array $removed;

	/** @var mixed[] */
	private array $result;

	/**
	 * @param mixed[] $added
	 * @param mixed[] $removed
	 * @param mixed[] $result
	 */
	public function __construct(array $added, array $removed, array $result)
	{
		$this->added = $added;
		$this->removed = $removed;
		$this->result = $result;
	}

	public function isSame(): bool
	{
		return !$this->removed && !$this->added;
	}

	/**
	 * @return mixed[]
	 */
	public function getAdded(): array
	{
		return $this->added;
	}

	/**
	 * @return mixed[]
	 */
	public function getRemoved(): array
	{
		return $this->removed;
	}

	/**
	 * @return mixed[]
	 */
	public function getResult(): array
	{
		return $this->result;
	}

	public function getIterator()
	{
		return new ArrayIterator($this->result);
	}

}
