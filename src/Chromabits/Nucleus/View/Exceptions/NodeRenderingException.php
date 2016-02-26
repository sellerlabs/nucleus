<?php

namespace Chromabits\Nucleus\View\Exceptions;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\TypeHound;
use Exception;

/**
 * Class NodeRenderingException
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Exceptions
 */
class NodeRenderingException extends CoreException
{
    /**
     * @var mixed
     */
    protected $content;

    /**
     * Construct an instance of a NodeRenderingException.
     *
     * @param mixed $content
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($content, $code = 0, Exception $previous = null)
    {
        parent::__construct(
            vsprintf(
                'Unknown content type: %s. Node cannot be rendered.',
                [
                    TypeHound::fetch($content),
                ]
            ),
            $code,
            $previous
        );

        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}
