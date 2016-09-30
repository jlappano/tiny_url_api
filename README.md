# Tiny Url Api

A Symfony project created on September 28, 2016, 4:32 pm.
An api transforming long urls to cute tiny ones

### Getting Set Up:


 * Requires PHP 5.6 or higher
 * [Composer](https://getcomposer.org/download/) required for package installation

Clone and install packages:
```
$ git clone https://github.com/jlappano/tiny_url_api.git
$ cd tiny_url_api/
$ composer install
```

Set up the database:
```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
$ php bin/console doctrine:fixtures:load
```

Run the tests:
```
$ vendor/bin/phpunit tests/ApiBundle
```
