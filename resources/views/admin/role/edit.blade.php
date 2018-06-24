@extends('layouts.admin')
@section('title', 'Modifier un Rôle')
@section('content')
    <form method="POST" action="{{ route('admin.role.update', $role->id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label">Nom *</label>
                    <input type="text" class="form-control" name="description" placeholder="Nom" value="{{ $role->description }}">
                </div>        
            </div>
            
            <div class="col">   
                <div class="form-group">
                    <label class="control-label">Slug</label>
                    <input type="text" class="form-control" name="name" value="{{ $role->name }}" disabled>
                </div>               
            </div>
        </div>
        @can('update', $role)
            <div class="text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Valider
                </button>
            </div>
        @endcan
    </form>
    <hr/>
    <small>
        Création le {{ $role->created_at->format('d/m/Y à H:m') }} par @if($role->creator) {{ $role->creator->name }} @endif
        @if( $role->updated_at && $role->updator )
            <br/> Dernière modification le {{ $role->updated_at->format('d/m/Y à H:m') }} par {{ $role->updator->name }}
        @endif
    </small>
    

@endsection

@section('jscontent')

@endsection