<?php

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use App\Exceptions\AppExeption;
use App\Http\Controllers\Controller;
use App\Http\Response\SuccessResponse;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getUsers();
        return SuccessResponse::send([
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $this->userService->createOne($request->all());

        return SuccessResponse::send([
            'user'    => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->getOne(['id' => $id]);
        return SuccessResponse::send([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $this->userService->updateById($request->all(), $id);
        return SuccessResponse::send([
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->userService->deleteById($id);
        return SuccessResponse::send([
            'user' => $user
        ]);
    }

    /**
     * get me.
     */
    public function getMe()
    {
        $user = $this->userService->getOne(['id' => Auth::id()]);
        return SuccessResponse::send([
            'user' => $user
        ]);
    }
}
