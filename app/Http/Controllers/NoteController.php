<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = auth()->user();
        // dd($user);
        $notes = Note::orderBy('created_at', 'DESC')->cursorPaginate(15);

        foreach($notes as $note)
            $this->authorize('index', $note);

        $notes->load('counselor', 'student');

        return response()->json($notes);
    }

    public function getAllNotesOnStudent($student_id)
    {
        // $user = auth()->user();
        // dd($user);
        $notes = Note::where('student_id', $student_id)->orderBy('created_at', 'DESC')->cursorPaginate(15);
        
        $notes->load('counselor');
        
        foreach($notes as $note)
            $this->authorize('getAllNotesOnStudent', $note);

        $student = User::findOrFail($student_id);

        return response()->json(['student' => $student, 'notes_pagination' => $notes]);
    }

    public function getAllNotesOfCounselor($counselor_id)
    {
        $notes = Note::where('counselor_id', $counselor_id)->orderBy('created_at', 'DESC')->cursorPaginate(15);
            
        $notes->load('student');

        foreach($notes as $note)
            $this->authorize('getAllNotesOfCounselor', $note);

        $counselor = User::findOrFail($counselor_id);

        return response()->json(['counselor' => $counselor, 'notes_pagination' => $notes]);
    }

    public function getNotesOfCounselorOnStudent($counselor_id, $student_id)
    {
        $notes = Note::where('student_id', $student_id)->where('counselor_id', $counselor_id)->orderBy('updated_at', 'DESC')->cursorPaginate(15);

        foreach($notes as $note)
            $this->authorize('getNotesOfCounselorOnStudent', $note);

        $student = User::findOrFail($student_id);
        $counselor = User::findOrFail($counselor_id);

        return response()->json(['student' => $student, 'counselor' => $counselor, 'notes_pagination' => $notes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required',
            'subject' => 'nullable',
            'body' => 'required'
        ]);

        $note = new Note([
            'student_id' => $request->student_id,
            'counselor_id' => auth()->user()->id,
            'subject' => strip_tags($request->subject) ?? '',
            'body' => strip_tags($request->body)
        ]);

        $this->authorize('store', $note);

        $note->save();
        
        $note->load('counselor', 'student');

        return response()->json($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::findOrFail($id);

        $this->authorize('show', $note);

        $note->load('counselor', 'student');

        return response()->json($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        $this->authorize('update', $note);

        $note->update($request->all());

        $note->load('counselor', 'student');

        return response()->json($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);

        $this->authorize('delete', $note);

        $note->delete();

        return response()->json('Note deleted');
    }
}
