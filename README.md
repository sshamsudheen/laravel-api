
## How to Build and Run

Download the sorcecode from the git / clone from the git repository
- wget https://github.com/sshamsudheen/laravel-api/archive/master.zip.

Extraxt the zip file

- unzip master.zip

Configure the .env file

- cd laravel-api-master/ ; cp .env_example .env
- provide your database details

Run composer

- composer install
- php artisan migrate;
- php artisan key:generate
- start the fpm server  by running 
- ~/laravel-api-master$ sudo php artisan serve 

The above command will return 
Laravel development server started: <http://127.0.0.1:8000>

### Data import
* The API should provide a PUT or POST endpoint to add new products from a JSON encoded list.

- curl -X POST http://localhost:8000/api/products   -H "Accept: application/json"   -H "Content-Type: application/json"   -T 'products.json';

* A sample list of products is available in the `products.json` file.

### Products
* The API should have an endpoint returning a list of all products.

- http://localhost:8000/api/products (or) 
- curl -X GET http://localhost:1234/api/products   -H "Accept: application/json"   -H "Content-Type: application/json" 

* The API should provide an endpoint returning detailed product information given a certain product ID.
- curl -X GET http://localhost:1234/api/products/3   -H "Accept: application/json"   -H "Content-Type: application/json"  (or)
- http://localhost:8000/api/products/3

{"id":3,"collection_id":2,"image":"dw-petite-28-melrose-white-cat.png","name":"Classic Petite Melrose 28mm (White)","sku":"C99900219","created_at":"2018-10-18 11:53:34","updated_at":"2018-10-18 11:53:34","collection":{"id":2,"collection":"classic-petite","size":28,"created_at":"2018-10-18 11:53:34","updated_at":"2018-10-18 11:53:34"}}

* It should be possible to retrieve a list of IDs of all the products of the same size

 - curl -X GET http://localhost:1234/api/products/size/38   -H "Accept: application/json"   -H "Content-Type: application/json"
or

- http://localhost:1234/api/products/size/28

### Collections
* The API should have an endpoint returning a list of all collections
- http://localhost:8000/api/collections (or)
- curl -X GET http://localhost:1234/api/collections   -H "Accept: application/json"   -H "Content-Type: application/json"  

* It should be possible to retrieve a list of IDs of all the products in the same collection
- http://localhost:1234/api/collections/3 (or)
- curl -X GET http://localhost:1234/api/collections/3   -H "Accept: application/json"   -H "Content-Type: application/json" 

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
