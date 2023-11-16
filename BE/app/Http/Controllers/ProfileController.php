<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profile = $request->user()->profile;
        return $profile;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $profile = Profile::where('user_id', $request->user()->id);
        $path = $request->file('picture')->storeAs('Images', $profile->id . '.jpg');
        $profile->full_name = $request->full_name;
        $profile->work_email = $request->work_email;
        $profile->work_mobile = $request->work_mobile;
        $profile->image->url = $path;
        $profile->save();
        return response()->json(['profile' => 'profile'], 200);
        // $profile = Profile::where('user_id', $id)->get();
        // $profile->image()->create([
        //     'url' => $path
        // ]);
        // $profile->save();
        // return response()->json(['profile' => $profile], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        $path = $request->file('picture')->storeAs('Images', $profile->id . '.jpg');
        $profile->full_name = $request->full_name;
        $profile->work_email = $request->work_email;
        $profile->work_mobile = $request->work_mobile;
        $profile->save();
        $image = $profile->image()->create(['url' => $path]);
        return response()->json(['profile' => $profile, 'image' => $image], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
