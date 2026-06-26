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

    /* ── Guardian Registration ─────────────────────────────── */
    public function showGuardianForm()
    {
        return view('auth.guardian-register');
    }

    public function registerGuardian(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:100',
            'email'              => 'required|email|unique:users,email|max:150',
            'phone'              => 'required|string|max:20',
            'nationality'        => 'required|string|max:60',
            'relationship'       => 'required|string|max:50',
            'relationship_other' => 'nullable|string|max:50',
            'child_name'         => 'required|string|max:100',
            'password'           => 'required|string|min:8|confirmed',
            'profile_photo'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'consent_form'       => 'required|file|mimes:pdf|max:5120',
        ]);

        // If "Other" chosen, use the custom text they typed
        $relationship = $validated['relationship'] === 'Other'
            ? trim($validated['relationship_other'] ?? 'Other')
            : $validated['relationship'];

        if ($validated['relationship'] === 'Other' && empty(trim($validated['relationship_other'] ?? ''))) {
            return back()->withErrors(['relationship_other' => 'Please specify your relationship to the player.'])->withInput();
        }

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'guardian_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $storedPath = $file->storeAs('guardians', $filename, 'public');
            $profilePhotoPath = 'storage/' . $storedPath;
        }

        $consentFormPath = null;
        if ($request->hasFile('consent_form')) {
            $file = $request->file('consent_form');
            $filename = 'consent_' . time() . '_' . uniqid() . '.pdf';
            $storedPath = $file->storeAs('consent-forms', $filename, 'public');
            $consentFormPath = 'storage/' . $storedPath;
        }

        $user = User::create([
            'name'                   => $validated['name'],
            'email'                  => $validated['email'],
            'phone'                  => $validated['phone'],
            'nationality'            => $validated['nationality'],
            'child_name'             => $validated['child_name'],
            'relationship_to_player' => $relationship,
            'position'               => 'Guardian of: ' . $validated['child_name'],
            'age'                    => 0,
            'age_group'              => 'N/A',
            'password'               => Hash::make($validated['password']),
            'role'                   => 'guardian',
            'status'                 => 'pending',
            'profile_photo'          => $profilePhotoPath,
            'consent_form_path'      => $consentFormPath,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('info', 'Guardian account created! Your account is pending approval. We will contact you within 48 hours.');
    }

    /* ── Coach Registration ────────────────────────────────── */
    public function showCoachForm()
    {
        return view('auth.coach-register');
    }

    public function registerCoach(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email|max:150',
            'phone'            => 'required|string|max:20',
            'nationality'      => 'required|string|max:60',
            'coaching_role'    => 'required|string|max:80',
            'experience_years' => 'required|integer|min:0|max:50',
            'qualifications'   => 'nullable|string|max:200',
            'password'         => 'required|string|min:8|confirmed',
            'profile_photo'    => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'coach_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $storedPath = $file->storeAs('coaches', $filename, 'public');
            $profilePhotoPath = 'storage/' . $storedPath;
        }

        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'nationality'   => $validated['nationality'],
            'position'      => $validated['coaching_role'],
            'age'           => 0,
            'age_group'     => $validated['experience_years'] . ' yrs exp',
            'password'      => Hash::make($validated['password']),
            'role'          => 'coach',
            'status'        => 'pending',
            'profile_photo' => $profilePhotoPath,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('info', 'Coach application submitted! Your application is under review by the Academy Director — you will hear back within 48 hours.');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email|max:150',
            'phone'         => 'required|string|max:20',
            'position'      => 'required|string|max:50',
            'age'           => 'required|integer|min:8|max:40',
            'nationality'   => 'required|string|max:60',
            'age_group'     => 'required|in:U13,U15,U17,U19,Senior',
            'password'      => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'consent_form'  => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'player_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $storedPath = $file->storeAs('players', $filename, 'public');
            $profilePhotoPath = 'storage/' . $storedPath;
        }

        $consentFormPath = null;
        if ($request->hasFile('consent_form')) {
            $file = $request->file('consent_form');
            $filename = 'consent_player_' . time() . '_' . uniqid() . '.pdf';
            $storedPath = $file->storeAs('consent-forms', $filename, 'public');
            $consentFormPath = 'storage/' . $storedPath;
        }

        $user = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'phone'             => $validated['phone'],
            'position'          => $validated['position'],
            'age'               => $validated['age'],
            'nationality'       => $validated['nationality'],
            'age_group'         => $validated['age_group'],
            'password'          => Hash::make($validated['password']),
            'role'              => 'player',
            'status'            => 'pending',
            'profile_photo'     => $profilePhotoPath,
            'consent_form_path' => $consentFormPath,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('info', 'Registration successful! Your account is pending approval by the OFA management team. You will be notified once approved.');
    }
}
