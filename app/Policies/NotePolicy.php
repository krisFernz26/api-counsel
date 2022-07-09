<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * Get all notes 
     * 
     * @param User $user
     * @param Note $note
     */
    public function index(User $user, Note $note)
    {
        return $user->isAdmin() 
            || ($user->isCounselor() && $note->counselor_id === $user->id);
    }

    /**
     * Get all notes of student (from all sources)
     * 
     * @param User $user
     * @param Note $note
     */
    public function getAllNotesOnStudent(User $user, Note $note)
    {
        return $user->isAdmin() 
            // user's institution is the same as the note student's id
           || ($user->isInstitution() && $note->student->institution_id == $user->institution_id);
    }

    /**
     * Get all notes made by current authenticated counselor 
     * 
     * @param User $user
     * @param Note $note
     */
    public function getAllNotesOfCounselor(User $user, Note $note)
    {
        return $user->isAdmin() 
            // user's institution is the same as the note counselor's id
            || ($user->isInstitution() && $note->counselor->institution_id == $user->institution_id) 
            // note's counselor_id is the same as the user's id
            || ($user->isCounselor() && $note->counselor_id === $user->id);
    }

    /**
     * Get all notes written by currently authenticated counselor on specific student 
     * 
     * @param User $user
     * @param Note $note
     */
    public function getNotesOfCounselorOnStudent(User $user, Note $note)
    {
        return $user->isAdmin() 
            // user's institution is the same as student's or counselor's instititution
            || ($user->isInstitution() && ($note->student->institution_id == $user->institution_id || $note->counselor->institution_id == $user->institution_id)) 
            // note's counselor_id is the same as the user's id
            || ($user->isCounselor() && $note->counselor_id === $user->id);

    }

    /**
     * Get a note 
     * 
     * @param User $user
     * @param Note $note
     */
    public function show(User $user, Note $note)
    {
        // dd($note);
        return $user->isAdmin() 
            // note's counselor_id is the same as the user's id
            || ($user->isCounselor() && $note->counselor_id === $user->id);
    }

    /**
     * Store a note 
     * 
     * @param User $user
     * @param Note $note
     */
    public function store(User $user, Note $note)
    {
        return $user->isAdmin() 
            || $user->isCounselor();
    }

    /**
     * Update a note 
     * 
     * @param User $user
     * @param Note $note
     */
    public function update(User $user, Note $note)
    {
        return $user->isAdmin() 
            // note's counselor_id is the same as the user's id
            || ($user->isCounselor() && $note->counselor_id === $user->id);
    }

    /**
     * Delete a note 
     * 
     * @param User $user
     * @param Note $note
     */
    public function delete(User $user, Note $note)
    {
        return $user->isAdmin() 
            // note's counselor_id is the same as the user's id
            || ($user->isCounselor() && $note->counselor_id === $user->id) 
            || ($user->isInstitution() && $note->counselor->institution_id === $user->institution_id);
    }
}
