@extends('layouts.admin')
@section('title', 'Rôles')
@section('right')
    @can('create', App\Role::class)
        <a href="{{ route('admin.role.add') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter un Rôle
        </a>
    @endcan
@endsection
@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-striped DataTable">
            <thead class="thead-dark">
                <tr>
                    <th> Slug </th>
                    <th> Nom </th>
                    <th> Auteur </th>     
                    <th> Date de création </th>
                    <th> Dernière modification </th>
                    <th data-orderable="false"> Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td> {{ $role->slug }} </td>
                        <td> {{ $role->name }} </td>
                        <td>
                            @if($role->creator)
                                {{ $role->creator->name }} 
                            @endif
                        </td>
                        <td> {{ $role->created_at->format('d/m/Y à H:i:s') }}</td>
                        <td> {{ $role->updated_at->format('d/m/Y à H:i:s') }}</td>
                        <td>    
                            @can('update', $role)
                                <a href="{{ route('admin.role.edit', $role->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete', $role)
                                <a href="javascript:;" class="text-danger deleted" data-id="{{ $role->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('jscontent')
    <script type="text/javascript">
            $('.deleted').click(function(){
                let id = $(this).data('id');
                if(confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')){
                    $.ajax({
                        url : "{{ route('admin.ajax.role.delete') }}",
                        type : 'POST',
                        data : {
                            "_token": '{{ csrf_token() }}',
                            "id": id
                        },
                        success : function(json){
                            if(json.status){
                                document.location.href = "{{ route('admin.roles') }}";
                            } else {
                                alert('Il y a eu une erreur.')
                            }
                        }
                    });                
                }
            });
    </script>
@endsection