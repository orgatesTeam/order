<?php

namespace App\Http\Controllers\Super\Api;

use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function list()
    {
        $users = User::paginate(15);
        return responseSuccess(compact('users'));
    }

    public function checkValueExist()
    {
        $checkColumnTypes = ['name', 'email'];
        $column = request('column');
        $value = request('value');
        $id = request('id');
        if (in_array($column, $checkColumnTypes)) {
            $exist = User::where('id', '<>', $id)->where($column, $value)->first() ? true : false;
            return responseSuccess(['exist' => $exist]);
        }

        return responseFail();
    }

    public function store()
    {
        if ($this->isUpdateRequest()) {
            return $this->update();
        }

        return $this->create();
    }

    protected function isUpdateRequest()
    {
        return request()->exists('id');
    }

    protected function create()
    {
        $input = request()->only(['email', 'name', 'enable', 'password']);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        return responseSuccess($user);
    }

    protected function update()
    {
        $input = request()->only(['email', 'name', 'id', 'enable']);
        $user = User::find($input['id']);

        if (!$user) {
            return responseFail();
        }

        $user->email = $input['email'];
        $user->name = $input['name'];
        $user->enable = $input['enable'];
        $user->save();

        return responseSuccess($user);
    }
}