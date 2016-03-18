<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\View\Common;

use SellerLabs\Nucleus\Testing\TestCase;
use SellerLabs\Nucleus\View\Common\Button;
use SellerLabs\Nucleus\View\Exceptions\InvalidAttributesException;
use stdClass;

/**
 * Class ButtonTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\View\Common
 */
class ButtonTest extends TestCase
{
    public function testRender()
    {
        $this->assertEqualsMatrix([
            ['<button type="submit"></button>', (new Button([
                'type' => Button::TYPE_SUBMIT,
            ]))->render()],
            ['<button type="submit">Save post</button>', (new Button([
                'type' => Button::TYPE_SUBMIT,
            ], 'Save post'))->render()],
            ['<button type="submit" class="active"></button>', (new Button([
                'type' => Button::TYPE_SUBMIT,
                'class' => 'active',
            ]))->render()],
        ]);
    }

    public function testRenderWithInvalid()
    {
        $this->setExpectedException(InvalidAttributesException::class);

        (new Button([
            'type' => 'no way',
            'name' => new stdClass(),
        ]))->render();
    }
}
