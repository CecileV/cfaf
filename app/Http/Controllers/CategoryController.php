<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategory;
use App\Category;

class CategoryController extends Controller
{
    /* -- ESPACE PUBLIC -- */
    public function show() {
        return view('category.show');
    }

    /* -- ESPACE ADMINISTRATION -- */
    public function list() {
        $categories = Category::get();
        return view('admin.category.list', compact('categories'));
    }

    public function edit() {
        return view('admin.category.edit');
    }

    public function add() {
        return view('admin.category.add');
    }

    public function update() {
        return redirect(route('admin.categories'));
    }

    public function store(StoreCategory $request) {

        $category = new Category;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->save();

        return redirect(route('admin.categories'));
    }

    /* --- AJAX --- */
    public function delete(Request $request) {
        $id = $request->input('id');
        $category = Category::findOrFail($id);
        if( $category->delete() ){
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function restore() {
        return redirect(route('admin.categories'));
    }
}
