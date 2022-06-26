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
    public function index($id)
    {
        $user = User::findOrFail($id);
        
        $notes = $user->studentNotes()->cursorPaginate(15);

        $this->authorize('index', $notes);

        $notes->load('counselor', 'student');

        return response()->json($notes);
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
            'student' => 'required',
            'counselor' => 'required',
            'subject' => 'nullable',
            'body' => 'required'
        ]);

        $note = new Note([
            'student_id' => $request->student->id,
            'counselor_id' => $request->counselor->id,
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
