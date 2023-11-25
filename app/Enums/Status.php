<?php

namespace App\Enums;

enum STATUS: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case FAIL = 'failed';
}
