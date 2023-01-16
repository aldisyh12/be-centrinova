<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository extends CrudRepository
{

    public function model()
    {
        return User::class;
    }
}
