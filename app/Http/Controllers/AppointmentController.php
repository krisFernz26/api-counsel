<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Rules\Counselor;
use App\Rules\Student;
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
        $appointments = Appointment::orderBy('date', 'DESC')->orderBy('start_time', 'DESC')->get();

        foreach ($appointments as $appointment)
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

        foreach ($appointments as $appointment)
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
            'student_id' => ['required', new Student],
            'counselor_id' => ['required', new Counselor],
            'link' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i'
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
        $appointment = Appointment::findOrFail($id);

        $this->authorize('show', $appointment);

        return response()->json($appointment, 200);
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
        $appointment = Appointment::findOrFail($id);

        $this->authorize('update', $appointment);

        $appointment->update([
            'link' => $request->link ?? $appointment->link,
            'date' => $request->date ?? $appointment->date,
            'start_time' => $request->start_time ?? $appointment->start_time,
            'end_time' => $request->end_time ?? $appointment->end_time
        ]);

        return response()->json($appointment, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->authorize('delete', $appointment);

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted.'], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $appointment = Appointment::withTrashed()->findOrFail($id);

        $this->authorize('restore', $appointment);

        $appointment->restore();

        return response()->json(['message' => 'Appointment restored.', 'appointment' => $appointment], 200);
    }

    /**
     * Update the status of the specified resource from storage to "In progress".
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function start($id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->authorize('start', $appointment);

        $appointment->update([
            'appointment_status_id' => 2,
        ]);

        return response()->json(['message' => 'Appointment started.', 'appointment' => $appointment], 200);
    }

    /**
     * Update the status of the specified resource from storage to "Done".
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->authorize('complete', $appointment);

        $appointment->update([
            'appointment_status_id' => 3,
        ]);

        return response()->json(['message' => 'Appointment completed.', 'appointment' => $appointment], 200);
    }

    /**
     * Update the status of the specified resource from storage to "Done".
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->authorize('cancel', $appointment);

        $appointment->update([
            'appointment_status_id' => 4,
        ]);

        return response()->json(['message' => 'Appointment cancelled.', 'appointment' => $appointment], 200);
    }
}
