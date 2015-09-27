<?php

namespace Chromabits\Nucleus\View\Bootstrap;

use Chromabits\Nucleus\View\Common\Div;

/**
 * Class Card
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Bootstrap
 */
class Card extends Div
{
    /**
     * @return array
     */
    public function getDefaultAttributes()
    {
        return ['class' => 'card'];
    }
}