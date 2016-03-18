<?php

namespace SellerLabs\Nucleus\View;

use SellerLabs\Nucleus\Foundation\BaseObject;
use SellerLabs\Nucleus\Support\Html;
use SellerLabs\Nucleus\View\Interfaces\RenderableInterface;
use SellerLabs\Nucleus\View\Interfaces\SafeHtmlProducerInterface;

/**
 * Class BaseHtmlRenderable
 *
 * A base renderable class containing a basic implementation of getBaseHtml.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View
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
