<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class ActivityController extends Controller
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

        $this->lastRoute = Route::currentRouteName();

        $accessToken = session('user.access_token');

        if(session('user.role') == 'SUPERADMIN'){
            $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activities/search', [
                'name' => $q,
                'limit' => $perPage,
                'page' => $page
            ]);
        } else {
            $project_id = "";
            for($i = 0; $i < count(session('user.project_id')); $i++){
                if($i == 0){
                    $project_id = session('user.project_id')[$i];
                } else {
                    $project_id .= ",".session('user.project_id')[$i];
                }
            }

            $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activities/search', [
                'project_id' => $project_id,
                'name' => $q,
                'limit' => $perPage,
                'page' => $page
            ]);
        }

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch activities.');
        }

        $activities = $response->json();
        $total = $response->json()['pagination']['total'];

        $results = new LengthAwarePaginator(
            collect($activities),
            $total,
            $perPage,
            $page,
            ['path' => url('activity')]
        );

        return view('pages.activity.index', compact('results'))->with(['title' => 'activity']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd(session('lastRoute'));
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

            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('activity.index')->with('success', 'Project created successfully.');
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

        $responseDocActivity = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activity-docs/search?activity_id='.$id.'&limit=1000');

        if ($responseDocActivity->failed()) {
            return redirect()->back()->withErrors('Failed to fetch doc activity data.');
        }

        $responseCategoryDocActivity = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activity-doc-categories');

        if ($responseCategoryDocActivity->failed()) {
            return redirect()->back()->withErrors('Failed to fetch doc category of activity data.');
        }

        $data = [
            'activity'       => $responseActivity->json()['data'],
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
        // dd(session('lastRoute'));
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

        return $response->json();

        if ($response->json()['status'] == 400 || $response->json()['status'] == 500) {
            $errors = $response->json()['errors'];

            // return redirect()->back()->withInput()->withErrors($errors);
            return response()->json([
                'status' => 'error',
                'message' => $error
            ]);
        }

        // return redirect()->back()->with('success', 'Activity Doc created successfully.');
        return response()->json([
            'status' => 'success',
            'message' => $response->json()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $accessToken = session('user.access_token');

        $responseActivity = Http::withToken($accessToken)->get("https://bepm.hanatekindo.com/api/v1/activities/{$id}");

        if ($responseActivity->failed()) {
            return redirect()->back()->withErrors('Failed to fetch category details.');
        }

        $activity = $responseActivity->json()['data'][0];

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

        if ($response->json()['status'] == 400 || $response->json()['status'] == 500) {
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

        if ($response->json()['status'] == 400 || $response->json()['status'] == 500) {
            $errors = $response->json()['errors'];

            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('activity.index')->with('success', 'Activity deleted successfully.');
    }

    public function destroyDoc(string $id)
    {
        $accessToken = session('user.access_token');

        $response = Http::withToken($accessToken)->delete('https://bepm.hanatekindo.com/api/v1/activity-docs/'.$id);

        if ($response->json()['status'] == 400 || $response->json()['status'] == 500) {
            $errors = $response->json()['errors'];

            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->back()->with('success', 'Doc Activity update successfully.');
    }
}
