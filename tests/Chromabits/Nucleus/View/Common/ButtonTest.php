<?php

namespace Tests\Chromabits\Nucleus\View\Common;

use Chromabits\Nucleus\Testing\TestCase;
use Chromabits\Nucleus\View\Common\Button;
use Chromabits\Nucleus\View\Exceptions\InvalidAttributesException;
use stdClass;

/**
 * Class ButtonTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\View\Common
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
            ]))->render()]
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
