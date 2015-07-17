<?php

namespace Chromabits\Nucleus\Exceptions;

use Exception;

/**
 * Class CoreException
 *
 * A base exception class.
 *
 * Its whole purpose is to make IDE UX nicer. CoreException will usually show
 * up before other classes faster on auto-completion lists, which is much better
 * than having to dig up through multiple "Exception" classes in different
 * namespaces.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Exceptions
 */
class CoreException extends Exception
{
    // Nothing to see here.
}
