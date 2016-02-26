<?php

namespace Chromabits\Nucleus\View;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Support\Html;
use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Interfaces\SafeHtmlProducerInterface;

/**
 * Class BaseHtmlRenderable
 *
 * A base renderable class containing a basic implementation of getBaseHtml.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View
 */
abstract class BaseHtmlRenderable extends BaseObject implements
    RenderableInterface,
    SafeHtmlProducerInterface
{
    /**
     * Get a safe HTML version of the contents of this object.
     *
     * @return SafeHtmlWrapper
     */
    public function getSafeHtml()
    {
        $result = $this->render();

        return Html::safe(Html::escape($result));
    }
}
