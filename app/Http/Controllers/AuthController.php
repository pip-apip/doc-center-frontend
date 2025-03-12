<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
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

        // Check API response
        if ($response->successful()) {
            // Save token in session
            session([
                'token'     => $response->json('data.access_token'),
                'name'      => $response->json('data.name'),
                'username'  => $response->json('data.username'),
                'refresh_token' => request()->cookie()
            ]);
            dd(session()->all());
            // return redirect()->route('project');
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
            'username'  => 'required|string|max:255|unique:users,username',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        // Send a POST request to external API
        $response = Http::post('http://doc-center-backend.test/api/v1/auth/register', [
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
}
