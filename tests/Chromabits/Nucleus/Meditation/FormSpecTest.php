<?php

namespace Tests\Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Meditation\FormSpec;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class FormSpecTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation
 */
class FormSpecTest extends TestCase
{
    public function testSetFieldLabel()
    {
        $spec = (new FormSpec());

        $this->assertTrue($spec->getFieldLabel('wow')->isNothing());

        $final = $spec->setFieldLabel('wow', 'WOWs');

        $this->assertNotSame($spec, $final);
        $this->assertTrue($final->getFieldLabel('wow')->isJust());
        $this->assertEquals(
            'WOWs',
            Maybe::fromJust($final->getFieldLabel('wow'))
        );
    }

    public function testSetFieldDescription()
    {
        $spec = (new FormSpec());

        $this->assertTrue($spec->getFieldDescription('wow')->isNothing());

        $final = $spec->setFieldDescription('wow', 'WOWs');

        $this->assertNotSame($spec, $final);
        $this->assertTrue($final->getFieldDescription('wow')->isJust());
        $this->assertEquals(
            'WOWs',
            Maybe::fromJust($final->getFieldDescription('wow'))
        );
    }
}
