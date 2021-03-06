[![Packagist](https://img.shields.io/packagist/dt/nmapx/inidister.svg?maxAge=2592000&style=flat-square)](https://packagist.org/packages/nmapx/inidister)
[![Latest Stable Version](https://img.shields.io/github/release/nmapx/inidister.svg?style=flat-square)](https://github.com/nmapx/inidister/releases)
[![License](https://img.shields.io/github/license/nmapx/inidister.svg?style=flat-square)](https://github.com/nmapx/inidister/blob/master/LICENSE)

# Inidister

Use .dist.ini schema files to create .ini depending on your environment.

Inidister is a perfect solution to manage your config files.

It works in the same way as Symfony YAML dist functionality - it will produce a new file (or extend existing one with new data using default values which you can change manually and it won't be replaced again).

PHP support ini files out of the box ([parse_ini_file()](https://secure.php.net/manual/en/function.parse-ini-file.php)).

## Requirements
* PHP >= 7.1 with **composer**

## Installation

### using Composer
```bash
composer require nmapx/inidister
```

## Usage
It's simple - create a registry, then add some files to it.

Attach the registry to Inidister object and execute it. You file(s) should be in place now.
```php
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
```

## Demo
Example dist file:
```ini
[example1/nested1]
;add some comments
key1        = value1
[example1/nested2]
key1        = value1
key2        = value2
;comment here
key3        = value3
[example2]
key1        = value1
key2        = value2
;and here
[example3]
key1        = value1
```
Result based on dist:
```ini
[example1/nested1]
key1=value1

[example1/nested2]
key1=value1
key2=value2
key3=value3

[example2]
key1=value1
key2=value2

[example3]
key1=value1
```
Now you can add some keys with default values to the dist, then regenerate the output file.

Your data won't disappear (or reset to default) from the output file as long as the key exist in the schema (dist).

## License
MIT License. Check [LICENSE](https://github.com/nmapx/inidister/blob/master/LICENSE) for details.
