<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    public function login(){
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
        $response = Http::post('https://bepm.hanatekindo.com/api/v1/auth/login', [
            'username'  => $validatedData['username'],
            'password'  => $validatedData['password'],
        ]);

        // Check API response
        if ($response->json('status') === 200) {
            // dd($response->json());
            // Login successful, redirect to home with session
            session([
                'user' => [
                    'access_token'  => $response->json('data.access_token'),
                    'refresh_token' => $response->json('data.refresh_token'),
                    'name'          => $response->json('data.name'),
                    'username'      => $response->json('data.username'),
                    'role'          => $response->json('data.role'),
                    'id'            => $response->json('data.id'),
                ],
                'login-time' => now(),
            ]);

            return redirect()->route('home')->with('success', 'Login successful.');
        } elseif ($response->json('status') === 401) {
            $errorMessage = 'Invalid username or password.';
            return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
        } else {
            $errorMessage = $response->json('message', 'Login failed. Please try again.');
            return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
        }
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
            'username'  => 'required|string|max:255|unique:users,username',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        // Send a POST request to external API
        $response = Http::post('https://bepm.hanatekindo.com/api/v1/auth/register', [
            'name'      => $validatedData['name'],
            'username'  => $validatedData['username'],
            'password'  => $validatedData['password'],
        ]);

        // dd($response->json());

        // Check API response
        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Registration successful. Please login.');
        }

        // Handle errors (API might return validation errors)
        $errorMessage = $response->json('message', 'Registration failed. Please try again.');
        return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
    }

    public function logout(){
        $token = session('user.access_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'You are not logged in.');
        }
        $response = Http::withToken($token)->post('https://bepm.hanatekindo.com/api/v1/auth/logout');

        session()->forget(['user']);
        session()->flush();

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Logged out successfully.');
        }

        // Handle errors
        return redirect()->route('login')->with('error', 'Logout failed. Please try again.');


    }
}
