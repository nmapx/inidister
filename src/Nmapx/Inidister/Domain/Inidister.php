<?php

namespace Nmapx\Inidister\Domain;

use Nmapx\Inidister\Exception\EmptySetException;

class Inidister
{
    /** @var Parser */
    protected $parser;

    /** @var Writer */
    protected $writer;

    /** @var Registry */
    protected $registry;

    public function __construct()
    {
        $this->parser = new Parser();
        $this->writer = new Writer();
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
            $this->writer->write($ini, $this->parser->create(
                $this->update(
                    $this->parser->parse($dist),
                    $this->parser->parse($ini)
                )
            ));
        }

        return $this;
    }

    public function detach(): self
    {
        $this->registry = null;

        return $this;
    }

    protected function update(array $dist, array $ini): array
    {
        foreach ($ini as $group => $content) {
            if (!array_key_exists($group, $dist)) {
                unset($ini[$group]);
                continue;
            }
            foreach ($content as $key => $value) {
                if (!array_key_exists($key, $dist[$group])) {
                    unset($ini[$group][$key]);
                    continue;
                }
            }
        }

        foreach ($dist as $group => $content) {
            if (!array_key_exists($group, $ini)) {
                $ini[$group] = $content;
                continue;
            }
            foreach ($content as $key => $value) {
                if (!array_key_exists($key, $ini[$group])) {
                    $ini[$group][$key] = $value;
                    continue;
                }
            }
        }

        return $ini;
    }
}