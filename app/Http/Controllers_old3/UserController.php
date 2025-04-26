<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        Session::forget('q');

    }
    public function index()
    {
        $q = Session::get('q');
        $data['q'] = $q;

        $page = request('page', 1);
        $perPage = request()->has('per_page') ? request('per_page') : 5;

        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/users/search', [
            'name' => $q,
            'limit' => $perPage,
            'page' => $page
        ]);

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch users.');
        }

        $users = $response->json()['data'];
        $total = $response->json()['pagination']['total'];

        $results = new LengthAwarePaginator(
            collect($users),
            $total,
            $perPage,
            $page,
            ['path' => url('user')]
        );

        return view('pages.user.index', compact('results'))->with(['title' => 'user']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = [];
        return view('pages.user.form', compact('user'))->with(['title' => 'user', 'status' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(String $id){
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->get("https://bepm.hanatekindo.com/api/v1/users/{$id}");

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch category details.');
        }

        $user = $response->json()['data'][0];

        return view('pages.user.form', compact('user'))->with(['title' => 'user', 'status' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255',
            'password'  => 'required|string|min:8',
        ]);

        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->patch('https://bepm.hanatekindo.com/api/v1/users/'.$id ,[
            'name'      => $request['name'],
            'username'  => $request['username'],
            'password'  => $request['password'],
        ]);

        // dd($response->json());

        if ($response->successful()) {
            return redirect()->route('user.index')->with('success', 'Data User edited successfully.');
        }
        $errorMessage = $response->json('message', 'Data User failed to edited. Please try again.');
        return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete("https://bepm.hanatekindo.com/api/v1/users/{$id}");

        if ($response->successful()) {
            return redirect()->route('user.index')->with('success', 'Data User deleted successfully.');
        }
        $errorMessage = $response->json('message', 'Data User failed to deleted. Please try again.');
        return redirect()->back()->withErrors(['error' => $errorMessage])->withInput();
    }
}
