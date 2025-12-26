<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        session(['user_id' => $user->id, 'role' => 'customer', 'user_name' => $user->name, 'user_image' => $user->image_url ?? null]);
        return redirect()->route('shop');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'Credentials not match'])->withInput();
        }

        session(['user_id' => $user->id, 'role' => $user->role, 'user_name' => $user->name, 'user_image' => $user->image_url ?? null]);
        if ($user->role === 'admin') return redirect('/admin');
        return redirect()->route('shop');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user_id','role','user_name','user_image']);
        return redirect('/');
    }
}
