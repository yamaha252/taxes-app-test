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

```
$ docker-compose up -d mysql
$ docker-compose up app-tests
```

**On local environment**

Prepare MySQL database with enabled `mysql_native_password` authentication.
Check default connection params in `tests/TestCase.php` or set your own in environment variables
```
$ export DB_HOST=172.17.0.2
$ export DB_PORT=3306
$ export DB_USER=root
$ export DB_PASSWORD=12345
$ export DB_NAME=taxes-app
```
Install composer packages and run the tests.
```
$ composer install
$ composer test
```

Running tests with specific connection settings
```
(export DB_HOST=172.17.0.2; export DB_USER=root; export DB_PASSWORD=12345; export DB_NAME=taxes-app; composer test)
```
