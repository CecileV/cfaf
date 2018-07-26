@extends('layouts.admin')
@section('title', 'Modifier une Espèce')
@section('content')
    <form method="POST" action="{{ route('admin.specie.update', $specie->id) }}"  enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label">Nom *</label>
            <input type="text" class="form-control" name="name" placeholder="Entrez le nom" value="{{ $specie->name }}">
        </div>
        <div class="form-group">
            <label class="control-label">Identification *</label>
            <input type="checkbox" class="form-control" name="identification" placeholder="Presence d'identification" value="{{ $specie->identification }}">
        </div>
        <div class="form-group">
            <label class="control-label">Description </label>
            <textarea class="form-control" name="description" placeholder="Entrez la description" rows="5" >{{ $specie->description }}</textarea>
        </div>
        @can('update', $specie)
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