<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\View\Composite;

use SellerLabs\Nucleus\Testing\TestCase;
use SellerLabs\Nucleus\View\Common\Button;
use SellerLabs\Nucleus\View\Composite\IconButton;

/**
 * Class IconButtonTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\View\Composite
 */
class IconButtonTest extends TestCase
{
    public function testRender()
    {
        $output = '<button type="submit"><i class="icon fa-times"></i>Delete'
            .   '</button>';

        $this->assertEquals($output, (new IconButton('fa-times', 'Delete', [
            'type' => Button::TYPE_SUBMIT,
        ]))->render());
    }
}
