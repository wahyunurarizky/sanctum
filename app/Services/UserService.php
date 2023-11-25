<?php

namespace App\Services;

use App\Exceptions\AppExeption;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function getUsers()
    {
        $query = User::query();
        return $query->get();
    }

    public function getOne($filter = [])
    {
        $query = User::query();
        $query->where($filter);
        return $query->firstOrFail();
    }

    public function createOne($data)
    {
        $validator = Validator::make($data, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8'
        ]);

        //if validation fails
        if ($validator->fails()) {
            throw new AppExeption($validator->errors()->first(), 422);
        }

        //create user
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password'])
        ]);

        return $user;
    }

    public function updateById($data, $id)
    {
        $validator = Validator::make($data, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,' . $id,
            'password'  => 'required|min:8'
        ]);

        //if validation fails
        if ($validator->fails()) {
            throw new AppExeption($validator->errors()->first(), 422);
        }

        //create user
        $user = User::findOrFail($id);
        $user->update([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password'])
        ]);

        return $user;
    }

    public function deleteById($id)
    {
        //create user
        $user = User::findOrFail($id);
        $user->delete();

        return $user;
    }
}
