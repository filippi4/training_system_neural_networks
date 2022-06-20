<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Session;

class HomeController extends Controller
{
    public function pageHome() {
        return view('home', ['tags' => Tag::all()]);
    }
}
