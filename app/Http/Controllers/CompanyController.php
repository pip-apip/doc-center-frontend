<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    public function index()
    {
        return view('pages.company', ['title' => 'Company']);
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'company_name'      => 'required|string|max:100',
            'company_addres'    => 'required|string|max:100',
            'director_name'     => 'required|string|max:100',
            'director_phone'    => 'required|string|max:100',
        ]);

        // Ensure session token exists
        // if (!session()->has('token')) {
        //     return response()->json(['error' => 'Unauthorized. No token found.'], 401);
        // }

        // Send POST request to external API
        $response = Http::withToken(session('token'))
            ->post('http://doc-center-backend.test/api/v1/admin-doc-categories', $validatedData);

        // Return response based on API result
        if ($response->successful()) {
            return response()->json([
                'message' => 'Category created successfully.',
                'data'    => $response->json()
            ], 201);
        }

        return response()->json([
            'error' => $response->json('message', 'Failed to create project.')
        ], $response->status());
    }

    /**
     * Update an existing project.
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $validatedData = $request->validate([
            'project_name'      => 'required|string|max:100',
            'company_name'      => 'required|string|max:100',
            'company_address'   => 'required|string',
            'director_name'     => 'required|string|max:100',
            'director_phone'    => 'required|string|max:20',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date', // Ensure end date is not before start date
        ]);
        // Ensure session token exists
        // if (!session()->has('token')) {
        //     return response()->json(['error' => 'Unauthorized. No token found.'], 401);
        // }

        $validatedDataMerged = array_merge($validatedData, ['_method' => 'PATCH']);

        return $response->json([
            'message' => 'Project updated successfully.',
            'data'    => $validatedDataMerged
        ], 200);
        die;

        // Send PUT request to external API
        $response = Http::patch("http://doc-center-backend.test/api/v1/projects/{$id}", $validatedDataMerged);

        // Return response based on API result
        if ($response->successful()) {
            return response()->json([
                'message' => 'Project updated successfully.',
                'data'    => $response->json()
            ], 200);
        }

        return response()->json([
            'error' => $response->json('message', 'Failed to update project.')
        ], $response->status());
    }
}
