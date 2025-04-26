<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class CategoryActController extends Controller
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

        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activity-doc-categories/search', [
            'name' => $q,
            'limit' => $perPage,
            'page' => $page
        ]);

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch categories.');
        }

        $categories = $response->json()['data'];
        $total = $response->json()['pagination']['total'];

        $results = new LengthAwarePaginator(
            collect($categories),
            $total,
            $perPage,
            $page,
            ['path' => url('categoryAct')]
        );

        return view('pages.categoryAct.index', compact('results'))->with(['title' => 'categoryAct']);
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

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            return redirect()->back()->withInput()->withErrors($errors);
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
