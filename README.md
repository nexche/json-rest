# json-rest
Json response builder library for php.

## Installation

### Composer

Add to your composer.json or create a new composer.json:

```js
{
    "require": {
        "nexche/json-rest": "*"
    }
}
```
Tell the composer to download the library by running the command:

```sh
$ php composer.phar install
```
To include using compser require, run the following command from your project.

```sh
$ php composer.phar require nexche/json-rest
```

## Basic usages

### Creating object
```php
use Nexche\JsonRest\Builder;
$builder = new Builder() ;
```

### Returning a success response
```php
$data = array (
    'name' => 'Nithin',
    'subject' => 'English',
    'mark' => '90'
);
$builder->ok()->send($data) ;
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
$builder->fail()->send($data) ;
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
### Method chaining.
New json member can be added using the setXXX methods. The sendie() method is to output the reponse and to die after that.
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
