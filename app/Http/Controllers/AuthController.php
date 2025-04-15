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
                ]
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
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255',
            'password'  => 'required|string|min:8',
        ]);

        // Send a POST request to external API
        $response = Http::post('https://bepm.hanatekindo.com/api/v1/auth/register', [
            'name'      => $request['name'],
            'username'  => $request['username'],
            'password'  => $request['password'],
        ]);

        if ($response->successful()) {
            return redirect()->route('user.index')->with('success', 'Data User created successfully.');
        }

        $errorMessage = $response->json('message', 'Data User failed to create. Please try again.');
        return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
    }
    
    public function logout(){
        // Get token from session
        $token = session('user.access_token');
        // dd($token);

        // Check if token exists
        if (!$token) {
            return redirect()->route('login')->with('error', 'You are not logged in.');
        }

        // Send a POST request to the API with Bearer Token
        $response = Http::withToken($token)->post('https://bepm.hanatekindo.com/api/v1/auth/logout');

        // Clear session data
        session()->forget(['user']);
        session()->flush();

        // Check API response
        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Logged out successfully.');
        }

        // Handle errors
        return redirect()->route('login')->with('error', 'Logout failed. Please try again.');
    }
}
