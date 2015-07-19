<?php

namespace Tests\Chromabits\Nucleus\Testing;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Exceptions\ResolutionException;
use Chromabits\Nucleus\Testing\Impersonator;
use Chromabits\Nucleus\Testing\TestCase;
use Mockery as m;
use Mockery\MockInterface;
use Tests\Chromabits\Nucleus\Testing\ExampleService\ExampleA;
use Tests\Chromabits\Nucleus\Testing\ExampleService\ExampleAInterface;
use Tests\Chromabits\Nucleus\Testing\ExampleService\ExampleB;
use Tests\Chromabits\Nucleus\Testing\ExampleService\ExampleC;
use Tests\Chromabits\Nucleus\Testing\ExampleService\ExampleD;

/**
 * Class ImpersonatorTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Testing
 */
class ImpersonatorTest extends TestCase
{
    public function testMake()
    {
        $imp = new Impersonator();

        $this->assertTrue($imp->make(ExampleB::class) instanceof ExampleB);

        /** @var ExampleC $result */
        $result = $imp->make(ExampleC::class);

        $this->assertFalse($result->getOne() === $result->getTwo());

        $imp->provide(new ExampleA());
        /** @var ExampleC $result */
        $result = $imp->make(ExampleC::class);

        $this->assertTrue($result->getOne() !== $result->getTwo());

        $imp->provide(new ExampleA());
        $imp->provide(m::mock(ExampleAInterface::class));
        /** @var ExampleC $result */
        $result = $imp->make(ExampleC::class);

        $this->assertTrue($result->getOne() !== $result->getTwo());

        $imp->mock(ExampleA::class, function (MockInterface $mock) {
            $mock->shouldReceive('sayHello')->andReturn('Goodbye')->once();
        });
        /** @var ExampleC $result */
        $result = $imp->make(ExampleC::class);

        $this->assertTrue($result->getOne() === $result->getTwo());
        $this->assertEquals('Goodbye', $result->getTwo()->sayHello());
    }

    public function testMakeWithNoConstructor()
    {
        $imp = new Impersonator();

        $this->setExpectedException(LackOfCoffeeException::class);
        $imp->make(ExampleA::class);
    }

    public function testMakeWithResolutionIssue()
    {
        $imp = new Impersonator();

        $this->setExpectedException(ResolutionException::class);

        $imp->make(ExampleD::class);
    }

    public function testProvide()
    {
        $imp = new Impersonator();

        $instanceA = new ExampleA();
        $imp->provide($instanceA);

        /** @var ExampleB $instanceB */
        $instanceB = $imp->make(ExampleB::class);
        $this->assertEquals($instanceA, $instanceB->getExampleA());
    }

    public function testProvideWithString()
    {
        $imp = new Impersonator();

        $this->setExpectedException(LackOfCoffeeException::class);

        $imp->provide(ExampleA::class);
    }
}
