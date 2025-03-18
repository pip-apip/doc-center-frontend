<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    public function admin()
    {
        return view('pages.categoryAdmin', ['title' => 'categoryAdm']);
    }

    public function activity()
    {
        return view('pages.categoryActivity', ['title' => 'categoryAct']);
    }
}
