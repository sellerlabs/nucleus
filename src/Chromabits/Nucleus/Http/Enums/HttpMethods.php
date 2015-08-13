<?php

namespace Chromabits\Nucleus\Http\Enums;

use Chromabits\Nucleus\Support\Enum;

/**
 * Class HttpMethods
 *
 * For more information reference RFC 2616.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Http\Enums
 */
class HttpMethods extends Enum
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const OPTIONS = 'OPTIONS';
    const HEAD = 'HEAD';
    const DELETE = 'DELETE';
    const TRACE = 'TRACE';
    const CONNECT = 'CONNECT';
}
