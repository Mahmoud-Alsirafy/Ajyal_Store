<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('Dashboard.Profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'birthday' => ['required', 'date', 'before:today'],
            'gender' => ['in:male,female']
        ]);
        $user = $request->user();
        $user->profile->fill($request->all())->save();
        return redirect()->route('profiley.edit')->with('success', 'Profile Update!');
        // $user->profile()->create($request->all());
    }
}
