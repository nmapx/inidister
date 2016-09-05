<?php

use Nmapx\Inidister\Domain\{
    Inidister,
    Registry
};

require __DIR__ . '/../vendor/autoload.php';

$registry = new Registry();
$registry->addDist(__DIR__ . '/example.ini.dist', __DIR__ . '/example.ini');

$inidister = new Inidister();
$inidister->attach($registry)
    ->execute();