<?php declare(strict_types=1);

namespace Nmapx\Inidister\Domain;

use Nmapx\Inidister\Domain\Registry\Registry;

interface Inidister
{
    function attach(Registry $registry): Inidister;

    function detach(): Inidister;

    function execute(): Inidister;
}
