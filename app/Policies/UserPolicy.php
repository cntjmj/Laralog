<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function before($user, $ability) {
        if ($user->is_admin())
            return true;
    }
    
    public function update(User $user, User $profile) {
        return $user->id === $profile->id;
    }
}
