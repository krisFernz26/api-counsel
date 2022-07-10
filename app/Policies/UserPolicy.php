<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function show(User $currentUser, User $user)
    {
        // dd($currentUser);
        return $currentUser->id === $user->id || $currentUser->isAdmin();
    }

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id || $currentUser->isAdmin();
    }
    
    public function delete(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id || $currentUser->isAdmin();
    }
}
