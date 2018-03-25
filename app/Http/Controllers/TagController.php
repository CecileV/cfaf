<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
class TagController extends Controller
{
    /* -- ESPACE PUBLIC -- */
    public function show() {
        return view('tag.show');
    }

    /* -- ESPACE ADMINISTRATION -- */
    public function list() {
        $tags = Tag::get();
        return view('admin.tag.list', compact('tags'));
    }

    public function edit() {
        return view('admin.tag.edit');
    }

    public function add() {
        return view('admin.tag.add');
    }

    public function update() {
        return redirect(route('admin.tags'));
    }

    public function store() {
        return redirect(route('admin.tags'));
    }

    /* --- AJAX --- */
    public function delete(Request $request) {
        $id = $request->input('id');
        $tag = Tag::findOrFail($id);
        if( $tag->delete() ){
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function restore() {
        return redirect(route('admin.tags'));
    }
}
