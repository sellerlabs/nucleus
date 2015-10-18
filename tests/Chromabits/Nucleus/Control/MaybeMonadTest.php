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

        $lowerCase = function ($string) {
            return MaybeMonad::just(strtolower($string));
        };

        $result1 = $getUser(5)->bind($getFirstName);
        $result2 = $getUser(4)->bind($getFirstName);
        $result3 = $getUser(5)->bind($getFirstName)->bind($lowerCase);
        $result4 = $getUser(4)->bind($getFirstName)->bind($lowerCase);

        $this->assertTrue($result1->isJust());
        $this->assertTrue($result2->isNothing());
        $this->assertTrue($result3->isJust());
        $this->assertTrue($result4->isNothing());
        $this->assertEquals('Bob', MaybeMonad::fromJust($result1));
        $this->assertEquals('bob', MaybeMonad::fromJust($result3));
    }

    public function testLeftIdentity()
    {
        // TODO: Ensure this is the right way to test this.
        $lowerCase = function ($string) {
            return MaybeMonad::just(strtolower($string));
        };

        $this->assertEquals(
            MaybeMonad::unit('SomeValue')->bind($lowerCase),
            $lowerCase('SomeValue')
        );
        $this->assertEquals(
            MaybeMonad::unit(null)->bind($lowerCase),
            $lowerCase(null)
        );
    }

    public function testRightIdentity()
    {
        // TODO: Ensure this is the right way to test this.
        $m = MaybeMonad::unit('doge');

        $this->assertEquals(
            $m->bind(function ($x) {
                return MaybeMonad::unit($x);
            }),
            $m
        );

        $this->assertTrue(
            $m->bind(function ($x) {
                return MaybeMonad::unit($x);
            }) == $m
        );
    }
}