<?php declare(strict_types=1);

namespace Nmapx\Inidister\Application;

use Nmapx\Inidister\Domain\Writer\Writer as WriterInterface;
use Nmapx\Inidister\Infrastructure\Writer\FileAdapter;

class Writer implements WriterInterface
{
    public function writeToFile(string $filepath, string $data): WriterInterface
    {
        $adapter = new FileAdapter($filepath);
        $adapter->persist($data);

        return $this;
    }
}
