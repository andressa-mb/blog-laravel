<?php

namespace App\Http\Controllers\Api\Services;

use App\User;

class UserService {
    public function createUser(array $dataUser): User{
        $user = User::create([
                'name' => $dataUser['name'],
                'email' => $dataUser['email'],
                'password' => bcrypt($dataUser['password']),
                'lang' =>$request->lang ?? 'pt-BR',
            ]);

        $roleName = $dataUser['roles'] ?? 'reader';
        $user->getAndSetRole($roleName);

        return $user;
    }

    public function updateUser(array $dataUser, bool $existRoles, bool $userIsAdmin, int $id): User{
        $updateData = [];
        $userToEdit = User::find($id);

        if($existRoles){
            $allowedRoles = [];
            foreach($dataUser['roles'] as $role){
                if($role === "admin"){
                    if($userIsAdmin){
                        $allowedRoles[] = $role;
                    }
                }else {
                    $allowedRoles[] = $role;
                }
            }

            if(!empty($allowedRoles)){
                $userToEdit->syncRoles($allowedRoles);
            }
        }

        if(!empty($dataUser['name'])){
            $updateData['name'] = $dataUser['name'];
        }
        if(!empty($dataUser['email'])){
            $updateData['email'] = $dataUser['email'];
        }
        if(!empty($dataUser['password'])){
            $updateData['password'] = bcrypt($dataUser['password']);
        }
        if (!empty($updateData)) {
            $userToEdit->update($updateData);
        }

        return $userToEdit;
    }

}
