<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->cursorPaginate(15);

        $users->load(['role:id,name', 'notes', 'appointments']);

        return response()->json($users);
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
            'institution_id' => 'required|exists:institutions,id',
            'username' => 'required|unique:users',
            'birthdate' => 'nullable|date_format:Y-m-d|before:today',
            'address' => 'nullable',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'attachment' => 'nullable',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'role_id' => $request->role_id,
            'institution_id' => $request->institution_id,
            'username' => strip_tags($request->username),
            'birthdate' => $request->birthdate ?? null,
            'address' => strip_tags($request->address) ?? null,
            'first_name' => strip_tags($request->first_name),
            'last_name' => strip_tags($request->last_name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Spatie Media Library
        if ($request->hasFile('attachment')) {
            $user->addMediaFromRequest('attachment')->toMediaCollection('profile_pic');
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'token' => $token,
            'user' => $user,
        ];

        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('show', [$user]);

        $user->load(['notes', 'appointments']);

        return response()->json($user);
    }

    public function getCurrentUser()
    {
        $user = auth()->user();
        dd($user);

        return response()->json($user);
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
        $user = User::findOrFail($id);

        $this->authorize('update', [$user]);

        $user->update([
            'username' => $request->username ?? $user->username,
            'birthdate' => $request->birthdate ?? $user->birthdate,
            'first_name' => $request->first_name ?? $user->first_name,
            'last_name' => $request->last_name ?? $user->last_name,
        ]);

        // Spatie Media Library
        if ($request->hasFile('attachment')) {
            $user->addMediaFromRequest('attachment')->toMediaCollection('profile_pic');
        }

        $user->load(['notes', 'appointments']);

        return response()->json(['message' => 'Updated user', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('delete', [$user]);

        $user->delete();

        return response()->json('User deleted');
    }
}
