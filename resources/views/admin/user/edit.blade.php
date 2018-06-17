@extends('layouts.admin')
@section('title', 'Modifier un Utilisateur')
@section('content')
    <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label">Identifiant *</label>
                    <input type="text" class="form-control" name="name" placeholder="John Smith" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Adresse E-Mail *</label>
                    <input type="email" class="form-control" name="email" placeholder="exemple@exemple.com" value="{{ $user->email }}">
                </div>   
                @can('update_role', $user)
                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label for="role" class="control-label">Rôle</label>
                        <select class="form-control" name="role">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}" @if($user->hasRole($role->name)) selected @endif >
                                    {{$role->description}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endcan
                @cannot('update_role', $user)
                    <input type="hidden" name="role" value="{{$user->roles()->first()->id}}">
                @endcannot

            </div>

            @can('update_password', $user)
                <div class="col">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Nouveau Mot de Passe</label>
                        <input id="password" type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="control-label">Confirmation</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>
            @endcan
        </div>
         
        <div class="text-right">
            @can('update', $user)
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Valider
                </button>
            @endcan
            @can('delete', $user)
                <button type="button" class="btn btn-danger deleted">
                    <i class="fas fa-trash-alt"></i> Supprimer
                </button>
            @endcan
        </div>            
        

    </form>
    <hr/>
    <small>
        Inscription : {{ $user->created_at->format('d/m/Y à H:m') }} |
        Dernière Connexion : 
        @if($user->last_connexion_at) 
        {{ $user->last_connexion_at->format('d/m/Y à H:m') }}
        @endif 
    </small>


@endsection

@section('jscontent')
    @can('delete', $user)
        <script type="text/javascript">
            $('.deleted').click(function(){
                if(confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')){
                    $.ajax({
                        url : "{{ route('admin.ajax.user.delete') }}",
                        type : 'POST',
                        data : {
                            "_token": '{{ csrf_token() }}',
                            "id": '{{ $user->id}}'
                        },
                        success : function(json){
                            if(json){
                                document.location.href = "{{ route('admin.users') }}";
                            } else {
                                alert('Il y a eu une erreur.')
                            }
                        }
                    });                
                }
            });
        </script>
    @endcan
@endsection