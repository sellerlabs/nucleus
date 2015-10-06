# 0.4.0

First release we track changes

**FEATURES**:
- `Arr` now has `head`, `tail`, `init`, `last` for getting parts of arrays.
- `Std` now has `falsy`.
- A shortcut `Validator::spec` method was added for easily building a Validator
 with a spec.
- `Spec`s can now be nested for complex validation.
- Documentation is now automagically generated via Travis CI.
- Some view classes for Twitter's Bootstrap components are now included.
- Add view class for rendering `pre` HTML nodes.
- It is now possible to generate Specs and Validators using factory classes:
SpecFactory and ValidatorFactory.
- There is a new TransformPipeline component for running a series of
transformations on an array.
- There are a few new built-in constraints:
    - A new DomainConstraint class can be used to validate domain names.
    - AtLeastOneOfConstraint: Requires that at least on of the required
    fields is defined in the input array.
    - ExactlyOneOfConstraint: Requires that exactly only one of the required
    fields is defined in the input array.

**IMPROVEMENTS**:
- Important bug fix in BaseObject.
- The arguments in the callback provided `Std::each` have been switched. This
 is a minor breaking change.
- `Validator::create` was deprecated in favor of `Validator::define`
- `Spec` now has getters for performing reflection, such as displaying
expected types before submitting a form, etc.
- `ArrayUtils` has been removed since it was previously deprecated.
- Most global functions are being deprecated in favor of classes like `Std`,
 `Arr`, etc.
- `Std::only` now has a more sane and flexible behavior. This affects other
helpers such as `Arr::filterNullValues`. Setting `$allowed` to `[]` actually
means that nothing is allowed, which makes sense. To get the traditional
behavior where the input array is passed back, set `$allowed` to `null`. The
default parameter has been updated accordingly to minimize the surface for
breaking changes.
- `TestCase` now has `assertObjectHasAttributes`.

**BUGS**:
- `Std::map` now preserves keys on arrays too. `array_map` was being used as an
optimization, but it turns out it behaves differently since it does not keep
array keys.
- `EitherConstraint` had problems while generating a string version of the
constraint if one of the provided types did not had a `isUnion` method.
