<?php

namespace App\Http\Controllers;

use App\Models\CounselorSchedule;
use App\Rules\Counselor;
use Illuminate\Http\Request;

class CounselorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = CounselorSchedule::all()->cursorPaginate(15);

        foreach($schedules as $schedule)
            $this->authorize('index', $schedule);

        return response()->json($schedules, 200);
    }

    /**
     * Display a listing of the resource related to counselor.
     *
     * @return \Illuminate\Http\Response
     */
    public function getScheduleOfCounselor($counselor_id)
    {
        $schedules = CounselorSchedule::where('counselor_id', $counselor_id)->get()->cursorPaginate(15);

        foreach($schedules as $schedule)
            $this->authorize('index', $schedule);
        
        return response()->json($schedules, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = CounselorSchedule::findOrFail($id);

        $this->authorize('show', $schedule);

        return response()->json($schedule, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = CounselorSchedule::findOrFail($id);

        $this->authorize('delete', $schedule);

        return response()->json(['message' => 'Schedule deleted.', 'schedule' => $schedule], 200);
    }
}
