# Primitives vs Wrappers

Nucleus comes with a few primitive type wrappers, such as `Rope`, `ArrayList`,
and `ArrayMap`.

One problem with wrappers is (ironically) wrapping things. Creating a wrapper
will always use more memory when compared to the primitive alone. Additionally,
the language makes it easy to declare primitives, while wrappers will always
involve calling a constructor or static method.

For those reasons, it is important to consider when and how to use wrappers, so
we can balance their benefits with their drawbacks:

1. **If you already wrapped something, don't unwrap it.** Unless, you need to
interact with the primitive type directly or pass it into a function that only
works on the primitive.
2. **If the data is not being manipulated, use primitives.** This is the case
when passing arguments to other functions or constructors.
3. **If the data is going to be mutated or read, wrap it.** This is where the
benefits of the wrappers come in. In Nucleus, wrappers are immutable, meaning
that they are easier to follow and don't have unintended side effects.
Additionally, access methods will usually return instance of `Maybe` if the
value being access is not present, which is much nicer than an unexpected
`null` or error.
