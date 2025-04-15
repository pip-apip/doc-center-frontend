<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function view;

class ActivityController extends Controller
{
    public function index()
    {
        return view('pages.activity2', ['title' => 'Activity']);
    }

    public function activity_project($id)
    {
        return view('pages.activityByProject', [
            'title' => 'Activity',
            'id' => $id
        ]);
    }
}
