<?php

namespace Tests\SellerLabs\Nucleus\Foundation;

use SellerLabs\Nucleus\Foundation\Entity;
use SellerLabs\Nucleus\Support\Str;

/**
 * Class SampleEntity
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Foundation
 */
class SampleEntity extends Entity
{
    protected $fillable = ['last_name', 'age', 'pin'];

    protected $hidden = ['pin'];

    protected $visible = ['first_name'];

    protected $firstName;

    protected $pin;

    protected $age;

    protected $lastName;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param integer $pin
     */
    public function setPin($pin)
    {
        $this->pin = (int) $pin;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = (int) $age;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return Str::studly($this->lastName);
    }
}