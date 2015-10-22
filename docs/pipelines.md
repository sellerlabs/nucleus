# Transform Pipelines

> It is recommended that you first read about [_Transforms_](transforms.md).

Once you have a bunch of _Transforms_, you may want to chain them together.
While you could just call each one of them inside each other, Nucleus provides
a handy class which makes this process easier to read: _Transform Pipelines_.

**Example:**

```php
<?php

$clean = TransformPipeline::define()
    ->add(new OnlyTransform([
        'first_name', 'last_name', 'email', 'password', 'phone'
    ]))
    ->add($this->passwordHashTransform)
    ->add(new ExtendTransform(['verified' => false]))
    ->run($data);
```

On this example, the following transformations are performed on `$data`:

1. The input fields are filtered to only a few specific fields.
2. A custom transform is applied to hash the password of a user.
3. The `verified` field is added to the array.
