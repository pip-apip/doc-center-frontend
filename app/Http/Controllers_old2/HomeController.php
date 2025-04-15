<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $accessToken = session('user.access_token');
        $response = Http::withToken($accessToken)->get('https://bepm.hanatekindo.com/api/v1/activity-docs');

        if ($response->failed()) {
            return redirect()->back()->withErrors('Failed to fetch activity doc list.');
        }

        $activityDoc = $response->json()['data'];

        return view('pages.home', compact('activityDoc'))->with(['title' => 'Home']);
    }
}
