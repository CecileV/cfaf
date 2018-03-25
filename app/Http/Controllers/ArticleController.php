<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreArticle;
use App\Article;
use App\Category;

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
        $articles = Article::get();
        return view('admin.article.list', compact('articles'));
    }

    public function edit($id) {
        $article = Article::findOrFail($id);   
        $categories = Category::get(['name', 'id']);
        return view('admin.article.edit', compact('article', 'categories'));
    }

    public function add() {
        $categories = Category::get(['name', 'id']);
        return view('admin.article.add', compact('categories'));
    }

    /*
    *   Update Article
    */
    public function update($id, StoreArticle $request) {
        $article = Article::findOrFail($id);
        $article->content = $request->content;
        $article->title = $request->title;

        // Slug
        $article->slug = str_replace( array(' ', '\'', '"'), array('_', '', ''), $request->slug ? $request->slug : $request->title );

        // Picture
        if( $request->hasFile('picture') ) {
            $file = $request->file('picture');
            $name = 'article_' . $id . '_' . $file->getClientOriginalName();
            $file->move($this->storage.'/'. date('Y') , $name);
            $article->picture = $this->storage .'/'. date('Y') .'/'. $name;
        }
        $article->save();

        // Category
        $category = Category::where('id', $request->category)->first();
        $article->categories()->attach($category);

        return redirect( route('admin.article.edit', compact('article')) )->withSuccess('Article Modifié');
    }
    
    /*
    *   Store new Article
    */
    public function store(StoreArticle $request) {
        $article = new Article;
        $article->draft = 0;
        $article->title = $request->title;
        $article->content = $request->content;

        // Slug
        $article->slug = strtolower( str_replace( array(' ', '_', '\'', '"'), array('-','-', '', ''), $request->slug ? $request->slug : $request->title ) );
    
        // Picture [ rework name : _{id}_ actually missing ]
        if( $request->hasFile('picture') ) {
            $file = $request->file('picture');
            $name = 'article_' . $file->getClientOriginalName();
            $file->move($this->storage .'/'. date('Y'), $name);
            $article->picture = $this->storage .'/'. date('Y') .'/'. $name;
        }
        $article->save();

        // Category 
        $category = Category::where('id', $request->category)->first();
        $article->categories()->attach($category);

        return redirect( route('admin.articles') );
    }

    /* --- AJAX --- */
    public function delete(Request $request) {
        $id = $request->input('id');
        $article = Article::findOrFail($id);
        if( $article->delete() ){
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function restore() {
        return redirect( route('admin.articles') );
    }

    public function unpublish(Request $request) {
        $id = $request->input('id');
        $article = Article::findOrFail($id);
        $article->draft = 1;
        if( $article->save() ) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function publish(Request $request) {
        $id = $request->input('id');
        $article = Article::findOrFail($id);
        $article->draft = 0;
        if( $article->save() ) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
