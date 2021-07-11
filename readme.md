This package provide simple way to access read-only application configuration. 

## Installation

```
composer require mleczek/config
```

## Config file definition

The configuration is stored in flat php files which returns a data. It can be a simple string, number or associative array with nested keys.

The code below is a sample config file:

```php
<?php

// config/services.php
return [
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
    ],
];
```

**Note:** File must have `.php` extension and cannot contain `.` dot in name.

## Usage

In constructor provide path to the directory which contains all configuration files (subdirectories are not supported). 

The `$key` argument in `has`, `get` and `getOrDefault` methods consist of parts separated by `.` dot char. The first part is a config filename (without extension) and subsequence are a next array keys:

```php
use \Mleczek\Config\Providers\LocalConfig;

$config = new LocalConfig(__DIR__ .'/config');

$has = $config->has('services.database'); // true
$host = $config->get('services.database.host'); // 'localhost'
$user = $config->getOrDefault('services.database.user', 'root'); // 'root'
```

## Dependency injection

All config providers extends the `ConfigInterface` to support binding to the DI container.
