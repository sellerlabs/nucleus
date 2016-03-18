<?php

namespace SellerLabs\Nucleus\View\Exceptions;

use SellerLabs\Nucleus\Meditation\TypeHound;
use Exception;

/**
 * Class NodeChildRenderingException
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Exceptions
 */
class NodeChildRenderingException extends NodeRenderingException
{
    /**
     * Construct an instance of a NodeChildRenderingException.
     *
     * @param mixed $content
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($content, $code = 0, Exception $previous = null)
    {
        parent::__construct(
            vsprintf(
                'Unknown child content type: %s. '
                . 'Node child item cannot be rendered.',
                [
                    TypeHound::fetch($content),
                ]
            ),
            $code,
            $previous
        );

        $this->content = $content;
    }
}
