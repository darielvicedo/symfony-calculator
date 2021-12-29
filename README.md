**Symfony Calculator** is a simple technical test project.

# Features

Performs basic math operations (*addition*, *subtraction*, *division* and *multiplication*) to two integers, either by
API endpoint, browser route and console command.

# Requirements

* PHP 8.0.
* Composer.
* Symfony CLI (optional, but recommended).

# Installation

* Clone this repository.
* Run ```$ composer install``` or ```$ symfony composer install```.
* Serve with ```$ php -S localhost:8000``` or ```$ symfony serve -d```.

# Usage

## Browser

Go to *https://localhost:8000/{op}/{numA}/{numB}*, where:

* **op:** One of *add* | *sub* | *div* | *mul*.
* **numA:** An integer.
* **numB:** An integer.

## API Client

Make a GET request to *https://localhost:8000/{op}/{numA}/{numB}*, where:

* **op:** One of *add* | *sub* | *div* | *mul*.
* **numA:** An integer.
* **numB:** An integer.

## Symfony Console

Run ```$ php bin/console calc:op``` or ```$ symfony console calc:op``` to start the wizard or simply add these parameters:
{numA} {op} {numB}, where op is one of: + | - | / | x.

Example: ```$ symfony console calc:op 25 + 5```

# Testing

Run the tests with PHPUnit: ```$ php bin/phpunit```