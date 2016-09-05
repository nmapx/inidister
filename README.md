[![Latest Stable Version](https://img.shields.io/github/release/nmapx/inidister.svg?style=flat-square)](https://github.com/nmapx/inidister/releases)
[![License](https://img.shields.io/github/license/nmapx/inidister.svg?style=flat-square)](https://github.com/nmapx/inidister/blob/master/LICENSE)

# Inidister

Use .dist.ini schema files to create .ini depending on your environment.

Inidister is a perfect solution to manage your config files.

It works in the same way as Symfony YAML dist mechanism - it will produce a new file (or extend existing one with new data including default values).

PHP support ini files out of the box ([parse_ini_file()](https://secure.php.net/manual/en/function.parse-ini-file.php)).

## Requirements
* PHP >= 7.0.8 with **composer**

## Installation

### using Composer
```bash
composer require nmapx/inidister
```

## Usage
```php
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
```