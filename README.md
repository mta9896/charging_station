## About Project

This application is an implementation of a vehicle charging station.
Each company can own one or more companies, and each of them can own one or more stations.

## Implementation

In order to implement the tree structure, library "kalnoy/nestedset" is used. Also I used a mysql geo query to find out about distances between coordinates.

## APIs 

Includes CRUD endpoints for station and company models, plus an endpoint to get all the stations that belong to a company and its descendants, and an API that returns all the stations within a radius around an arbitrary coordinate.

## Installation

This project is set up to work with docker. In order to start it, run:

```
docker-compose up -d --build
```

The project is up. To execute artisan commands, log into the php shell:

```
docker-compose exec php bash
```

And then feel free to run:

```
composer install
```
to install all dependencies.

To migrate the database schema, run:

```
php artisan migrate
```

If you'd like to have some dummy data in the database, run:

```
php artisan db:seed
```

Now serve the project on your local machine:

```
php artisan serve
```
If you are using docker:

```
php artisan serve --host=0.0.0.0
```

## Tests

The test suite consists of feature (API) tests and tests for small units that communicate with the database, too, so they are technically integration tests.

```
vendor/bin/phpunit tests/Feature
vendor/bin/phpunit tests/Integration
```

## Documentation

This project uses a swagger documentation. Try browsing to ```/api/documentation``` to view it.

## Contributing

Just fork this repo and keep going :)
