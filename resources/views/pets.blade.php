@extends('layouts.app')
@section('title', "Pets")
@section('content')
    <div class="row">
        @foreach($pets as $pet)
            <div class="col-3">
                <article style="margin-bottom: 2%">
                    <div class="card">
                        <p>coucou</p>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
@endsection
