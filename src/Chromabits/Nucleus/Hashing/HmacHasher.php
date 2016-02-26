<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Hashing;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;

/**
 * Class HmacHasher.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Hashing
 */
class HmacHasher extends BaseObject
{
    /**
     * Algorithm to use for hashing.
     *
     * @var string
     */
    protected $algorithm;

    /**
     * Construct a new instance of a HmacHasher.
     *
     * @param string $algorithm
     */
    public function __construct($algorithm = 'sha512')
    {
        parent::__construct();

        $this->algorithm = $algorithm;
    }

    /**
     * Get a list of supported hashing algorithms.
     *
     * @return array
     */
    public static function getAlgorithms()
    {
        return hash_algos();
    }

    /**
     * Generate a hash of the content using the provided private key.
     *
     * @param string $content
     * @param string $privateKey
     *
     * @return string
     */
    public function hash($content, $privateKey)
    {
        Arguments::define(Boa::string(), Boa::string())
            ->check($content, $privateKey);

        return hash_hmac($this->algorithm, $content, $privateKey);
    }

    /**
     * Verify that a hash is valid.
     *
     * @param string $hash
     * @param string $content
     * @param string $privateKey
     *
     * @return bool
     */
    public function verify($hash, $content, $privateKey)
    {
        return $this->hash($content, $privateKey) === $hash;
    }
}
