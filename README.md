# psr14

php psr14

## Installation

``` cmd
composer require diggphp/psr14
```

## Usage

``` php
$event = new Event();

$event->listen(function (stdClass $obj) {
    echo 'foo';
}, 2);
$event->listen(function (stdClass $obj) {
    echo 'bar';
}, 1);
$event->listen(function (stdClass $obj) {
    echo 'baz';
}, 3);

$obj = new stdClass;
$event->dispatch($obj);
// baz foo bar
```
