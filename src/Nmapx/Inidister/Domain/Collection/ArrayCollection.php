<?php declare(strict_types=1);

namespace Nmapx\Inidister\Domain\Collection;

abstract class ArrayCollection
{
    /** @var array */
    private $collection;

    public function __construct()
    {
        $this->collection = [];
    }

    public function getCollection(): array
    {
        return $this->collection;
    }

    public function addElement($element): void
    {
        $this->collection[] = $element;
    }

    public function removeKey(int $key): void
    {
        unset($this->collection[$key]);
    }
}
