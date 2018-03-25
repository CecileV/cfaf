<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class GlobalController extends Controller
{
    public function index() {
         /*
        *   Get latest (4) Articles
        */
        $articles = Article::where('draft', 0)->orderBy('updated_at', 'DESC')->take(4)->get();
        return view('welcome', compact('articles'));
    }

    public function map() {
        return view('map');
    }

    public function mentions() {
        return view('mentions');
    }
}
