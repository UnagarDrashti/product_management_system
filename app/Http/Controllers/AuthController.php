<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
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
        
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        Auth::login($user);
        return redirect()->route('customer.login');
    }

    public function customerDashboard(Request $request) {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('category', 'like', "%$search%");
        }

        $products = $query->latest()->paginate(10);

        $products->appends($request->all());
        return view('customer.dashboard', compact('products'));
    }

    public function logout() {
        Auth::logout();
        return view('welcome'); 
    }
}
