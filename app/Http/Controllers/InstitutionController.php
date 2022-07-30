<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutions = Institution::orderBy('updated_at', 'DESC')->get();
        
        $institutions->load('media', 'users');

        return response()->json($institutions);
    }

    public function indexNames()
    {
        $institutions = Institution::select('id', 'name')->orderBy('name', 'ASC')->get();
        return response()->json($institutions);
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
            'name' => 'required|unique:institutions',
            'address' => 'nullable',
            'contact_no' => 'nullable',
            'contact_email' => 'nullable',
            'contact_person_name' => 'nullable',
            'contact_person_no' => 'nullable',
            'logo' => 'nullable',
            'attachments' => 'nullable'
        ]);

        $institution = new Institution([
            'name' => $data['name'],
            'address' => $data['address'],
            'contact_no' => $data['contact_no'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'contact_person_name' => $data['contact_person_name'] ?? null,
            'contact_person_no' => $data['contact_person_no'] ?? null,
        ]);

        $this->authorize('store', [$institution]);

        $institution->save();

        // Spatie Media Library
        if($request->hasFile('logo')) {
            $institution->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        if($request->hasFile('attachments')) {
            foreach($request->attachments as $attachment) {
                $institution->addMedia($attachment)->toMediaCollection('attachments');
            }
        }

        $institution->load('users', 'media');
        
        return response()->json($institution);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $institution = Institution::findOrFail($id);

        $institution->load('users', 'media');

        return response()->json($institution);
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
        $data = $request->validate([
            'name' => 'nullable',
            'address' => 'nullable',
            'contact_no' => 'nullable',
            'contact_email' => 'nullable',
            'contact_person_name' => 'nullable',
            'contact_person_no' => 'nullable',
            'logo' => 'nullable',
            'attachments' => 'nullable'
        ]);

        $institution = Institution::findOrFail($id);

        $this->authorize('update', [$institution]);

        $institution->update($request->all());

        // Spatie Media Library
        if($request->hasFile('logo')) {
            $institution->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        if($request->hasFile('attachments')) {
            foreach($request->attachments as $attachment) {
                $institution->addMedia($attachment)->toMediaCollection('attachments');
            }
        }

        $institution->load('users', 'media');

        return response()->json($institution);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $institution = Institution::findOrFail($id);

        $this->authorize('delete', [$institution]);

        $institution->delete();

        return response()->json('Institution deleted');
    }

    /**
     * Approve the specified resource. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $institution = Institution::findOrFail($id);

        $this->authorize('approve', [$institution]);

        $institution->update([
            'approved_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);


        $institution->delete();

        return response()->json('Institution deleted');
    }
}
