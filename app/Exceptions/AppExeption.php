<?php

namespace App\Exceptions;

use App\Enums\STATUS;
use Exception;

class AppExeption extends Exception
{
    public $status = Status::FAIL;
}
