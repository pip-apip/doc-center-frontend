<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ActivityController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function __construct(){
        // $currentRoute = Route::currentRouteName();

        // if(Route::current()->parameters()['id'] ?? null){
        //     $currentRoute .= ', '.Route::current()->parameters()['id'];
        // }

        // if (session('lastRoute') !== $currentRoute) {
        //     session()->put(['lastRoute' => $currentRoute]);
        //     dd(session('lastRoute'), $currentRoute, 'TRUE');
        // }

        // dd(session('lastRoute'), $currentRoute, 'FALSE');

        $currentRoute = Route::currentRouteName();
        $id = request()->route('id');


        $currentRoute .= $id ? ', ' . $id : '';

        if (session('lastRoute') !== $currentRoute) {
            session(['lastRoute' => $currentRoute]);
        }
    }

    public function index()
    {
        $this->lastRoute = Route::currentRouteName();

        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activities');

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch activities.');
        }

        $activities = $response->json();

        return view('pages.activity.index', compact('activities'))->with(['title' => 'activity']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/projects');

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch project.');
        }

        $projects = $response->json()['data'];
        $activity = [];
        $countDocAct = 0;

        return view('pages.activity.form', compact('activity', 'projects', 'countDocAct'))->with(['title' => 'activity', 'status' => 'create', 'lastUrl' => session('lastUrl')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'project_id' => ['required', 'not_in:#'],
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->post('https://bepm.hanatekindo.com/api/v1/activities', [
            'project_id' => $request->input('project_id'),
            'title' => $request->input('title'),
            'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
            'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
        ]);

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route($this->route)->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $accessToken = session('user.access_token');
        $responseActivity = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activities/'.$id);

        if ($responseActivity->failed()) {
            return redirect()->back()->withErrors('Failed to fetch activity data.');
        }

        $responseDocActivity = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activity-docs/search?activity_id='.$id);

        if ($responseDocActivity->failed()) {
            return redirect()->back()->withErrors('Failed to fetch doc activity data.');
        }

        $responseCategoryDocActivity = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activity-doc-categories');

        if ($responseCategoryDocActivity->failed()) {
            return redirect()->back()->withErrors('Failed to fetch doc category of activity data.');
        }

        $data = [
            'activity'       => $responseActivity->json()['data'][0],
            'docActivity'    => $responseDocActivity->json()['data'],
            'categoryDoc'   => $responseCategoryDocActivity->json()['data']
        ];

        // dd($data);

        return view('pages.activity.doc', compact('data'))->with(['title' => 'activity']);
    }
    /**
     * Display the specified resource.
     */
    public function activity_project(string $id)
    {
        $accessToken = session('user.access_token');
        $responseProject = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/projects/'.$id);

        if ($responseProject->failed()) {
            return redirect()->back()->withErrors('Failed to fetch project data.');
        }

        $project = $responseProject->json()['data'][0];

        $responseActivity = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activities/search?project_id='.$id);

        if ($responseActivity->failed()) {
            return redirect()->back()->withErrors('Failed to fetch activity data.');
        }

        $activities = $responseActivity->json()['data'];

        return view('pages.project.activity', compact('project', 'activities'))->with(['title' => 'activity']);
    }
    /**
     * Store a newly created resource doc.
     */
    public function storeDoc(Request $request)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->post('https://bepm.hanatekindo.com/api/v1/activity-docs', [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'tags' => $request->input('tags'),
            'activity_id' => $request->input('activity_id'),
            'activity_doc_category_id' => $request->input('category_id'),
        ]);

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route($this->route)->with('success', 'Project created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // dd(session('lastUrl'));
        $accessToken = session('user.access_token');

        $responseActivity = Http::withToken($accessToken)->get("https://bepm.hanatekindo.com/api/v1/activities/{$id}");

        if ($responseActivity->failed()) {
            return redirect()->back()->withErrors('Failed to fetch category details.');
        }

        $activity = $responseActivity->json()['data'][0];
        // dd($activity);

        $responseProject = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/projects');

        if ($responseProject->failed()) {
            return redirect()->back()->withErrors('Failed to fetch project data.');
        }

        $projects = $responseProject->json()['data'];

        $responseDocAct = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activity-docs/search?activity_id='.$id);

        if ($responseDocAct->failed()) {
            return redirect()->back()->withErrors('Failed to fetch project data.');
        }

        $countDocAct = count($responseDocAct->json()['data']);

        return view('pages.activity.form', compact('activity', 'projects', 'countDocAct'))->with(['title' => 'activity', 'status' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'project_id' => 'not_in:#',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $accessToken = session('user.access_token');

        // dd($request->all());
        $response = Http::withToken($accessToken)->patch('https://bepm.hanatekindo.com/api/v1/activities/'.$id, [
            'project_id' => $request->input('project_id'),
            'title' => $request->input('title'),
            'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
            'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
        ]);

        // dd($response->json());

        if ($response->json()['status'] == 400) {
            $errors = $response->json()['errors'];

            // Return the errors to the view, keeping old input data
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('activity.index')->with('success', 'Project edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete('https://bepm.hanatekindo.com/api/v1/activities/'.$id);

        if ($response->failed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Activity.',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Activity deleted successfully.',
        ]);
    }

    public function destroyDoc(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete('https://bepm.hanatekindo.com/api/v1/activity-docs/'.$id);

        if ($response->failed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete document.',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Document deleted successfully.',
        ]);
    }
}
