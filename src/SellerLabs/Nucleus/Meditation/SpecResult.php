<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\Meditation;

use SellerLabs\Nucleus\Foundation\BaseObject;
use SellerLabs\Nucleus\Meditation\Constraints\AbstractConstraint;
use SellerLabs\Nucleus\Meditation\Interfaces\CheckResultInterface;
use SellerLabs\Nucleus\Support\Arr;

/**
 * Class SpecResult.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Meditation
 */
class SpecResult extends BaseObject implements CheckResultInterface
{
    const STATUS_PASS = 'pass';
    const STATUS_FAIL = 'fail';

    /**
     * List of field that were missing from the input.
     *
     * @var string[]
     */
    protected $missing;

    /**
     * List of constraints that failed per field.
     *
     * @var array[]
     */
    protected $failed;

    /**
     * Whether the spec check passed or not.
     *
     * @var string
     */
    protected $status;

    /**
     * Construct an instance of a SpecResult.
     *
     * @param string[] $missing
     * @param array[] $failed
     * @param string $status
     */
    public function __construct($missing = [], $failed = [], $status = 'fail')
    {
        parent::__construct();

        $this->missing = $missing;
        $this->failed = $failed;
        $this->status = $status;
    }

    /**
     * Get missing fields.
     *
     * @return string[]
     */
    public function getMissing()
    {
        return $this->missing;
    }

    /**
     * Get failed constrains for every field.
     *
     * @return array[]
     */
    public function getFailed()
    {
        return $this->failed;
    }

    /**
     * Get the failed constrains for a specific field.
     *
     * Dot notation is supported.
     *
     * @param string $fieldName
     *
     * @return AbstractConstraint[]
     */
    public function getFailedForField($fieldName)
    {
        return Arr::dotGet($this->failed, $fieldName);
    }

    /**
     * Get the status of the result.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return true if the check passed.
     *
     * @return bool
     */
    public function passed()
    {
        return $this->status === static::STATUS_PASS;
    }

    /**
     * Return false if the check failed.
     *
     * @return bool
     */
    public function failed()
    {
        return $this->status === static::STATUS_FAIL;
    }
}
