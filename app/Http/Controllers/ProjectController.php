<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function __construct(){
        if(session('lastUrl') !== Route::currentRouteName()){
            session()->put(['lastUrl' => Route::currentRouteName()]);
        }
    }

    public function index()
    {
        $accessToken = session('user.access_token');

        $responseProject = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/projects');

        if ($responseProject->failed()) {
            return redirect()->back()->withErrors('Failed to fetch project data.');
        }

        $projects = $responseProject->json()['data'];

        $responseUser = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/users?limit=1000');

        if ($responseUser->failed()) {
            return redirect()->back()->withErrors('Failed to fetch companys data.');
        }

        $users = $responseUser->json()['data'];

        return view('pages.project.index', compact('projects', 'users'))->with(['title' => 'project']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accessToken = session('user.access_token');
        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/companies');

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch project data.');
        }

        $companies = $response->json()['data'];
        $project = [];
        return view('pages.project.form', compact('project', 'companies'))->with(['title' => 'project', 'status' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'company_id' => ['required', 'not_in:#'],
        //     'start_date' => 'required|date',
        //     'end_date' => 'required|date',
        // ]);

        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->post('https://bepm.hanatekindo.com/api/v1/projects', [
            'name' => $request->input('name'),
            'company_id' => $request->input('company_id'),
            'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
            'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        // dd($response->json());

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('project.index')->with('success', 'Project created successfully.');
    }

    /**
     * Show the form for creating a new resource doc.
     */
    public function storeDoc(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf|max:2048',
            'project_id' => 'required',
            'admin_doc_category_id' => 'required',
    ]);

        $accessToken = session('user.access_token');
        $file = $request->file('file');
        // dd($file);

        // Prepare the data
        $data = [
            'title' => $request->input('title'),
            'project_id' => $request->input('project_id'),
            'admin_doc_category_id' => $request->input('admin_doc_category_id'),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. $accessToken,
        ])
        ->attach('file', file_get_contents($file), $file->getClientOriginalName())
        ->post('https://bepm.hanatekindo.com/api/v1/admin-docs', $data);

        // dd($response->json());

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('project.doc', ['id' => $request->input('project_id')])->with('success', 'Project Doc created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $accessToken = session('user.access_token');
        $responseProject = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/projects/'.$id);

        if ($responseProject->failed()) {
            return redirect()->back()->withErrors('Failed to fetch project data.');
        }

        $responseDocProject = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/admin-docs/search?project_id='.$id.'&limit=1000');
        // dd($responseDocProject->json());

        if ($responseDocProject->failed()) {
            return redirect()->back()->withErrors('Failed to fetch doc project data.');
        }

        $responseCategoryDocAdmin = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/admin-doc-categories');

        if ($responseCategoryDocAdmin->failed()) {
            return redirect()->back()->withErrors('Failed to fetch doc category of administration project data.');
        }

        $data = [
            'project'       => $responseProject->json()['data'][0],
            'docProject'    => $responseDocProject->json()['data'],
            'categoryDoc'   => $responseCategoryDocAdmin->json()['data']
        ];

        // dd($data);

        return view('pages.project.doc', compact('data'))->with(['title' => 'project']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $accessToken = session('user.access_token');

        $responseProject = Http::withToken($accessToken)->get("https://bepm.hanatekindo.com/api/v1/projects/{$id}");

        if ($responseProject->failed()) {
            return redirect()->back()->withErrors('Failed to fetch category details.');
        }

        $project = $responseProject->json()['data'][0];

        $responseCompanies = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/companies');

        if ($responseCompanies->failed()) {
            return redirect()->back()->withErrors('Failed to fetch project data.');
        }

        $companies = $responseCompanies->json()['data'];

        // dd($project);

        return view('pages.project.form', compact('project', 'companies'))->with(['title' => 'project', 'status' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => ['required', 'not_in:#'],
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->patch('https://bepm.hanatekindo.com/api/v1/projects/'. $id, [
            'name' => $request->input('name'),
            'company_id' => $request->input('company_id'),
            'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
            'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('project.index')->with('success', 'Project edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete('https://bepm.hanatekindo.com/api/v1/projects/'.$id);

        if ($response->json()['status'] == 400 || $response->json()['status'] == 500) {
            $errors = $response->json()['errors'];

            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->back()->with('success', 'Data Projek Berhasil di Hapus');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyDoc(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete('https://bepm.hanatekindo.com/api/v1/admin-docs/'.$id);

        if ($response->json()['status'] == 400 || $response->json()['status'] == 500) {
            $errors = $response->json()['errors'];

            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->back()->with('success', 'Dokumen Projek Berhasil di Hapus.');
    }
}
