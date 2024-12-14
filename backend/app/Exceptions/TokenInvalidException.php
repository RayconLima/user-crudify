<?php

namespace App\Exceptions;

use App\Exceptions\Traits\RenderToJson;
use Exception;

class TokenInvalidException extends Exception
{
    use RenderToJson;
    
    protected $message = 'Token Invalid.';
    protected $code = 400;
}