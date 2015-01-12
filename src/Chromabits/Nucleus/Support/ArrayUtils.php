<?php

namespace Chromabits\Nucleus\Support;

/**
 * Class ArrayUtils
 *
 * Array utility functions
 *
 * @package Chromabits\TutumClient\Support
 */
class ArrayUtils
{
    /**
     * Get array elements that are not null
     *
     * @param $properties
     * @param array $allowed
     * @return array
     */
    public function filterNullValues($properties, array $allowed = null)
    {
        // If provided, only use allowed properties
        $properties = $this->filterKeys($properties, $allowed);

        return array_filter($properties, function ($value) {
            return !is_null($value);
        });
    }

    /**
     * Set properties of an object by only calling setters of array keys that are set
     * in the input array. Useful for parsing API responses into entities.
     *
     * @param $object
     * @param array $input
     * @param array $allowed
     */
    public function callSetters($object, array $input, array $allowed = [])
    {
        $filtered = $this->filterKeys($input, $allowed);

        foreach ($filtered as $key => $value) {
            $setterName = 'set' . Str::studly($key);

            $object->$setterName($value);
        }
    }

    /**
     * Filter the keys of an array to only the allowed set
     *
     * @param $input
     * @param array $allowed
     * @return array
     */
    public function filterKeys($input, $allowed = [])
    {
        if (is_null($allowed) || count($allowed) == 0) {
            return $input;
        }

        return array_filter($input, function ($key) use ($allowed) {
            return in_array($key, $allowed);
        }, ARRAY_FILTER_USE_KEY);
    }
}
