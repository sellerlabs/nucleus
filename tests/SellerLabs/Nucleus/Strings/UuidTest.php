<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Strings;

use SellerLabs\Nucleus\Strings\Uuid;
use SellerLabs\Nucleus\Testing\TestCase;

/**
 * Class UuidTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Strings
 */
class UuidTest extends TestCase
{
    public function testV4()
    {
        $one = Uuid::v4();
        $two = Uuid::v4();

        $this->assertNotEquals($one, $two);
        $this->assertRegExp(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]'
            . '{3}-[0-9a-f]{12}$/',
            $one
        );

        $this->assertEqualsMatrix([
            [true, Uuid::validV4($one)],
            [true, Uuid::validV4($two)],
            [false, Uuid::validV4('lololololo-lololol-losdjdskjd')],
            [false, Uuid::validV4('asdfsadfdafafasgafghkjhkskdhfkaj')],
            [false, Uuid::validV4('xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx')],
            [true, Uuid::validV4('aaaaaaaa-aaaa-4aaa-aaaa-aaaaaaaaaaaa')],
            [false, Uuid::validV4('aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa')],
        ]);
    }
}
