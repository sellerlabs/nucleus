# Foundation Classes

## BaseObject

A few PHP pitfalls can be avoided by using `BaseObject` as the parent class for
all parent classes in a project. Essentially, if a class does not extend
something, it should extend `BaseObject`.

`BaseObject` will add the following protections to classes extending it:

- Prevent the constructor of an object being called with additional parameters
by accident.
- Protect against the use of undefined properties.
- Prevent accidental object iteration on objects.

## StaticObject

Similarly, the `StaticObject` class is intended as a base class for classes
that are intended to only be used statically (They only contain static methods).

If the constructor of the class is called, a `CoreException` will be thrown.

## Entity

// TODO

## Enum

Provides two methods: `getKeys` and `getValues` for easily accessing the
constants in a class, which are commonly used for enum-like behaviors in PHP.

```php
<?php

use Chromabits\Nuclues\Foundation\Enum;

class DogeTypes extends Enum
{
    const TYPE_HAPPY = 'happy';
    const TYPE_ANGRY = 'angry';
    const TYPE_DOGE = 'doge';
}

DogeTypes::getValues(); // ['happy', 'angry', 'doge']
```