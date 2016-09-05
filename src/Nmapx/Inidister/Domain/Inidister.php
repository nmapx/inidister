<?php

namespace Nmapx\Inidister\Domain;

use Nmapx\Inidister\Exception\EmptySetException;

class Inidister
{
    /** @var Registry */
    protected $registry;

    public function __construct()
    {
        $this->detach();
    }

    public function attach(Registry $registry): self
    {
        $this->registry = $registry;

        return $this;
    }

    public function execute(): self
    {
        if (null === $this->registry) {
            throw new EmptySetException('Registry not found');
        }

        foreach ($this->registry->getList() as $dist => $ini) {

        }

        return $this;
    }

    public function detach(): self
    {
        $this->registry = null;

        return $this;
    }
}