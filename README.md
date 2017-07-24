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
```php
use TanSandbox\JsonRest\Builder;
$builder = new Builder() ;
```

### Returning a success response
```php
$data = array (
    'name' => 'Nithin',
    'subject' => 'English',
    'mark' => '90'
);
$builder->ok($data) ;
```
Will produce
```js
{
    "status": true,
    "data": {
        "name": "Nithin",
        "subject": "English",
        "mark": "90"
    }
}
```
### Return a failure
```php
$data = array(
    'name' => 'Please provide a valid name'
);
$builder->fail($data) ;
```
Will produce
```js
{
    "status": false,
    "data": {
        "name": "Please provide a valid name"
    }
}
```
### Response with custom http status
```php
$data = array(
    'reply' => 'Resource not found.'
);
$builder->setStatus(404)->send($data) ;
```
Will produce
```js
{
    "status": false,
    "data": {
        "reply": "Resource not found."
    }
}
```
### Advanced response
```php
$data = array (
    'name' => 'Nithin',
    'subject' => 'English',
    'mark' => '90'
);
$builder->setMessage('Action completed')->setStatus(200)->send($data) ;
```
Will produce
```js
{
    "status": false,
    "data": {
        "name": "Nithin",
        "subject": "English",
        "mark": "90"
    },
    "message": "Action completed"
}
```
### Method chaining ( uses sendie() )
```php
$builder->setName('Nithin')
    ->setSubject('English')
    ->setMark('90')
    ->setCustomNotes('Student of ZF2')
    ->sendie() ;
```
Will produce
```js
{
    "status": true,
    "message": "Action completed",
    "name": "Nithin",
    "subject": "English",
    "mark": "90",
    "customNotes": "Student of ZF2"
}
```