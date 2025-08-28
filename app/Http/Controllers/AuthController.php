<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showAdminLoginForm() {
        return view('admin.login');
    }

    public function adminLogin(Request $request) {
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials for Admin']);
    }

    public function adminDashboard() {
        return view('admin.dashboard');
    }

    public function showCustomerLoginForm() {
        return view('customer.login');
    }

    public function customerLogin(Request $request) {
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'customer';

        if (Auth::attempt($credentials)) {
            return redirect()->route('customer.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials for Customer']);
    }

    public function showCustomerRegisterForm() {
        return view('register');
    }

    public function customerRegister(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        Auth::login($user);
        return redirect()->route('customer.dashboard');
    }

    public function customerDashboard() {
        return view('customer.dashboard');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('customer.login'); 
    }
}
