<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // $all_news = News::all();
        return view('auth/contact/index');
    }
}
