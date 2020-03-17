# Test to show country in the api from the amazon file

## First Clone the project

```sh
$ git clone https://github.com/dragondiego7/testGeo.git
```

## Install composer dependencies

```sh
$ composer install
```

## Run the command to create database. In your console run

```sh
$ php artisan make:database testGeo mysql_create
```

## Populate database. In your console run

```sh
$ php artisan app:loadflux
```

## Lets up the application

```sh
$ php artisan serve
```

## Now you can load the application in your browser or make some test in the postman

Access URL: http://localhost:8000/

## Try call the API get all method in your browser

http://localhost:8000/api/countrys/1


## Method to filter by IP

http://localhost:8000/api/locationByIP/43.242.4.0


## Run the unit test

```sh
$ phpunit
```