<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryActController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activity-doc-categories');

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch categories.');
        }

        $categories = $response->json();
        // dd($categories);

        return view('pages.categoryAct.index', compact('categories'))->with(['title' => 'categoryAct']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = [];
        return view('pages.categoryAct.form', compact('category'))->with(['title' => 'categoryAct', 'status' => 'create']);
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

        $response = Http::withToken($accessToken)->post('https://bepm.hanatekindo.com/api/v1/activity-doc-categories', [
            'name' => $request->input('name'),
        ]);

        // dd($response->json()['status']);

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('categoryAct.index')->with('success', 'Category Activity created successfully.');
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

        $response = Http::withToken($accessToken)->get("https://bepm.hanatekindo.com/api/v1/activity-doc-categories/{$id}");

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch category details.');
        }

        $category = $response->json()['data'][0];

        return view('pages.categoryAct.form', compact('category'))->with(['title' => 'categoryAct', 'status' => 'edit']);
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

        $response = Http::withToken($accessToken)->patch('https://bepm.hanatekindo.com/api/v1/activity-doc-categories/'.$id, [
            'name' => $request->input('name'),
        ]);

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to update category.');
        }

        return redirect()->route('categoryAct.index')->with('success', 'Category Activity update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete('https://bepm.hanatekindo.com/api/v1/activity-doc-categories/'.$id);

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to delete category.');
        }

        return redirect()->route('categoryAct.index')->with('success', 'Category Activity delete successfully.');
    }
}
