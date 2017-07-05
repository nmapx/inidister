<?php declare(strict_types=1);

namespace Nmapx\Inidister\Domain\Parser;

interface Parser
{
    function stringToArray(string $data): array;

    function arrayToString(array $data): string;
}
