<?php declare(strict_types=1);

namespace Nmapx\Inidister\Application;

use Nmapx\Inidister\Domain\Registry\Collection;
use Nmapx\Inidister\Domain\Registry\Registry as RegistryInterface;
use Nmapx\Inidister\Domain\Registry\RegistryException;

class Registry implements RegistryInterface
{
    /** @var Collection */
    private $collection;

    public function __construct()
    {
        $this->reset();
    }

    public function add(string $dist, string $ini): RegistryInterface
    {
        $this->addIfUnique($dist, $ini);

        return $this;
    }

    public function addMultiple(array $filepaths): RegistryInterface
    {
        foreach ($filepaths as $dist => $ini) {
            $this->addIfUnique($dist, $ini);
        }

        return $this;
    }

    public function reset(): RegistryInterface
    {
        $this->collection = new Collection();

        return $this;
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    private function addIfUnique(string $dist, string $ini): void
    {
        if (array_key_exists($dist, array_count_values($this->collection->getCollection()))) {
            throw new RegistryException('Filepath ' . $dist . ' is already registered');
        }

        $this->collection->addElement(['dist' => $dist, 'ini' => $ini]);
    }
}
