<?php

namespace Nmapx\Inidister\Domain;

use Nmapx\Inidister\Exception\AlreadyExistsException;

class Registry
{
    /** @var array */
    protected $list;

    public function __construct()
    {
        $this->reset();
    }

    /** alias */
    public function add(string $dist, string $ini): self
    {
        return $this->addDist($dist, $ini);
    }

    public function addDist(string $dist, string $ini): self
    {
        if (array_key_exists($dist, $this->list)) {
            throw new AlreadyExistsException('Dist already on list');
        }
        $this->list[$dist] = $ini;

        return $this;
    }

    public function addDists(array $files): self
    {
        foreach ($files as $dist => $ini) {
            $this->addDist($dist, $ini);
        }

        return $this;
    }

    public function reset(): self
    {
        $this->list = [];

        return $this;
    }

    public function getList(): array
    {
        return $this->list;
    }
}