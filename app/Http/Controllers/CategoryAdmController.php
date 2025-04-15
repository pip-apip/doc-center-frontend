<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryAdmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/admin-doc-categories');

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch categories.');
        }

        $categories = $response->json();
        // dd($categories);

        return view('pages.categoryAdm.index', compact('categories'))->with(['title' => 'categoryAdm']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = [];
        return view('pages.categoryAdm.form', compact('category'))->with(['title' => 'categoryAdm', 'status' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->post('https://bepm.hanatekindo.com/api/v1/admin-doc-categories', [
            'name' => $request->input('name'),
        ]);

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('categoryAdm.index')->with('success', 'Category Administration created successfully.');
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
    public function edit(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->get("https://bepm.hanatekindo.com/api/v1/admin-doc-categories/{$id}");

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch category details.');
        }

        $category = $response->json()['data'][0];

        return view('pages.categoryAdm.form', compact('category'))->with(['title' => 'categoryAdm', 'status' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->patch('https://bepm.hanatekindo.com/api/v1/admin-doc-categories/'.$id, [
            'name' => $request->input('name'),
        ]);

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('categoryAdm.index')->with('success', 'Category Administration update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete('https://bepm.hanatekindo.com/api/v1/admin-doc-categories/'.$id);

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to delete category.');
        }

        return redirect()->route('categoryAdm.index')->with('success', 'Category Administration delete successfully.');
    }
}
