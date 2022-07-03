<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
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

    public function index(User $user, Note $note)
    {
         return $user->checkRole(0) || ($user->checkRole(2) && $note->counselor_id === $user->id); 
    }

    public function show(User $user, Note $note)
    {
         return $user->checkRole(0) || ($user->checkRole(2) && $note->counselor_id === $user->id); 
    }

    public function store(User $user, Note $note)
    {
        return $user->checkRole(0) || $user->checkRole(2);
    }

    public function update(User $user, Note $note)
    {
        return $user->checkRole(0) || ($user->checkRole(2) && $note->counselor_id === $user->id);
    }

    public function delete(User $user, Note $note)
    {
        return $user->checkRole(0) 
                || ($user->checkRole(2) && $note->counselor_id === $user->id) 
                || ($user->checkRole(1) && $note->counselor->institution_id === $user->institution_id);
    }
}
