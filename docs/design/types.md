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

| Type         | Get by key | Set by key | Exists by index | Traversable | Get keys |
| ------------ | ---------- | ---------- | --------------- | ----------- | -------- |
| array        | Yes        | Yes        | Yes             | Yes         | Yes      |
| ArrayObject  | Yes        | Yes        | Yes             | Yes         | Yes      |
| ArrayAccess  | Yes        | Yes        | Yes             | No          | No       |
| Traversable  | Loop       | No         | Loop            | Yes         | Loop     |
| Iterator     | Loop       | No         | Loop            | Yes         | Loop     |

*Loop* meaning that is possible to emulate the behavior by traversing the data
structure at least once.

## Proposal (for Nucleus):

In order to keep the type constraints in Nucleus as simple and consistent and
possible, the library will define the following types constraints on top of what
PHP already defines. They are not new types (classes or interfaces), they are
just constraints that the Nucleus code (and its users) will use to identify
behaviors of types.

- **ListConstraint**: Anything that has __complete__ array-like behavior:
array, ArrayObject (not ArrayAccess)
- **ReadMapConstraint**: Anything that can map a key to a value: array,
ArrayObject, ArrayAccess, Traversable (loop), Iterator (loop). Here we don't
care about how we get the key value map, as long as we can get one. So loop
(`O(n)`) implementations are acceptable.
- **MapConstraint**: Anything that can map a key to a value and define new
key-value pairs
- **TraversableConstraint**: Anything that can be put on a foreach loop: array,
ArrayObject, Traversable, Iterator. The reason we need to redefine this as a
constraint is that PHP's idea of Traversable only covers classes, but `array`s
also exhibits the same behavior.

In Nucleus, each one of these type constraint will also probably have a
related utility class to abstract users away from the actual PHP types.

### Definitions

The type constraints mentioned above can be easily defined as type unions.
Types that belong to PHP will be preceded with a `\`. Primitive types will
just start with a lowercase letter.

`ListConstraint = array|\ArrayObject`
`TraversableConstraint = array|\Traversable`
`MapConstraint = array|\ArrayAccess`
`ReadMapConstraint = MapConstraint|TraversableConstraint`
