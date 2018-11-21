## How to Build and Run

### Download the sorcecode from the git / clone from the git repository

```sh
$ wget https://github.com/sshamsudheen/laravel-api/archive/master.zip.
```

### Extraxt the zip file

```sh
$ unzip master.zip
```


### Configure the .env file

```sh
$ cd laravel-api-master/
$ cp .env_example .env
$ vim .env and modify your database details in .env
```
Create the database and modify the below information in .env

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=***
DB_USERNAME=***
DB_PASSWORD=***
```


### Run composer

```sh
$ composer install
$ php artisan migrate;
$ php artisan key:generate
$ start the fpm server  by running
$ ~/laravel-api-master
$ sudo php artisan serve
```

The above command will return
Laravel development server started: <http://127.0.0.1:8000>

### Data import

The API should provide a PUT or POST endpoint to add new products from a JSON encoded list.

```sh
$ curl -X POST http://localhost:8000/api/products   -H "Accept: application/json"   -H "Content-Type: application/json"   -T 'products.json';
```

 A sample list of products is available in the `products.json` file.

### Products
The API should have an endpoint returning a list of all products.

```sh
$ http://localhost:8000/api/products (or)
$ curl -X GET http://localhost:8000/api/products   -H "Accept: application/json"   -H "Content-Type: application/json"
```

The API should provide an endpoint returning detailed product information given a certain product ID.

```sh
$ curl -X GET http://localhost:8000/api/products/3   -H "Accept: application/json"   -H "Content-Type: application/json"  
(or)
In browser type http://localhost:8000/api/products/3
```

{"id":3,"collection_id":2,"image":"dw-petite-28-melrose-white-cat.png","name":"Classic Petite Melrose 28mm (White)","sku":"C99900219","created_at":"2018-10-18 11:53:34","updated_at":"2018-10-18 11:53:34","collection":{"id":2,"collection":"classic-petite","size":28,"created_at":"2018-10-18 11:53:34","updated_at":"2018-10-18 11:53:34"}}

It should be possible to retrieve a list of IDs of all the products of the same size

```sh
$ curl -X GET http://localhost:8000/api/products/size/38   -H "Accept: application/json"   -H "Content-Type: application/json"
(or)
In browser http://localhost:8000/api/products/size/28
```

### Collections
The API should have an endpoint returning a list of all collections
```sh
In Browser type http://localhost:8000/api/collections (or execute)
$ curl -X GET http://localhost:8000/api/collections   -H "Accept: application/json"   -H "Content-Type: application/json"  
```

It should be possible to retrieve a list of IDs of all the products in the same collection

```sh
In Browser type  http://localhost:8000/api/collections/3 (or execute)
$ curl -X GET http://localhost:8000/api/collections/3   -H "Accept: application/json"   -H "Content-Type: application/json"
```

## Technology/Tools used

- php 7.1.16 + Laravel 5.7
- mysql
- tested in MacOs/Ubuntu16.04

## Test cases (Browser + Unit tests)

- Unit test cases for Auth functionalities is created ,

```sh
$ cd <to your project directory>
$ vendor/bin/phpunit
```

- Browser test cases for Auth functionalities is created at this moment it supports only chrome browser (since dusk by default use chrome, if you want to enable different borwsers for testing then integrate Selenium),

```sh
$ cd <to your project directory>
$ php artisan dusk
```

## Integrated deployment using capistrano

Make sure capistrano installed in your machine

To capify your laravel application run the command

```sh
$ cap install
```
in your laravel project root directory if not installed before, in this repo it is already added.

deployment file can be found under config/deploy/


modify server detail in staging.rb where you want to deploy your application and execute below command.

```sh
 $ cap staging deploy BRANCH=<branch_name>
 ```
