<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreArticle;
use App\Article;
use App\Category;
use Auth;

class ArticleController extends Controller
{
    private $storage = 'uploads/articles';

	/* -- ESPACE PUBLIC -- */
    public function show() {
        $articles = Article::where('draft', 0)->orderBy('updated_at', 'DESC')->get();
        return view('articles', compact('articles'));
    }

    public function showOne($slug) {
        $article = Article::where('slug', $slug)->first();
        return view('article', compact('article'));
    }

    /* -- ESPACE ADMINISTRATION -- */
    // View
    public function list() {
        if (Auth::user()->can('list', Article::class)) {
            $articles = Article::get();
            return view('admin.article.list', compact('articles'));
        } else {
            return redirect(route('admin.dashboard'));
        }
    }

    public function edit($id) {
        $article = Article::findOrFail($id);   
        if (Auth::user()->can('update', $article)) {
            $categories = Category::get(['name', 'id']);
            return view('admin.article.edit', compact('article', 'categories'));
        } else {
            return redirect(route('admin.articles'));
        }
    }

    public function add() {
        if (Auth::user()->can('create', Article::class)) {
            $categories = Category::get(['name', 'id']);
            return view('admin.article.add', compact('categories'));
        } else {
            return redirect(route('admin.articles'));
        }
    }

    /*
    *   Update Article
    */
    public function update($id, StoreArticle $request) {
        $article = Article::findOrFail($id);
        if (Auth::user()->can('update', $article)) {
            $article->content = $request->content;
            $article->title = $request->title;
            $article->picture = $request->picture;
            $article->save();

            // Category
            $category = Category::where('id', $request->category)->first();
            $article->categories()->attach($category);

            return redirect( route('admin.article.edit', compact('article')) )->withSuccess('Article Modifié');
        } else {
            return redirect(route('admin.articles'));
        }
    }
    
    /*
    *   Store new Article
    */
    public function store(StoreArticle $request) {
        if (Auth::user()->can('create', Article::class)) {
            $article = new Article;
            $article->draft = 1;
            $article->title = $request->title;
            $article->content = $request->content;
            $article->slug = str_slug( $request->title , '-' );
            $article->picture = $request->picture;
            $article->save();

            // Category 
            $category = Category::where('id', $request->category)->first();
            $article->categories()->attach($category);
        }

        return redirect( route('admin.articles') );
    }

    /* --- AJAX --- */
    public function delete(Request $request) {
        $id = $request->input('id');
        $article = Article::findOrFail($id);
        if (Auth::user()->can('delete', $article)) {
            if( $article->delete() ){
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }

    public function restore() {
        return redirect( route('admin.articles') );
    }

    public function unpublish(Request $request) {
        $id = $request->input('id');
        $article = Article::findOrFail($id);
        if (Auth::user()->can('unpublish', $article)) {
            $article->draft = 1;
            if( $article->save() ) {
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }

    public function publish(Request $request) {
        $id = $request->input('id');
        $article = Article::findOrFail($id);
        if (Auth::user()->can('publish', $article)) {
            $article->draft = 0;
            if( $article->save() ) {
                return response()->json(['status' => true]);
            }
        }
        return response()->json(['status' => false]);
    }
}
