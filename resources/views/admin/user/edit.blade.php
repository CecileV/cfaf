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
            </div>

            <div class="col">
                @if( !Auth::user()->hasAnyRole(array('admin', 'moderator')) )
                    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                        <label for="old_password" class="control-label">Mot de Passe</label>
                        <input id="old_password" type="password" class="form-control" name="old_password" required>
                    </div>
                @endif
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">Nouveau Mot de Passe</label>
                    <input id="password" type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="control-label">Confirmation</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>
        </div>
         
        <div class="text-right">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle"></i> Valider
            </button>
            @if( Auth::user()->hasAnyRole(array('admin', 'moderator')) )
                <button type="button" class="btn btn-danger deleted">
                    <i class="fas fa-trash-alt"></i> Supprimer
                </button>
            @endif
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
    @if(Auth::user()->hasAnyRole(array('admin', 'moderator')))
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
    @endif
@endsection