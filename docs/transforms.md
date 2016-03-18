# Transform

While working on data in your application, you might find that there are
certain actions which work on this data that can are repeated over and over
throughout the codebase.

If you abstract this one function into a separate class for reuse, you are
essentially using the _Transform_ pattern.

## On Nucleus:

In Nucleus, a class is considered to be a transform if its capable of applying
one operation to an array and return the result.

**Why an array?:** While a transform does not explicitly need to work on an
array, sticking to just arrays allows transforms to be more reusable by
allowing users to chain them in any order they want without having to worry
about the data types. For this reason, most of the tooling on Nucleus is built
around transforms that act on arrays.

**The interface:** On Nucleus, transforms implement the `TransformInterface`
interface, which is available on the `SellerLabs\Nucleus\Support` namespace.

**Built-in:** Nucleus includes a few built-in transforms, such as:

- `OnlyTransform`: Only allow the specified keys in the array to go through.
- `ExtendTransform`: Extend and array by merging it with another array,
overriding colliding properties.

## Design Recommendations:

- Keep transforms simple and focused on only one task.
- Avoid including side effects on your transforms, such as database calls.
- If something goes wrong, its recommended that the transform throws an
exception, so that if it is part of a pipeline, execution stops and does not
continue with invalid data.

### Benefits

- Transforms are usually trivial to test.
- Code that would normally be stuck in a protected/private function is now
reusable through your application.
- Allows you to compose more complex functions through _Pipelines_.

### Problems

- Building a whole class for simple function could be time consuming and
overkill.
- Nucleus only uses arrays, which means you don't have type hinting assertions,
and if you would like to use an object you have to cast it to and from an array.
