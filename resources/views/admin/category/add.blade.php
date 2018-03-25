@extends('layouts.admin')
@section('title', 'Ajouter une Catégorie')
@section('content')
    <form method="POST" action="{{ route('admin.category.store') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label">Nom de la Catégorie *</label>
            <input type="text" class="form-control" name="name" placeholder="Entrez le nom" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label class="control-label">Slug de la Catégorie</label>
            <input type="text" class="form-control" name="slug" placeholder="Entrez le slug" value="{{ old('slug') }}">
        </div>            
        <div class="form-group">
            <label class="control-label">Description de la Catégorie</label>
            <textarea class="form-control" name="description" placeholder="Entrez la description" rows="5" >{{ old('slug') }}</textarea>
        </div>   
        <div class="text-right">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle"></i> Valider
            </button>
        </div>            
    </form>
@endsection

@section('jscontent')

@endsection