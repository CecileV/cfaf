<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ContactController extends Controller
{
    public function getForm()
    {
        return view('contact.index');
    }

//    public function postForm(ContactRequest $request)
//    {
//        Mail::send('email_contact', $request->all(), function($message)
//        {
//            $message->to('vinsoune.vm@gmail.com')->subject('contact');
//        });
//        return view('contact.confirmation');
//    }
}
