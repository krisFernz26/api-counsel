<?php

namespace App\Http\Controllers;

use App\Models\AppointmentStatus;
use Illuminate\Http\Request;

class AppointmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $statuses = AppointmentStatus::orderBy('id', 'ASC')->get();
       
       return response()->json($statuses, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $status = AppointmentStatus::findOrFail($id);
       
       return response()->json($status, 200);
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
       $status = AppointmentStatus::findOrFail($id);
       
       $this->authorize('update', $status);

       $status->update([
        'title' => $request->title ?? $status->title,
        'description' => $request->description ?? $status->description,
       ]);

       return response()->json(['message' => 'Status updated.', 'status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $status = AppointmentStatus::findOrFail($id);
       
       $this->authorize('update', $status);

       $status->delete();

       return response()->json('Status deleted.');
    }
}
