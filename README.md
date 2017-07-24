# json-rest
Json response builder library for php.

## Installation

### Composer

Add to your composer.json or create a new composer.json:

```js
{
    "require": {
        "tansandbox/json-rest": "*"
    }
}
```
Tell the composer to download the library by running the command:

```sh
$ php composer.phar install
```
To include using compser require, run the following command from your project.

```sh
$ php composer.phar require tansandbox/json-rest
```

## Basic usages

### Creating object
use TanSandbox\JsonRest\Builder;

$builder = new Builder() ;

### Return success 
```php
/*
{
    "status": true,
    "data": {
        "name": "Nithin",
        "subject": "English",
        "mark": "90"
    }
}*/
$data = array (
    'name' => 'Nithin',
    'subject' => 'English',
    'mark' => '90'
);
$builder->ok($data) ;
```

### Return failure
```php
/*
{
    "status": false,
    "data": {
        "name": "Please provide a valid name"
    }
}
*/
$data = array(
    'name' => 'Please provide a valid name'
);
$builder->fail($data) ;
```

### Return custom http status
```php
/*
{
    "status": false,
    "data": {
        "reply": "Resource not found."
    }
}
*/
$data = array(
    'reply' => 'Resource not found.'
);
$builder->setStatus(404)->send($data) ;
```

### Advanced responses
```php
/* 
{
    "status": false,
    "data": {
        "name": "Nithin",
        "subject": "English",
        "mark": "90"
    },
    "message": "Action completed"
}
*/
$data = array (
    'name' => 'Nithin',
    'subject' => 'English',
    'mark' => '90'
);
$builder->setMessage('Action completed')->setStatus(200)->send($data) ;
```

### Method chaining with sendie() "send and die"
```php
/* 
{
    "status": true,
    "message": "Action completed",
    "name": "Nithin",
    "subject": "English",
    "mark": "90",
    "customNotes": "Student of ZF2"
}
*/
$builder->setName('Nithin')
    ->setSubject('English')
    ->setMark('90')
    ->setCustomNotes('Student of ZF2')
    ->sendie() ;
```
