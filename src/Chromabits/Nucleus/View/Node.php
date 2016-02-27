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

use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Data\ArrayMap;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Foundation\Interfaces\ArrayableInterface;
use Chromabits\Nucleus\Meditation\Spec;
use Chromabits\Nucleus\Support\Html;
use Chromabits\Nucleus\View\Exceptions\InvalidAttributesException;
use Chromabits\Nucleus\View\Exceptions\NodeChildRenderingException;
use Chromabits\Nucleus\View\Exceptions\NodeRenderingException;
use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Interfaces\SafeHtmlProducerInterface;

/**
 * Class Node.
 *
 * A renderable HTML node.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View
 */
class Node extends BaseObject implements
    RenderableInterface,
    SafeHtmlProducerInterface
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
     * @var RenderableInterface|RenderableInterface[]|string|string[]
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
     * @param string|RenderableInterface|string[]|RenderableInterface[] $content
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
        $this->attributes = array_merge(
            $this->getDefaultAttributes(),
            $attributes
        );
        $this->content = $content;
        $this->selfClosing = $selfClosing;

        $this->spec = new Spec();
    }

    /**
     * Get the default attributes for this node.
     *
     * Usually basic nodes such as <a> won't have any defaults. However, if
     * you are using a CSS framework, it might be useful to have default classes
     * on more complex classes.
     *
     * Example: On Bootstrap, Tables need to have `class='table'`. Instead of
     * writing new Table(['class' => 'table'], [...]), we can extend the Table
     * class and override the `getDefaultAttributes` to return
     * `['class' => 'table']`
     *
     * @return string[]
     */
    public function getDefaultAttributes()
    {
        return [];
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

        if (is_array($value)) {
            $value = implode(' ', $value);
        }

        return vsprintf('%s="%s"', [
            $name,
            Html::escape((string) $value),
        ]);
    }

    /**
     * Render the attributes part of the opening tag.
     *
     * @return string
     */
    protected function renderAttributes()
    {
        return ArrayMap::of($this->attributes)
            ->map(function ($value, $name) {
                return $this->renderAttribute($name, $value);
            })
            ->join(' ');
    }

    /**
     * Render the content of the tag.
     *
     * @throws CoreException
     * @return string
     */
    protected function renderContent()
    {
        if (is_string($this->content)
            || $this->content instanceof SafeHtmlWrapper
            || $this->content instanceof SafeHtmlProducerInterface
        ) {
            return Html::escape($this->content);
        } elseif ($this->content instanceof RenderableInterface) {
            return Html::escape($this->content->render());
        } elseif (is_array($this->content)
            || $this->content instanceof ArrayableInterface
        ) {
            return ArrayList::of($this->content)
                ->map(function ($child) {
                    if (is_string($child)
                        || $child instanceof SafeHtmlWrapper
                        || $child instanceof SafeHtmlProducerInterface
                    ) {
                        return Html::escape($child);
                    } elseif ($child instanceof RenderableInterface) {
                        return Html::escape($child->render());
                    }

                    throw new NodeChildRenderingException($child);
                })
                ->join();
        }

        throw new NodeRenderingException($this->content);
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

        $attributes = $this->renderAttributes();
        if (strlen($attributes)) {
            $attributes = ' ' . $attributes;
        }

        if ($this->selfClosing) {
            return vsprintf(
                '<%s%s/>',
                [$this->tagName, $attributes]
            );
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

    /**
     * Get a safe HTML version of the contents of this object.
     *
     * @return SafeHtmlWrapper
     */
    public function getSafeHtml()
    {
        return new SafeHtmlWrapper($this->render());
    }
}
