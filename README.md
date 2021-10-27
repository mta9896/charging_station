## About Project

This application is an implementation of a vehicle charging station.
Each company can own one or more companies, and each of them can own one or more stations.

## Implementation

In order to implement the tree structure, library "kalnoy/nestedset" is used. Also I used a mysql geo query to find out about distances between coordinates.

## APIs 

Includes CRUD endpoints for station and company models, plus an endpoint to get all the stations that belong to a company and its descendants, and an API that returns all the stations within a radius around an arbitrary coordinate.

## Installation

First, clone the repository:

```
git clone git@github.com:mta9896/charging_station.git

cd charging_station
```

### Setting up the docker environment

This project is set up to work with docker. To execute docker-compose commands, first change the directory to the one containing docker-compose.yml file:

```
cd docker
```
To build and start the project, run:

```
docker-compose up -d --build
```

The project is up. Then create the .env file:

```
cp .env.example .env
```
 
 ### Running artisan command and dependency installation
 
To execute artisan commands, log into the php shell:

```
docker-compose exec php bash
```

And then feel free to run:

```
composer install
```
to install all dependencies.

### Database

Database connection configuration is specified in .env file, in order to work with the mysql container that is created. Change them if necessary. To migrate the database schema, run:

```
php artisan migrate
```

If you'd like to have some dummy data in the database, run:

```
php artisan db:seed
```

### Serving the project

Now serve the project on your local machine:

```
php artisan serve
```
If you are using docker, run:

```
php artisan serve --host=0.0.0.0
```

This makes the APIs accessible through HTTP requests to the local domain, on the port 8000 of your local machine:

```
http://localhost:8000
```

To change this port, edit the local port value in the docker-compose.yml file:

```
  php:
    build:
      context: ./php
    volumes:
      - ../:/app
    working_dir: /app
    ports:
      - {PORT_NUMBER}:8000
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
