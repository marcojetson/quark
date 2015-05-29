Quark
=====

Another dependency injection container

Services
--------

Register services using _set_ and providing an identifier and a factory

```php
<?php

$application->set('service', function () {
    return new stdClass();
});
```

Access the service anywhere in your application

```php
<?php

$service = $application->service;
```

If you want to share the same instance across your application use _share_

```php
<?php

$application->share('service', function () {
    return new stdClass();
});
```

You can provide arguments for your services

```php
<?php

$application->set('person', function ($name) {
    $person = new stdClass();
    $person->name = $name;
    
    return $person;
});

$person = $application->service('Marco');
```
