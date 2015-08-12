<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Spec;
use Chromabits\Nucleus\Meditation\TypeHound;
use Chromabits\Nucleus\View\Exceptions\InvalidAttributesException;
use Chromabits\Nucleus\View\Interfaces\Renderable;

/**
 * Class Node.
 *
 * WIP
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View
 */
class Node extends BaseObject implements Renderable
{
    /**
     * @var null|string
     */
    protected $tagName = null;

    /**
     * @var string[]
     */
    protected $attributes = [];

    /**
     * @var bool
     */
    protected $selfClosing = false;

    /**
     * @var Renderable|Interfaces\Renderable[]|string|\string[]
     */
    protected $content;

    /**
     * @var Spec
     */
    protected $spec;

    /**
     * Construct an instance of a Node.
     *
     * @param string $tagName
     * @param string[] $attributes
     * @param string|Renderable|string[]|Renderable[] $content
     * @param bool $selfClosing
     */
    public function __construct(
        $tagName,
        $attributes,
        $content,
        $selfClosing = false
    ) {
        parent::__construct();

        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->content = $content;
        $this->selfClosing = $selfClosing;

        $this->spec = new Spec();
    }

    /**
     * Render a single attribute in a node.
     *
     * @param string $name
     * @param null|string $value
     *
     * @return string
     */
    protected function renderAttribute($name, $value = null)
    {
        if ($value === null) {
            return $name;
        }

        return vsprintf('%s="%s"', [
            $name,
            nucleus_escape_html((string) $value),
        ]);
    }

    /**
     * Render the attributes part of the opening tag.
     *
     * @return string
     */
    protected function renderAttributes()
    {
        return implode(' ', array_map(function ($name, $value) {
            return $this->renderAttribute($name, $value);
        }, array_keys($this->attributes), $this->attributes));
    }

    /**
     * Render the content of the tag.
     *
     * @throws CoreException
     * @return string
     */
    protected function renderContent()
    {
        if (is_string($this->content)) {
            return nucleus_escape_html($this->content);
        } elseif ($this->content instanceof Renderable) {
            return $this->content->render();
        } elseif (is_array($this->content)) {
            return implode('', array_map(function ($child) {
                if (is_string($child)) {
                    return nucleus_escape_html($child);
                } elseif ($child instanceof Renderable) {
                    return $child->render();
                }

                throw new CoreException(vsprintf(
                    'Unknown content type: %s. Child item cannot be rendered.',
                    [
                        TypeHound::fetch($child),
                    ]
                ));
            }, $this->content));
        }

        throw new CoreException(vsprintf(
            'Unknown content type: %s. Node cannot be rendered.',
            [
                TypeHound::fetch($this->content),
            ]
        ));
    }

    /**
     * Render the Node.
     *
     * @throws CoreException
     * @throws InvalidAttributesException
     * @return string
     */
    public function render()
    {
        $result = $this->spec->check($this->attributes);
        if ($result->failed()) {
            throw new InvalidAttributesException($result);
        }

        if ($this->selfClosing) {
            return vsprintf(
                '<%s%s/>',
                [$this->tagName, $this->renderAttributes()]
            );
        }

        $attributes = $this->renderAttributes();
        if (strlen($attributes)) {
            $attributes = ' ' . $attributes;
        }

        return vsprintf(
            '<%s%s>%s</%s>',
            [
                $this->tagName,
                $attributes,
                $this->renderContent(),
                $this->tagName,
            ]
        );
    }
}
