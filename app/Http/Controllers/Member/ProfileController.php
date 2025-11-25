<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show member profile
    public function show()
    {
        $user = Auth::user();
        return view('member.profile.show', compact('user'));
    }

    // Edit member profile
    public function edit()
    {
        $user = Auth::user();
        return view('member.profile.edit', compact('user'));
    }

    // Update member profile
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'nohp' => 'nullable|string|max:15',
            'nik' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Remove password if not provided
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return redirect()->route('member.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
