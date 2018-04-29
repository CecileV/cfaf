@extends('layouts.admin')
@section('title', 'Ajouter un Rôle')
@section('content')
    <form method="POST" action="{{ route('admin.role.store') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label class="control-label">Nom *</label>
            <input type="text" class="form-control" name="name" placeholder="Entrez le nom" value="{{ old('name') }}">
        </div>           
        @can('create', App\Role::class)
            <div class="text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Valider
                </button>
            </div>          
        @endcan  
    </form>
@endsection

@section('jscontent')

@endsection