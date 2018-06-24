@extends('layouts.app')
@section('title', "Articles")
@section('content')
    <div class="row">
        @foreach($articles as $article)
            <div class="col-3">
                <article style="margin-bottom: 2%">
                    <div class="card">
                      <img class="card-img-top" src="{{ url($article->getThumb($article->picture)) }}" alt="[ photo : {{ $article->slug }} ]">
                      <div class="card-body">
                        <h1 class="card-title">
                            <a href="{{ route('article', $article->slug) }}" title="{{ $article->title }}">
                                {{ $article->title }}
                            </a>
                        </h1>
                        <a href="{{ route('article', $article->slug) }}" title="{{ $article->title }}">
                            <p class="card-text">{{ substr( strip_tags($article->content), 0, 100) }} ...</p>
                        </a>
                      </div>
                    </div>    
                </article>                
            </div>
        @endforeach
    </div>
@endsection


