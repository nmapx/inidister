<?php

require __DIR__ . '/../vendor/autoload.php';

use Nmapx\Inidister\Inidister;

(new Inidister([
    __DIR__ . '/example.ini.dist'
]))->execute();