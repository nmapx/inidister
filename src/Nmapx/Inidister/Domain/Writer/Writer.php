<?php declare(strict_types=1);

namespace Nmapx\Inidister\Domain\Writer;

interface Writer
{
    function writeToFile(string $filepath, string $data): Writer;
}
