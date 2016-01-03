<?php

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Control\Maybe;

/**
 * Class FormSpec.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class FormSpec extends TypedSpec
{
    const ANNOTATION_LABEL = 'label';
    const ANNOTATION_DESCRIPTION = 'description';

    /**
     * Set the label for a field.
     *
     * @param string $fieldName
     * @param string $label
     *
     * @return static
     */
    public function setFieldLabel($fieldName, $label)
    {
        return $this->setFieldAnnotation(
            $fieldName,
            static::ANNOTATION_LABEL,
            $label
        );
    }

    /**
     * Set the description for a field.
     *
     * @param string $fieldName
     * @param string $description
     *
     * @return static
     */
    public function setFieldDescription($fieldName, $description)
    {
        return $this->setFieldAnnotation(
            $fieldName,
            static::ANNOTATION_DESCRIPTION,
            $description
        );
    }

    /**
     * Get a field's label.
     *
     * @param string $fieldName
     *
     * @return Maybe
     */
    public function getFieldLabel($fieldName)
    {
        return $this->getFieldAnnotation($fieldName, static::ANNOTATION_LABEL);
    }

    /**
     * Get a field's description.
     *
     * @param string $fieldName
     *
     * @return Maybe
     */
    public function getFieldDescription($fieldName)
    {
        return $this->getFieldAnnotation(
            $fieldName,
            static::ANNOTATION_DESCRIPTION
        );
    }
}