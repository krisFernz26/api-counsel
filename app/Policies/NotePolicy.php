<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function index(User $user, Note $note)
    {
        return $user->isAdmin() || ($user->isCounselor() && $note->counselor_id === $user->id);
    }

    public function getAllNotesOnStudent(User $user, Note $note)
    {
         return $user->isAdmin() || ($user->isInstitution() && $note->student->institution_id == $user->institution_id);
    }

    public function getAllNotesOfCounselor(User $user, Note $note)
    {
         return $user->isAdmin() || ($user->isInstitution() && $note->counselor->institution_id == $user->institution_id) || ($user->isCounselor() && $note->counselor_id === $user->id);
    }

    public function getNotesOfCounselorOnStudent(User $user, Note $note)
    {
         return $user->isAdmin() || ($user->isInstitution() && $note->student->institution_id == $user->institution_id && $note->counselor->institution_id == $user->institution_id) || ($user->isCounselor() && $note->counselor_id === $user->id);

    }
    public function show(User $user, Note $note)
    {
        // dd($note);
        return $user->isAdmin() || ($user->isCounselor() && $note->counselor_id === $user->id);
    }

    public function store(User $user, Note $note)
    {
        return $user->isAdmin() || $user->isCounselor();
    }

    public function update(User $user, Note $note)
    {
        return $user->isAdmin() || ($user->isCounselor() && $note->counselor_id === $user->id);
    }

    public function delete(User $user, Note $note)
    {
        return $user->isAdmin() 
                || ($user->isCounselor() && $note->counselor_id === $user->id) 
                || ($user->isInstitution() && $note->counselor->institution_id === $user->institution_id);
    }
}
