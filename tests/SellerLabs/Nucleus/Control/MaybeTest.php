<?php

namespace Tests\SellerLabs\Nucleus\Control;

use SellerLabs\Nucleus\Control\Maybe;
use SellerLabs\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use SellerLabs\Nucleus\Support\Str;
use SellerLabs\Nucleus\Testing\TestCase;

/**
 * Class MaybeMonadTest
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Control
 */
class MaybeTest extends TestCase
{
    public function testBind()
    {
        $getUser = function ($id) {
            if ($id === 5) {
                return Maybe::just([
                    'first_name' => 'Bob',
                ]);
            }

            return Maybe::nothing();
        };

        $getFirstName = function (array $user) {
            return Maybe::just($user['first_name']);
        };

        $lowerCase = function ($string) {
            return Maybe::just(strtolower($string));
        };

        $result1 = $getUser(5)->bind($getFirstName);
        $result2 = $getUser(4)->bind($getFirstName);
        $result3 = $getUser(5)->bind($getFirstName)->bind($lowerCase);
        $result4 = $getUser(4)->bind($getFirstName)->bind($lowerCase);

        $this->assertTrue($result1->isJust());
        $this->assertTrue($result2->isNothing());
        $this->assertTrue($result3->isJust());
        $this->assertTrue($result4->isNothing());
        $this->assertEquals('Bob', Maybe::fromJust($result1));
        $this->assertEquals('bob', Maybe::fromJust($result3));
    }

    public function testLeftIdentity()
    {
        // TODO: Ensure this is the right way to test this.
        $lowerCase = function ($string) {
            return Maybe::just(strtolower($string));
        };

        $this->assertEquals(
            Maybe::of('SomeValue')->bind($lowerCase),
            $lowerCase('SomeValue')
        );
        $this->assertEquals(
            Maybe::of(null)->bind($lowerCase),
            $lowerCase(null)
        );
    }

    public function testRightIdentity()
    {
        // TODO: Ensure this is the right way to test this.
        $just = Maybe::of('doge');
        $nothing = Maybe::nothing();

        $this->assertEquals(
            $just->bind(function ($x) {
                return Maybe::of($x);
            }),
            $just
        );

        $this->assertEquals(
            $nothing->bind(function ($x) {
                return Maybe::of($x);
            }),
            $nothing
        );
    }

    public function testAssociativity()
    {
        // TODO: Ensure this is the right way to test this.
        $lowerCase = function ($string) {
            return Maybe::just(strtolower($string));
        };

        $camelCase = function ($string) {
            return Maybe::just('Camelcase: ' . Str::camel($string));
        };

        $this->assertEquals(
            Maybe::just('OMG_WHAT_IS_THIS')
                ->bind($lowerCase)
                ->bind($camelCase),
            Maybe::just('OMG_WHAT_IS_THIS')
                ->bind(function ($x) use ($lowerCase, $camelCase) {
                    return $lowerCase($x)->bind($camelCase);
                })
        );

        $this->assertEquals(
            Maybe::nothing()
                ->bind($lowerCase)
                ->bind($camelCase),
            Maybe::nothing()
                ->bind(function ($x) use ($lowerCase, $camelCase) {
                    return $lowerCase($x)->bind($camelCase);
                })
        );

        $this->assertEquals(
            Maybe::fromJust(
                Maybe::just('OMG_WHAT_IS_THIS')
                    ->bind($lowerCase)
                    ->bind($camelCase)
            ),
            'Camelcase: omgWhatIsThis'
        );
    }

    public function testFromMaybe()
    {
        $just = Maybe::of('doge');
        $nothing = Maybe::nothing();

        $this->assertEqualsMatrix([
            ['doge', Maybe::fromMaybe('default', $just)],
            ['default', Maybe::fromMaybe('default', $nothing)],
        ]);
    }

    public function testFromJustWithInvalid()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        Maybe::fromJust(Maybe::nothing());
    }

    public function testFmap()
    {
        $just = Maybe::just('DOGE');
        $nothing = Maybe::nothing();

        $lowerCase = function ($string) {
            return Maybe::just(strtolower($string));
        };

        $result1 = $just->fmap($lowerCase);
        $result2 = $nothing->fmap($lowerCase);

        $this->assertTrue($result1->isJust());
        $this->assertTrue($result2->isNothing());
    }
}