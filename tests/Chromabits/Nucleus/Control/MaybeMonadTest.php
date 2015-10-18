<?php

namespace Tests\Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Control\MaybeMonad;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Support\Str;
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
        $just = MaybeMonad::unit('doge');
        $nothing = MaybeMonad::nothing();

        $this->assertEquals(
            $just->bind(function ($x) {
                return MaybeMonad::unit($x);
            }),
            $just
        );

        $this->assertEquals(
            $nothing->bind(function ($x) {
                return MaybeMonad::unit($x);
            }),
            $nothing
        );
    }

    public function testAssociativity()
    {
        // TODO: Ensure this is the right way to test this.
        $lowerCase = function ($string) {
            return MaybeMonad::just(strtolower($string));
        };

        $camelCase = function ($string) {
            return MaybeMonad::just('Camelcase: ' . Str::camel($string));
        };

        $this->assertEquals(
            MaybeMonad::just('OMG_WHAT_IS_THIS')
                ->bind($lowerCase)
                ->bind($camelCase),
            MaybeMonad::just('OMG_WHAT_IS_THIS')
                ->bind(function ($x) use ($lowerCase, $camelCase) {
                    return $lowerCase($x)->bind($camelCase);
                })
        );

        $this->assertEquals(
            MaybeMonad::nothing()
                ->bind($lowerCase)
                ->bind($camelCase),
            MaybeMonad::nothing()
                ->bind(function ($x) use ($lowerCase, $camelCase) {
                    return $lowerCase($x)->bind($camelCase);
                })
        );

        $this->assertEquals(
            MaybeMonad::fromJust(
                MaybeMonad::just('OMG_WHAT_IS_THIS')
                    ->bind($lowerCase)
                    ->bind($camelCase)
            ),
            'Camelcase: omgWhatIsThis'
        );
    }

    public function testFromMaybe()
    {
        $just = MaybeMonad::unit('doge');
        $nothing = MaybeMonad::nothing();

        $this->assertEqualsMatrix([
            ['doge', MaybeMonad::fromMaybe('default', $just)],
            ['default', MaybeMonad::fromMaybe('default', $nothing)],
        ]);
    }

    public function testFromJustWithInvalid()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        MaybeMonad::fromJust(MaybeMonad::nothing());
    }

    public function testJustWithInvalid()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        MaybeMonad::just(null);
    }
}