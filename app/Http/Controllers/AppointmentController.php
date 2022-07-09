<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $appointments = Appointment::orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->cursorPaginate(15);
        $appointments = Appointment::orderBy('date', 'DESC')->orderBy('start_time', 'DESC')->cursorPaginate(15);

        foreach($appointments as $appointment)
            $this->authorize('index', $appointment);
        
        return response($appointments, 200);
    }

    /**
     * Display a listing of the resource according to user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllAppointmentsOfUser($id)
    {
        // $appointments = Appointment::orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->cursorPaginate(15);
        $appointments = Appointment::where('counselor_id', $id)->orWhere('student_id', $id)->orderBy('date', 'DESC')->orderBy('start_time', 'DESC')->cursorPaginate(15);

        foreach($appointments as $appointment)
            $this->authorize('index', $appointment);
        
        return response($appointments, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'link' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time'=> 'nullable|date_format:H:i'
        ]);

        $student = User::findOrFail($request->student_id);
        if(!$student->isStudent())
        {
            return response()->json(['message' => 'User with ID '.$request->student_id.' is not a student!'], 500);
        }

        $appointment = new Appointment([
            'appointment_status_id' => 1,
            'student_id' => $request->student_id,
            'counselor_id' => auth()->user()->id,
            'link' => $request->link,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time ?? null,
        ]);

        $this->authorize('store', $appointment);

        $appointment->save();

        return response($appointment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
