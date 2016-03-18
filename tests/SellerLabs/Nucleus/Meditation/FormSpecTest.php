<?php

namespace Tests\SellerLabs\Nucleus\Meditation;

use SellerLabs\Nucleus\Control\Maybe;
use SellerLabs\Nucleus\Meditation\FormSpec;
use SellerLabs\Nucleus\Testing\TestCase;

/**
 * Class FormSpecTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Meditation
 */
class FormSpecTest extends TestCase
{
    public function testSetFieldLabel()
    {
        $spec = (new FormSpec());

        $this->assertTrue($spec->getFieldLabel('wow')->isNothing());

        $final = $spec->withFieldLabel('wow', 'WOWs');

        $this->assertNotSame($spec, $final);
        $this->assertTrue($final->getFieldLabel('wow')->isJust());
        $this->assertEquals(
            'WOWs',
            Maybe::fromJust($final->getFieldLabel('wow'))
        );

        $this->assertEquals(
            ['wow' => 'WOWs'],
            $final->getLabels()->toArray()
        );
    }

    public function testSetFieldDescription()
    {
        $spec = (new FormSpec());

        $this->assertTrue($spec->getFieldDescription('wow')->isNothing());

        $final = $spec->withFieldDescription('wow', 'WOWs');

        $this->assertNotSame($spec, $final);
        $this->assertTrue($final->getFieldDescription('wow')->isJust());
        $this->assertEquals(
            'WOWs',
            Maybe::fromJust($final->getFieldDescription('wow'))
        );

        $this->assertEquals(
            ['wow' => 'WOWs'],
            $final->getDescriptions()->toArray()
        );
    }
}
