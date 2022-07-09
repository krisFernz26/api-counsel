<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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
        $appointments = Appointment::orderBy('created_at', 'DESC')->cursorPaginate(15);

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
            'counselor_id' => 'required',
            'link' => 'required',
            'date' => 'required|date',
            'start_time' => 'required|date',
            'end_time'=> 'nullable|date_format:H:i'
        ]);

        $appointment = new Appointment([
            'appointment_status_id' => 1,
            'student_id' => $request->student_id,
            'counselor_id' => $request->counselor_id,
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
        //
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
