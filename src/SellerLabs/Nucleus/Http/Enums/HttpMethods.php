<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\Http\Enums;

use SellerLabs\Nucleus\Foundation\Enum;

/**
 * Class HttpMethods.
 *
 * For more information reference RFC 2616.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Http\Enums
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
