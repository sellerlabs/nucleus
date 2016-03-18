<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Validation;

use SellerLabs\Nucleus\Exceptions\CoreException;
use SellerLabs\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use SellerLabs\Nucleus\Meditation\Primitives\ScalarTypes;
use SellerLabs\Nucleus\Meditation\Spec;
use SellerLabs\Nucleus\Testing\TestCase;
use SellerLabs\Nucleus\Validation\Validator;
use Exception;
use stdClass;

/**
 * Class ValidatorTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Validation
 */
class ValidatorTest extends TestCase
{
    public function testCheck()
    {
        $validator = new Validator(new Spec([
            'name' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
            'count' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_INTEGER),
            'exception' => new ClassTypeConstraint(CoreException::class),
            'exception2' => [
                new ClassTypeConstraint(CoreException::class),
                new ClassTypeConstraint(Exception::class),
            ],
            'exception3' => [
                new ClassTypeConstraint(CoreException::class),
                new ClassTypeConstraint(Exception::class),
            ],
        ], [], ['count']), [
            'name' => 'The name should be pretty.',
            'count' => 'The count should be accountable.',
            'exception3' => 'Welp',
        ]);

        $result = $validator->check([
            'name' => 101,
            'exception' => new stdClass(),
            'exception2' => new stdClass(),
            'exception3' => new stdClass(),
        ]);

        $missingClass = 'The value is expected to be an instance of a '
            . 'SellerLabs\\Nucleus\\Exceptions\\CoreException.';
        $missingClass2 = 'The value is expected to be an instance of a '
            . 'Exception.';

        $this->assertEquals(
            [
                'name' => ['The name should be pretty.'],
                'exception' => [$missingClass],
                'exception2' => [$missingClass, $missingClass2],
                'exception3' => ['Welp'],
            ],
            $result->getFailed()
        );
        $this->assertEquals(['count'], $result->getMissing());
    }
}
