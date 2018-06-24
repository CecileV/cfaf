<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Contact;

class ContactController extends Controller
{
    public function getForm()
    {
        return view ('contact.index');
    }

    public function postForm(ContactRequest $request)
    {
    	var_dump($request);
        //$contact = $request->all();
    }
}
