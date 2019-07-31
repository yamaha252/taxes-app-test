## Taxes calculation service

Develop a software that can be used to calculate statistics about the tax income of a country. The country is organized in 5 states and theses states are divided into counties.

Each county has a different tax rate and collects a different amount of taxes.

The software should have the following features:

- Output the overall amount of taxes collected per state
- Output the average amount of taxes collected per state
- Output the average county tax rate per state
- Output the average tax rate of the country 
- Output the collected overall taxes of the country

### Installation


**Run using Docker**

Launch service
```bash
$ docker-compose up -d mysql
$ docker-compose up app
```

Run tests
```bash
$ docker-compose run app composer test
```

**On local environment**

Prepare MySQL database with enabled `mysql_native_password` authentication.
Check default connection params in `config.php` or set your own creating `config-local.php` file
```php
<?php

return [
    'connection' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'dbname' => 'taxes-app',
    ]
];
```
Install composer packages and run the tests.
```bash
$ composer install
$ composer test
```

