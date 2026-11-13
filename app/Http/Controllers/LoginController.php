<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,community_user',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'username' => 'Account not found. Check your username or email.',
                ])
                ->withInput($request->only('username', 'role'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'Incorrect password.',
                ])
                ->withInput($request->only('username', 'role'));
        }

        if ($user->role !== $request->role) {
            return back()
                ->withErrors([
                    'role' => 'The selected account type does not match your account.',
                ])
                ->withInput($request->only('username', 'role'));
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
