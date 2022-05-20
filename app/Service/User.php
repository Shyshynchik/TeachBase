<?php

namespace App\Service;

use App\Models\Role;
use App\Models\User as UserModel;
use Illuminate\Database\QueryException;

class User implements UserInterface
{

    /**
     * @throws QueryException
     */
    public function createUser(string $name, string $email, string $password): void
    {
        $user = UserModel::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $role = Role::firstOrCreate(
            ['code' => '2'],
            ['name' => 'Администратор']
        );
        $user->roles()->save($role);
    }

    public function getUser(string $email): ?UserModel
    {
        return UserModel::where('email', $email)->first();
    }

    public function checkUser(UserModel $user): bool
    {
        $searchUser = UserModel::where('id', $user->id)
            ->where('email', $user->email)
            ->where('token', $user->token)
            ->first();

        return isset($searchUser);
    }

    public function getUserByToken(string $token): ?UserModel
    {
        return UserModel::where('token', $token)->first();

    }

}