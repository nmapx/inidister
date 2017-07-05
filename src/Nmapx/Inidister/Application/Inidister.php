<?php

namespace Nmapx\Inidister\Application;

use Nmapx\Inidister\Domain\Inidister as InidisterInterface;
use Nmapx\Inidister\Domain\InidisterException;
use Nmapx\Inidister\Domain\Registry\Registry as RegistryInterface;

class Inidister implements InidisterInterface
{
    /** @var Parser */
    private $parser;

    /** @var Writer */
    private $writer;

    /** @var Registry */
    private $registry;

    public function __construct()
    {
        $this->parser = new Parser();
        $this->writer = new Writer();

        $this->detach();
    }

    public function attach(RegistryInterface $registry): InidisterInterface
    {
        $this->registry = $registry;

        return $this;
    }

    public function detach(): InidisterInterface
    {
        $this->registry = null;

        return $this;
    }

    public function execute(): InidisterInterface
    {
        if (null === $this->registry) {
            throw new InidisterException('Registry is missing, attach it first');
        }

        foreach ($this->registry->getCollection()->getCollection() as $row) {
            $this->writer->writeToFile($row['ini'], $this->parser->arrayToString(
                $this->update(
                    $this->parser->stringToArray($row['dist']),
                    $this->parser->stringToArray($row['ini'])
                )
            ));
        }

        return $this;
    }

    private function update(array $dist, array $ini): array
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
