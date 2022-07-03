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
        $user = auth()->user();

        if($user->checkRole(3)) {
            $appointments = $user->studentAppointments()->cursorPaginate(15);
        } elseif ($user->checkRole(1)) {
            $appointments = $user->counselorAppointments()->cursorPaginate(15);
        } elseif ($user->checkRole(0)) {
            $appointments = Appointment::orderBy('created_at', 'DESC')->cursorPaginate(15);
        } else {
            abort(403);
        }

        $this->authorize('index', $appointments);
        
        // $appointments = Appointment::where('student_id', '=', $user->id)->orWhere('counselor_id', '=', $user->id)->cursorPaginate(15);

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
