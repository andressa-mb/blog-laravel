<?php

namespace App\Http\Controllers\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait ValidatorUser{
    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array', Rule::in(['admin', 'author', 'reader'])],
        ]);
    }

    protected function updateValidator(array $data, $id)
    {
        return Validator::make($data, [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array', Rule::in(['admin', 'author', 'reader'])],
        ]);
    }

}
