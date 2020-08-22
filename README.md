## Prerequisites

Before running the application, you must have these:

- web server with PHP 7.4
- composer

## Install dependencies

Run composer to install app dependencies:

    composer install

## Setup environment

Default database provider is SQLite. Data is stored in `var/data.db` file by default.

Before running the application, run database migrations to create schema:

    php bin/console doctrine:migrations:migrate

## Run web application

Starting root directory is `/public`. Point your webserver here.

You might need to adjust `.htaccess` file based on your webserver configuration.

## Development

### Static code analysis

To check for PHP errors and alike run this:

    vendor\bin\phpstan analyse src --level 5

### Run tests

    php bin\phpunit tests
