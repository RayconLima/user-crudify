<?php

namespace App\Exceptions;

use App\Exceptions\Traits\RenderToJson;
use Exception;

class ResetPasswordTokenInvalidException extends Exception
{
    use RenderToJson;
    
    protected $message = 'Password Reset Token Invalid.';
    protected $code = 400;
}
