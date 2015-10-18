<?php

namespace Tests\Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Control\MaybeMonad;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class MaybeMonadTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Control
 */
class MaybeMonadTest extends TestCase
{
    public function testBind()
    {
        $getUser = function ($id) {
            if ($id === 5) {
                return MaybeMonad::just([
                    'first_name' => 'Bob',
                ]);
            }

            return MaybeMonad::nothing();
        };

        $getFirstName = function (array $user) {
            return MaybeMonad::just($user['first_name']);
        };

        $result1 = $getUser(5)->bind($getFirstName);
        $result2 = $getUser(4)->bind($getFirstName);

        $this->assertTrue($result1->isJust());
        $this->assertTrue($result2->isNothing());
        $this->assertEquals('Bob', MaybeMonad::fromJust($result1));
    }
}