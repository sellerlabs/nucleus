<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View\Common;

use Chromabits\Nucleus\Meditation\Constraints\InArrayConstraint;
use Chromabits\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Meditation\Spec;
use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Node;

/**
 * Class Button.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Common
 */
class Button extends Node
{
    const TYPE_SUBMIT = 'submit';
    const TYPE_RESET = 'reset';
    const TYPE_BUTTON = 'button';

    /**
     * Construct an instance of a Button.
     *
     * @param string[] $attributes
     * @param string|RenderableInterface|string[]|RenderableInterface[] $content
     */
    public function __construct($attributes, $content = '')
    {
        parent::__construct('button', $attributes, $content);

        $this->spec = new Spec([
            'autofocus'
            => new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY),
            'autocomplete'
            => new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY),
            'disabled'
            => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_BOOLEAN),
            'form' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
            'name' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
            'type' => new InArrayConstraint([
                static::TYPE_SUBMIT,
                static::TYPE_BUTTON,
                static::TYPE_RESET,
            ]),
            'value' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
        ]);
    }
}
