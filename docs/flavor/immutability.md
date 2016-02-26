# Immutability

Immutable objects in PHP can be emulated by wrapping any action that would
otherwise mutate the state of an object with the following pattern:

```php
<?php

class Immutable
{
    public function mutate()
    {
        $copy = clone $this;

        // Perform mutations on $copy (not $this).

        return $copy;
    }
}
```

## Naming

Setters in PHP usually begin with `set`. When building an immutable object,
use `with` to make it clear that the method won't change the state of the
object, but return a new instance with the mutation applied.