# psr14

php psr14

## Installation

``` cmd
composer require diggphp/psr14
```

## Usage

``` php
$provider = new ListenerProvider;
$event = new EventDispatcher($provider);

$provider->listen(function (stdClass $obj) {
    echo 'foo';
}, 2);
$provider->listen(function (stdClass $obj) {
    echo 'bar';
}, 1);
$provider->listen(function (stdClass $obj) {
    echo 'baz';
}, 3);

$obj = new stdClass;
$event->dispatch($obj);
// baz foo bar
```
