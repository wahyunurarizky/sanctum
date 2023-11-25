<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AppExeption;
use App\Http\Controllers\Controller;
use App\Http\Response\SuccessResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the login request.
     */
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            throw new AppExeption($validator->errors()->first(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        //if auth failed
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            throw new AppExeption('Email or password incorrect', 401);
        }

        //if auth success
        return SuccessResponse::send([
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ]);
    }
}
