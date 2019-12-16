# ArrayReader

The ArrayReader is a basic wrapper to get a value from array

## Installation

```bash
composer require ueef/array-reader
```

## Usage

```php
<?php

use Ueef\ArrayReader\Reader;

$reader = new Reader([
    'foo' => [
        'bar' => '9000'
    ]
]);

// Output: value1
echo $reader->getInt("", "foo", "bar");
```