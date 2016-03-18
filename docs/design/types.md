> WARNING: This article is a big work in progress and should not be relied on.
It is still an exploration on how types in PHP can be normalized into something
that is easier to understand (although perhaps more complex) and less error
prone.

# Primitive Types

In PHP, anything that is not a class is probably a primitive type. They are
divided into three main groups (for ??? reasons).

In Nucleus, you can use a `PrimitiveTypeConstraint` to type check these on a
Spec.

## Scalar

Scalar types are basically just data, nothing special about their behavior.

- `string`
- `integer`
- `float`
- `boolean`

## Compound

Compound types seem to be types that group stuff together (I think):

> Compound data types allow for multiple items of the same type to be
aggregated under a single representative entity.

- `array`
- `object`

## Special

As the name implies, they have special behaviors.

- `resource`
- `null`

# Arrays, Collections, Iterators (It's a mess)

There are many collection-ish types in PHP. Here I try to compare them so we
can build better tools around them:

```
| Type         | getKey | setKey | hasKey | foldl | foldr | getKeys |
| ------------ | ------ | ------ | ------ | ----- | ----- | ------- |
| array        | Yes    | Yes    | Yes    | Yes   | Loop  | Yes     |
| ArrayObject  | Yes    | Yes    | Yes    | Yes   | Loop  | Yes     |
| ArrayAccess  | Yes    | Yes    | Yes    | No    | No    | No      |
| Traversable  | Loop   | No     | Loop   | Yes   | Slow  | Loop    |
```

*Loop* meaning that is possible to emulate the behavior by traversing the data
structure at least once (`O(n)`), generate an in-memory representation, and run
the operation on that representation.

## Nucleus' handling of collection types

### Data Types

This is a non-comprehensive list of some of the data types interfaces available
in Nucleus. Each concrete implementation can implement one or more of these.

The design tries to follow FP/Haskell as much as the language allows. It won't
be possible to have a one-to-one mapping, but the concepts should help a lot
in organizing behaviors and functionality:

- **List:** `List`s are usually backed by `array`s or `\ArrayObject`s. They can
also behave like `Map`s, since in PHP all arrays are associative.
- **Map:** Any `List` or something implementing something similar to
`ArrayAccess`.
- **Foldable:** Anything that can be reduced/folded from right to left.
- **LeftFoldable:** Anything that can be reduced/folded from left to right.
This is the most common type since its easier to traverse from left to right on
PHP.
- **KeyFoldable:** Same as `Foldable`, but the key is also provided while
folding.
- **LeftKeyFoldable:** Same as `LeftFoldable`, but the key is also provided
while folding.
- **Functor**
- **Monoid**
- **Semigroup**
- **Traversable** (Not to be confused with PHP's Traversable)

and a few more...

### Immutability

The wrapper classes and any other classes that implement the interfaces above
should be immutable.

### Normalization

PHP's collection types are all over the place, so are the standard library's
function for dealing with them.

Collection types in PHP are "normalized" in Nucleus by wrapping them in special
classes that implement the interfaces above, having these wrapper allows
functions in library classes such as `Std` to operate on these collection
without having to implement a different handler for every type or dealing with
PHP's oddly-named functions.

However, the wrappers are still required to deal with these sort of functions,
but at least they can attempt to provide the faster or more optimal
implementation for a certain function.

**Mappings:**

Components in Nucleus will attempt to use the `ComplexFactory` class. This
class is responsible for taking a primitive collection value and wrapping it in
something the rest of Nucleus can easily understand:

- `array` --> `ArrayList`
- `ArrayObject` --> `ArrayList`
- `ArrayAccess` --> `ArrayAccessMap`
- `Traversable` --> `TraversableLeftFoldable`
- `Iterator` --> `TraversableLeftFoldable`.

**Location:**
Wrapper classes can be found on the `SellerLabs\Nucleus\Data` namespace.

### Constraints:

Some of the interfaces defined above should also have a matching constraint
rule so that input can be validated using the `Arguments` or `Spec` classes:

- ListConstraint
- ReadMapConstraint
- MapConstraint
- FoldableConstraint
- LeftFoldableConstraint

### Looping

As mentioned above, some operations require looping which takes O(n) time (and
O(n) space in some cases).

In most cases, Nucleus should attempt to emulate the requested operation
through looping. The affected function should contain documentation warning
about possible performance issues.

Other operations might be skipped or unsupported if they are very resource
intensive.

This behavior is mainly defined inside the wrapper classes.
