<?php

namespace App\Http\Controllers;

use App\Models\DailySchedule;
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
}
