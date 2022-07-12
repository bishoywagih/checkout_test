<?php

namespace App\Models;

use App\Core\App;
use PDO;

class User extends Model
{
    protected string $table = 'users';

    public function clearUserToken($id)
    {
        $user = $this->find([
            'id' => $id
        ]);
        $user->update([
            'remember_identifier' => null,
            'remember_token' => null,
        ]);
    }
}
