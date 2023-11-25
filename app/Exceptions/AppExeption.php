<?php

namespace App\Exceptions;

use App\Enums\Status;
use Exception;

class AppExeption extends Exception
{
    public $status = Status::FAIL;
}
