@extends('layouts.admin')
@section('title', 'Liste des Utilisateurs')

@section('right')
    @if(Auth::user()->hasAnyRole(array('admin', 'moderator')))
        <a href="{{ route('admin.user.add') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter un Utilisateur
        </a>
    @endif        
@endsection

@section('content')
<div class="table-responsive">
    <table class="table table-bordered table-striped DataTable">
        <thead class="thead-dark">
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Inscription</th>
                @if( Auth::user()->hasAnyRole(array('admin', 'moderator')) )
                    <th data-orderable="false">Action</th>     
                @endif                           
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td> {{$user->name}} </td>
                    <td> {{$user->email}} </td>
                    <td> {{$user->roles()->first()->description}} </td>
                    <td> {{$user->created_at->format('d/m/Y')}} </td>
                    @if( Auth::user()->hasAnyRole(array('admin', 'moderator')) )
                        <td>
                            <a href="{{ route('admin.user.edit', $user->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:;" class="text-danger deleted" data-id="{{ $user->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('jscontent')
    @if(Auth::user()->hasAnyRole(array('admin', 'moderator')))
        <script type="text/javascript">
            $('.deleted').click(function(){
                iUserId = $(this).data('id');
                if(confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')){
                    $.ajax({
                        url : "{{ route('admin.ajax.user.delete') }}",
                        type : 'POST',
                        data : {
                            "_token": '{{ csrf_token() }}',
                            "id": iUserId
                        },
                        success : function(json){
                            if(json){
                                window.location.href = "{{ route('admin.users') }}";
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