<?php

namespace App\Repositories\Eloquent;

use App\Models\User;

class UserRepository extends BaseRepository
{
    // Injeta o Model do Usuário no pai (BaseRepository)
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
