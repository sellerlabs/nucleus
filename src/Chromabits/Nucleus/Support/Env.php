<?php

namespace Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Data\ArrayMap;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\StaticObject;

/**
 * Class Env
 *
 * Utility functions for interacting with the environment.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Env extends StaticObject
{
    /**
     * Get an environment variable or return the default if it is not defined.
     *
     * @param string $key
     * @param null|mixed|callable $default
     *
     * @return bool|mixed|null|string
     */
    public static function get($key, $default = null)
    {
        $value = static::getRaw($key, $default);

        if (is_string($value)) {
            // Convert some common values into their scalar types.
            switch (strtolower($value)) {
                case 'true':
                    return true;

                case 'false':
                    return false;

                case 'null':
                    return null;
            }

            // Strip "" if the string is wrapped in them.
            if (Str::beginsWith($value, '"') && Str::endsWith($value, '"')) {
                return substr($value, 1, -1);
            }
        }

        return $value;
    }

    /**
     * Get an environment variable or return the default if it is not defined.
     *
     * This avoid any post-processing, such as automatic casting.
     *
     * @param string $key
     * @param null|mixed|callable $default
     *
     * @return mixed|string
     */
    public static function getRaw($key, $default = null)
    {
        $env = ArrayMap::of($_ENV);
        $server = ArrayMap::of($_SERVER);

        if ($env->member($key)) {
            return Maybe::fromJust($env->lookup($key));
        } elseif ($server->member($key)) {
            return Maybe::fromJust($server->lookup($key));
        }

        $value = getenv($key);

        if ($value === false) {
            return Std::thunk($default);
        }

        return $value;
    }

    /**
     * Get an environment variable or fail.
     *
     * @param string $key
     *
     * @return bool|mixed|null|string
     */
    public static function getOrFail($key)
    {
        return static::get($key, function () use ($key) {
            throw new CoreException(vsprintf(
                'The variable %s was not found in the environment',
                [$key]
            ));
        });
    }

    /**
     * Set an environment variable with the provided value.
     *
     * @param string $key
     * @param string|bool|int|float $value
     */
    public static function set($key, $value)
    {
        putenv(vsprintf('%s=%s', [$key, $value]));
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}
