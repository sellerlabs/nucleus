<?php

namespace SellerLabs\Nucleus\Meditation;

use SellerLabs\Nucleus\Control\Maybe;
use SellerLabs\Nucleus\Data\ArrayList;
use SellerLabs\Nucleus\Data\ArrayMap;
use SellerLabs\Nucleus\Data\Iterable;
use SellerLabs\Nucleus\Meditation\Constraints\AbstractTypeConstraint;

/**
 * Class TypedSpec.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Meditation
 */
class TypedSpec extends Spec
{
    const ANNOTATION_TYPE = 'type';

    /**
     * Annotate the type of a field.
     *
     * @param string $fieldName
     * @param AbstractTypeConstraint $type
     *
     * @return TypedSpec
     */
    public function withFieldType($fieldName, AbstractTypeConstraint $type)
    {
        return $this->withFieldAnnotation(
            $fieldName,
            static::ANNOTATION_TYPE,
            $type
        );
    }

    /**
     * Get the type annotation for every field.
     *
     * @return ArrayMap
     */
    public function getTypes()
    {
        return $this->getAnnotation(static::ANNOTATION_TYPE);
    }

    /**
     * Get all the constraints for a field.
     *
     * @param string $fieldName
     *
     * @return Iterable
     */
    protected function getInternalFieldConstraints($fieldName)
    {
        return parent::getInternalFieldConstraints($fieldName)
            ->append(ArrayList::of([$this->getFieldType($fieldName)]));
    }

    /**
     * Get the type annotation for a field.
     *
     * @param string $fieldName
     *
     * @return AbstractTypeConstraint
     */
    public function getFieldType($fieldName)
    {
        return Maybe::fromMaybe(
            Boa::any(),
            $this->getFieldAnnotation($fieldName, static::ANNOTATION_TYPE)
        );
    }
}