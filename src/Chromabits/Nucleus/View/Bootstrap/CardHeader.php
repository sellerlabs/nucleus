<?php

namespace Chromabits\Nucleus\View\Bootstrap;

use Chromabits\Nucleus\View\Common\Div;

/**
 * Class CardHeader
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Bootstrap
 */
class CardHeader extends Div
{
    /**
     * @return array
     */
    public function getDefaultAttributes()
    {
        return ['class' => 'card-header'];
    }
}