@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tableau de Bord</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Tu es connecté en tant que {{Auth::user()->name}}.</p>
                    <p>Rôle(s) : 
                    @foreach (Auth::user()->roles as $role)
                        <br> - {{$role->name}}
                    @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
