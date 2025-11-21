<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'staff') {
                return redirect()->route('staff.overtimes.index');
            }

            if ($user->role === 'leader') {
                return redirect()->route('leader.overtimes.index');
            }

            if ($user->role === 'manager') {
                return redirect()->route('manager.overtimes.index');
            }

            return redirect()->route('login');
        }

        return back()
            ->withErrors(['name' => 'Nama atau password salah'])
            ->onlyInput('name');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
