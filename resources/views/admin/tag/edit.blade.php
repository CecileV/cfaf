@extends('layouts.admin')
@section('title', 'Modifier un Mot Clé')
@section('content')
    <form method="POST" action="{{ route('admin.tag.update', $tag->id) }}"  enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label">Nom *</label>
            <input type="text" class="form-control" name="name" placeholder="Entrez le nom" value="{{ $tag->name }}">
        </div>          
        <div class="form-group">
            <label class="control-label">Description </label>
            <textarea class="form-control" name="description" placeholder="Entrez la description" rows="5" >{{ $tag->description }}</textarea>
        </div>   
        @can('update', $tag)
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