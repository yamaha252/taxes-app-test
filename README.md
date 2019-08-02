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
$ docker-compose up -d
```

Web interface is available on http://localhost:8082/

API is available on http://localhost:8081/

Run tests
```bash
$ docker-compose run api composer test
```

