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
        $validated = $request->validate([
            'role' => ['required', 'in:admin,community_user'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where(function ($query) use ($validated) {
            $query->where('email', $validated['username'])
                  ->orWhere('name', $validated['username']);
        })->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'username' => 'Account not found. Check your username or email.',
                ])
                ->withInput($request->only('username', 'role'));
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return back()
                ->withErrors([
                    'password' => 'Incorrect password.',
                ])
                ->withInput($request->only('username', 'role'));
        }

        if ($user->role !== $validated['role']) {
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

        if ($user->role === 'community_user') {
            return redirect()->route('user.dashboard');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors([
                'role' => 'Your account does not have a valid role.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
