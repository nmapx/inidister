<?php

use Nmapx\Inidister\Application\{
    Inidister,
    Registry
};

require __DIR__ . '/../vendor/autoload.php';

$registry = new Registry();
$registry->add(__DIR__ . '/example.dist.ini', __DIR__ . '/example.ini');

$inidister = new Inidister();
$inidister->attach($registry)
    ->execute();
