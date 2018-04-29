<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTag;
use App\Tag;
use Auth;

class TagController extends Controller
{
    /* -- ESPACE PUBLIC -- */
    public function show() {
        return view('tag.show');
    }

    /* -- ESPACE ADMINISTRATION -- */
    public function list() {
        if (Auth::user()->can('list', Tag::class)) {
            $tags = Tag::get();
            return view('admin.tag.list', compact('tags'));
        }
        return redirect(route('admin.dashboard'));
    }

    public function edit($id) {
        $tag = Tag::findOrFail($id);   
        if (Auth::user()->can('update', $tag)) {
            return view('admin.tag.edit', compact('tag'));
        }
        return redirect(route('admin.tags'));
    }

    public function add()  {
        if (Auth::user()->can('create', Tag::class)) {
            return view('admin.tag.add');
        }
        return redirect(route('admin.tags'));
    }

    public function update($id, StoreTag $request) {
        $tag = Tag::findOrFail($id);
        if (Auth::user()->can('update', $tag)) {
            $tag->name = $request->name;
            $tag->description = $request->description;
            $tag->save();
            return redirect( route('admin.tag.edit', compact('id')) )->withSuccess('Mot Clé Modifié');
        }
        return redirect(route('admin.tags'));
    }

    public function store(StoreTag $request) {
        if (Auth::user()->can('create', Tag::class)) {
            $tag = new Tag;
            $tag->name = $request->name;
            $tag->slug = str_slug( $request->name , '-' );
            $tag->description = $request->description;
            $tag->save();
        }
        return redirect(route('admin.tags'));
    }

    /* --- AJAX --- */
    public function delete(Request $request) {
        $id = $request->input('id');
        $tag = Tag::findOrFail($id);
        if (Auth::user()->can('delete', $tag)) {
            if( $tag->delete() ){
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }

    public function restore() {
        return redirect(route('admin.tags'));
    }
}
