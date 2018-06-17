<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getForm()
    {
        return view ('contact.index');
    }

    public function postForm()
    {
        //$contact = $request->all();
    }
}
