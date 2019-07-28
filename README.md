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

**On local environment**

Prepare MySQL database with enabled `mysql_native_password` authentication.
Set up the connection params in `phpunit.xml`
Install composer packages and run tests.
```
$ composer install
$ composer test
```
