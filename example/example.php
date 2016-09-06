<?php

use Nmapx\Inidister\Domain\{
    Inidister,
    Registry
};

require __DIR__ . '/../vendor/autoload.php';

$registry = new Registry();
$inidister = new Inidister();

$registry->add(__DIR__ . '/example.dist.ini', __DIR__ . '/example.ini');
$inidister->attach($registry)
    ->execute();