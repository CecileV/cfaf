<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategory;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    /* -- ESPACE PUBLIC -- */
    public function show() {
        return view('category.show');
    }

    /* -- ESPACE ADMINISTRATION -- */
    public function list() {
        if (Auth::user()->can('list', Category::class)) {
            $categories = Category::get();
            return view('admin.category.list', compact('categories'));
        }
        return redirect(route('admin.dashboard'));
    }

    public function edit($id) {
        $category = Category::findOrFail($id);   
        if (Auth::user()->can('update', $category)) {
            return view('admin.category.edit', compact('category'));
        }
        return redirect(route('admin.categories'));
    }

    public function add() {
        if (Auth::user()->can('create', Category::class)) {
            return view('admin.category.add');
        }
        return redirect(route('admin.categories'));
    }

    public function update($id, StoreCategory $request) {
        $category = Category::findOrFail($id);
        if (Auth::user()->can('update', $category)) {
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();
            return redirect( route('admin.category.edit', compact('id')) )->withSuccess('Catégorie Modifiée');
        }
        return redirect(route('admin.categories'));
    }

    public function store(StoreCategory $request) {
        if (Auth::user()->can('create', Category::class)) {
            $category = new Category;
            $category->name = $request->name;
            $category->slug = str_slug( $request->name , '-' );
            $category->description = $request->description;
            $category->save();
        }
        return redirect(route('admin.categories'));
    }

    /* --- AJAX --- */
    public function delete(Request $request) {
        $id = $request->input('id');
        $category = Category::findOrFail($id);
        if (Auth::user()->can('delete', $category)) {
            if( $category->delete() ){
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }

    public function restore() {
        return redirect(route('admin.categories'));
    }
}
