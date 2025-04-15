<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    protected $API_url = "https://bepm.hanatekindo.com";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accessToken = session('user.access_token');
        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/companies');

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch companys data.');
        }

        $companies = $response->json()['data'];

        return view('pages.company.index', compact('companies'))->with([
            'title' => 'company',
            'API_url' => $this->API_url
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company = [];
    return view('pages.company.form', compact('company'))->with(['title' => 'company', 'status' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string',
            'director_name' => 'required|string|max:100',
            'director_phone' => 'required|string|max:20',
            'director_signature' => 'sometimes|mimes:jpeg,png,jpg|max:2048'
        ]);

        $accessToken = session('user.access_token');
        $file = $request->file('director_signature');

        // Prepare the data
        $data = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'director_name' => $request->input('director_name'),
            'director_phone' => $request->input('director_phone'),
        ];

        if ($file) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $accessToken,
            ])
            ->attach('director_signature', file_get_contents($file), $file->getClientOriginalName())
            ->post('https://bepm.hanatekindo.com/api/v1/companies', $data);
        } else {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $accessToken,
            ])
            ->post('https://bepm.hanatekindo.com/api/v1/companies', $data);
        }

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('company.index')->with('success', 'Company created successfully.');
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

        $response = Http::withToken($accessToken)->get("https://bepm.hanatekindo.com/api/v1/companies/{$id}");

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch company details.');
        }

        $company = $response->json()['data'][0];

        return view('pages.company.form', compact('company'))->with(['title' => 'company', 'status' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string',
            'director_name' => 'required|string|max:100',
            'director_phone' => 'required|string|max:20',
            'director_signature' => 'sometimes|mimes:jpeg,png,jpg|max:2048',
        ]);

        $accessToken = session('user.access_token');
        $file = $request->file('director_signature');

        $requestHttp = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        if ($file) {
            // If file exists, send multipart form data including the file
            $response = $requestHttp
                ->attach('director_signature', file_get_contents($file), $file->getClientOriginalName())
                ->asMultipart()
                ->post("https://bepm.hanatekindo.com/api/v1/companies/{$id}", [
                    ['name' => 'name', 'contents' => $validated['name']],
                    ['name' => 'address', 'contents' => $validated['address']],
                    ['name' => 'director_name', 'contents' => $validated['director_name']],
                    ['name' => 'director_phone', 'contents' => $validated['director_phone']],
                ]);
        } else {
            // If no file, just send JSON payload
            $response = $requestHttp
                ->post("https://bepm.hanatekindo.com/api/v1/companies/{$id}", $validated);
                // dd($response->json());
        }

        if ($response->successful()) {
            return redirect()->route('company.index')->with('success', 'Company updated successfully.');
        } else {
            $errors = $response->json()['errors'] ?? ['error' => 'An unknown error occurred.'];
            return redirect()->back()->withInput()->withErrors($errors);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete('https://bepm.hanatekindo.com/api/v1/companies/'.$id);

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to delete company.');
        }

        return redirect()->route('company.index')->with('success', 'Company delete successfully.');
    }
}
