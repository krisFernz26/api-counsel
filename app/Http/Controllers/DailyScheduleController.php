<?php

namespace App\Http\Controllers;

use App\Models\DailySchedule;
use App\Models\User;
use App\Rules\Counselor;
use Illuminate\Http\Request;

class DailyScheduleController extends Controller
{
    public function index()
    {
        $dailySchedules = DailySchedule::orderBy('date', 'ASC')->orderBy('day', 'ASC')->orderBy('start_time', 'ASC')->cursorPaginate(15);

        foreach ($dailySchedules as $dailySchedule)
            $this->authorize('index', $dailySchedule);

        return response()->json($dailySchedules);
    }

    public function show($id)
    {
        $dailySchedule = DailySchedule::findOrFail($id);

        $this->authorize('show', $dailySchedule);

        return response()->json($dailySchedule);
    }

    public function getAllDailySchedulesOfCounselor($counselor_id)
    {
        $dailySchedules = User::findOrFail($counselor_id)->schedules()->cursorPaginate(15);

        foreach ($dailySchedules as $dailySchedule)
            $this->authorize('getAllDailySchedulesOfCounselor', $dailySchedule);

        return response($dailySchedules);
    }

    public function store(Request $request)
    {
        $request->validate([
            'counselor_id' => ['required', new Counselor],
            'date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:tomorrow'],
            'day' => 'required',
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $dailySchedule = new DailySchedule([
            'counselor_id' => $request->counselor_id,
            'date' => $request->date,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $this->authorize('store', $dailySchedule);

        return response()->json($dailySchedule);
    }

    public function update(Request $request, $id)
    {
        $dailySchedule = DailySchedule::findOrFail($id);

        $this->authorize('update', $dailySchedule);

        $dailySchedule->update([
            'date' => $request->date ?? $dailySchedule->date,
            'day' => $request->day ?? $dailySchedule->day,
            'start_time' => $request->start_time ?? $dailySchedule->start_time,
            'end_time' => $request->end_time ?? $dailySchedule->end_time,
        ]);

        return response()->json(['message' => 'Daily Schedule Updated.', 'daily_schedule' => $dailySchedule]);
    }

    public function destroy($id)
    {
        $dailySchedule = DailySchedule::findOrFail($id);

        $this->authorize('delete', $dailySchedule);

        $dailySchedule->delete();

        return response()->json(['message' => 'Daily Schedule deleted']);
    }
}
