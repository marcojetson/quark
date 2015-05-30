Quark
=====

Another dependency injection container

[![Build status](https://img.shields.io/travis/PHP-DI/Invoker.svg?style=flat-square)](https://travis-ci.org/marcojetson/quark)
[![Test coverage](https://codeclimate.com/github/marcojetson/quark/badges/coverage.svg)](https://codeclimate.com/github/marcojetson/quark/coverage)

Services
--------

Register services using _set_ and providing an identifier and a factory

```php
$application->set('service', function () {
    return new stdClass();
});
```

Access the service anywhere in your application

```php
$service = $application->service;
```

If you want to share the same instance across your application use _share_

```php
$application->share('service', function () {
    return new stdClass();
});
```

You can provide arguments for your services

```php
$application->set('person', function ($name) {
    $person = new stdClass();
    $person->name = $name;
    
    return $person;
});

$person = $application->person('Marco');
```
