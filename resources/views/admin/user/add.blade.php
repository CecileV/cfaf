@extends('layouts.admin')
@section('title', 'Ajouter un Utilisateur')
@section('content')
    <form method="POST" action="{{ route('admin.user.store') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label">Identifiant *</label>
                    <input type="text" class="form-control" name="name" placeholder="John Smith" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Adresse E-Mail *</label>
                    <input type="email" class="form-control" name="email" placeholder="exemple@exemple.com" value="{{ old('email') }}">
                </div>     
                @can('update_role', App\User::class)
                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label for="role" class="control-label">Rôle</label>
                        <select class="form-control" name="role">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}" @if(old('role') == $role->id) selected @endif >
                                    {{$role->description}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endcan
                @cannot('update_role', App\User::class)
                    <input type="hidden" name="role" value="user">
                @endcannot
            </div>

            <div class="col">
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">Mot de Passe</label>
                    <input id="password" type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="control-label">Confirmation</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>
        </div>
        @can('create', App\User::class)
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