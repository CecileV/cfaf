@extends('layouts.admin')
@section('title', 'Ajouter un Mot Clé')
@section('content')
    <form method="POST" action="{{ route('admin.tag.store') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label">Nom *</label>
            <input type="text" class="form-control" name="name" placeholder="Entrez le nom" value="{{ old('name') }}">
        </div>           
        <div class="form-group">
            <label class="control-label">Description </label>
            <textarea class="form-control" name="description" placeholder="Entrez la description" rows="5" >{{ old('description') }}</textarea>
        </div>   
        @can('create', App\Tag::class)
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