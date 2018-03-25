@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <section class="col-md-8 col-md-offset-2">
                <header>
                    <h2>{{ $article->title }}</h2>
                </header>
                <img class="card-img-top" src="{{ url($article->picture) }}" alt="[ photo : {{ $article->slug }} ]">
                <article>
                    {!! $article->content !!}
                </article>
                <footer>
                    Auteur: {{ $article->creator->name }}
                </footer>
            </section>
        </div>
    </div>
@endsection