<?php declare(strict_types=1);

namespace Nmapx\Inidister\Infrastructure\Writer;

use Nmapx\Inidister\Domain\Writer\Adapter;
use Nmapx\Inidister\Domain\Writer\WriterException;

class FileAdapter implements Adapter
{
    /** @var string */
    private $filepath;

    public function __construct(string $filepath)
    {
        $this->filepath = $filepath;
    }

    public function persist(string $data): void
    {
        if (false === file_put_contents($this->filepath, $data)) {
            throw new WriterException('Unable to write location: ' . $this->filepath);
        }
    }
}
