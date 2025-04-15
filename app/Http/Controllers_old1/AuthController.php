<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(session('user')){
            return redirect()->route('home');
        }
        return view('auth.login', ['session' => session()->all()]);
    }

    public function doLogin(){
        // Validate input
        $validatedData = request()->validate([
            'username'  => 'required|string|max:255',
            'password'  => 'required|string|min:8',
        ]);

        // Send a POST request to external API
        $response = Http::post('http://doc-center-backend.test/api/v1/auth/login', [
            'username'  => $validatedData['username'],
            'password'  => $validatedData['password'],
        ]);

        if ($response->successful()) {
            session([
                'user' => [
                    'access_token'  => $response->json('data.access_token'),
                    'refresh_token' => $response->json('data.refresh_token'),
                    'name'          => $response->json('data.name'),
                    'username'      => $response->json('data.username'),
                    // 'role'          => $response->json('data.role'),
                ]
            ]);
            // dd(session()->all());
            return redirect()->route('home')->with('success', 'Login successful.');
        }

        // Handle errors
        $errorMessage = $response->json('message', 'Login failed. Please try again.');
        return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
    }

    public function register()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'name'      => 'required|string|max:255',
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|in:USER,ADMIN,SUPERADMIN',
        ]);

        // Send a POST request to external API
        $response = Http::post('http://doc-center-backend.test/api/v1/auth/register', [
            'name'      => $validatedData['name'],
            'username'  => $validatedData['username'],
            'password'  => $validatedData['password'],
            'role'      => $validatedData['role'],
        ]);

        // dd($response->json());

        if ($response->successful()) {
            return redirect()->route('home')->with('message', 'Registration successful.');
        }

        // Handle errors (API might return validation errors)
        $errorMessage = $response->json('message', 'Registration failed. Please try again.');
        return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
    }

    public function logout(){
        // Get token from session
        $token = session('user.access_token');

        // Check if token exists
        if (!$token) {
            return redirect()->route('login')->with('error', 'You are not logged in.');
        }

        // Send a POST request to the API with Bearer Token
        $response = Http::withToken($token)->post('http://doc-center-backend.test/api/v1/auth/logout');

        // Clear session data
        session()->forget('user');
        session()->flush();

        // Check API response
        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Logged out successfully.');
        }

        // Handle errors
        return redirect()->route('login')->with('error', 'Logout failed. Please try again.');
    }


}
