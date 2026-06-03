<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email|max:150',
            'phone'       => 'required|string|max:20',
            'position'    => 'required|string|max:50',
            'age'         => 'required|integer|min:8|max:40',
            'nationality' => 'required|string|max:60',
            'age_group'   => 'required|in:U13,U15,U17,U19,Senior',
            'password'    => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'player_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            // Store under public disk; path is relative to storage/app/public
            $storedPath = $file->storeAs('players', $filename, 'public');
            // Prefix with 'storage/' so asset($user->profile_photo) resolves correctly
            $profilePhotoPath = 'storage/' . $storedPath;
        }

        $user = User::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'position'    => $validated['position'],
            'age'         => $validated['age'],
            'nationality' => $validated['nationality'],
            'age_group'   => $validated['age_group'],
            'password'    => Hash::make($validated['password']),
            'role'        => 'player',
            'status'      => 'pending',
            'profile_photo' => $profilePhotoPath,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('info', 'Registration successful! Your account is pending approval by the OFA management team. You will be notified once approved.');
    }
}
