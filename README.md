# Test to show country in the api from the amazon file

## First Clone the project

git clone <<URL project>>

## Install composer dependencies

composer install

## Run the command to create and populate database. In your console run

php artisan app:loadflux

## Lets up the application

php artisan serve

## Now you can load the application in your browser or make some test in the postman

Access URL: http://localhost:8000/

## Try call the API get all method in your browser

http://localhost:8000/api/countrys

