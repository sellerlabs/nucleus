<?php

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Data\ArrayMap;

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
    public function withFieldLabel($fieldName, $label)
    {
        return $this->withFieldAnnotation(
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
    public function withFieldDescription($fieldName, $description)
    {
        return $this->withFieldAnnotation(
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

    /**
     * Get the labels for all fields.
     *
     * @return ArrayMap
     */
    public function getLabels()
    {
        return $this->getAnnotation(static::ANNOTATION_LABEL);
    }

    /**
     * Get the descriptions for all fields.
     *
     * @return ArrayMap
     */
    public function getDescriptions()
    {
        return $this->getAnnotation(static::ANNOTATION_DESCRIPTION);
    }
}