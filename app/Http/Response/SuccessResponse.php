<?php

namespace App\Http\Response;

use App\Enums\Status;

class SuccessResponse
{
    public static function send($data, $status = 200)
    {
        return response()->json([
            'status' => Status::SUCCESS,
            'data' => $data
        ], $status);
    }
}
