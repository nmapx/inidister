<?php declare(strict_types=1);

namespace Nmapx\Inidister\Domain\Registry;

interface Registry
{
    function __construct();

    function add(string $dist, string $ini): Registry;

    function addMultiple(array $filepaths): Registry;

    function reset(): Registry;

    function getCollection(): Collection;
}
