<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->where('role','admin')->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email'=>'Invalid admin credentials']);
        }

        session(['user_id' => $user->id, 'role' => 'admin', 'user_name' => $user->name]);
        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user_id','role','user_name']);
        return redirect('/');
    }
}
