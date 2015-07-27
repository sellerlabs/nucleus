<?php

namespace Chromabits\Nucleus\Views;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Views\Interfaces\Renderable;

/**
 * Class Node
 *
 * WIP
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Views
 */
class Node
{
    protected $tagName = null;

    protected $attributes = [];

    protected $selfClosing = false;

    protected $content;

    /**
     * Construct an instance of a Node.
     *
     * @param string $tagName
     * @param string[] $attributes
     * @param string|Renderable $content
     * @param bool $selfClosing
     */
    public function __construct(
        $tagName,
        $attributes,
        $content,
        $selfClosing = false
    ) {
        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->content = $content;
        $this->selfClosing = $selfClosing;
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

        return sprintf('%s="%s"', [
            $name,
            nucleus_escape_html((string) $value)
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
        }, $this->attributes, array_keys($this->attributes)));
    }

    /**
     * Render the content of the tag.
     *
     * @return string
     * @throws CoreException
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

                throw new CoreException(
                    'Unknown content type. Child item cannot be rendered.'
                );
            }, $this->content));
        }

        throw new CoreException(
            'Unknown content type. Node cannot be rendered.'
        );
    }

    /**
     * Render the Node.
     *
     * @return string
     */
    protected function render()
    {
        if ($this->selfClosing) {
            return sprintf(
                '<%s%s/>',
                [$this->tagName, $this->renderAttributes()]
            );
        }

        return sprintf(
            '<%s%s>%s</%s>',
            [
                $this->tagName,
                $this->renderAttributes(),
                $this->renderContent(),
                $this->tagName
            ]
        );
    }
}
