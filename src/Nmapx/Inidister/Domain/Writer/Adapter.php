<?php declare(strict_types=1);

namespace Nmapx\Inidister\Domain\Writer;

interface Adapter
{
    function __construct(string $filepath);

    function persist(string $data): void;
}
