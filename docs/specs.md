# Spec

In Nucleus, the Spec class is an loose implementation of the [Specification Pattern](https://en.wikipedia.org/wiki/Specification_pattern). Specs is one of
the tools available on Nucleus for performing input validation:

    ┌─────────────┐     ┌─────────────┐     ┌──────────────┐
    │ Constraints │────▶│    Specs    │────▶│  Validators  │
    └─────────────┘     └─────────────┘     └──────────────┘

Specs first merge an input array with an array containing **default values**.
Then, each field is ran against a set of **constraints**. Finally, the spec
checks for any missing **required** fields that were not provided in the input.

This results in a `SpecResult` instance, which contains metadata regarding the
check performed, such as whether it passed or not, which fields are missing,
and messages on which constraints failed on which fields.

Using this data, you could build a full blown validator or just provide useful
exception messages. It's up to you. Specs don't provide these things because on
some cases you don't need them, just as sometimes simple assertions/constraints
are more than enough for the data that you are trying to validate.

**Summary:**

- Specs validate data against constraints (rules).
- You can define which fields are required.
- You can provide default values for each field.
- The resulting object contains information about the check.

**Example:**

Let's say that we wanted to create a spec that describes a User object:

```php
$spec = Spec::define([
        'first_name' => Boa::string(),
        'last_name' => Boa::string(),
        'zip' => Boa::integer(),
        'subscribed' => Boa::boolean(),
    ], [
        'subscribed' => false,
    ], ['first_name', 'last_name', 'phone']);
```

As you can see, the constructor of Spec takes three arrays:

- A map of strings to an `AbstractConstraint|AbstractConstraint[]|Spec`.
- A map of strings to a default value (`mixed`).
- An array of strings indicating which fields are required.

A check can be performed by calling `->check()`:

```php
$result = $spec->check([
    'first_name' => 'Lisbeth',
    'last_name' => 'Salander',
    'zip' => 40404,
]);

$result->passes(); // --> true
```

When a constraint fails, we can get more information:

```php
$result = $spec->check([
    'first_name' => null,
    'subscribed' => new Exception(),
    'zip' => 40404,
]);

$result->passes(); // --> false
$result->getMissing(); // --> ['last_name'];
```

## Nested Specs

If you look at the description of the possible constraint types above, you will
notice that Specs also support having another Spec as a constraint for a field.
This allows you to describe more complex objects.

The need for validating this kind of data doesn't show up frequently when
dealing with things like database models, however, developers of APIs receiving
complex JSON objects on POST requests might find this more useful.

## SpecFactory

The `SpecFactory` class simply provides a cleaner and sugary interface for
quickly defining a Spec. For example, we can take our Spec for Users and write
it using the factory:

```php
$result = SpecFactory::define()
    ->let('first_name', Boa::string())
    ->let('last_name', Boa::string())
    ->let('zip', Boa::integer())
    ->let('subscribed', Boa::boolean())
    ->defaultValue('subscribed', false)
    ->required(['first_name', 'last_name', 'phone'])
    ->make();
```

## Context-only Constraints

There are situations where you might need to write or use constraints that
don't rely on any specific field, but on the input itself. Like making sure
that either exactly one or another field are defined in the input.

The way you can accommodate these with Specs is by defining a field that you
know is not going to be used in your input and give it a default value of
`null`.

However, this is a lot to write and remember, so the `SpecFactory` class
contains a `->letByContext($constraints)` function. In the background, it will
define a property called `*` with the provided constraints, and it will give it
a default value of `null`.
