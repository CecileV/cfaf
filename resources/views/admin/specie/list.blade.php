@extends('layouts.admin')
@section('title', 'Liste des Espèce')
@section('right')
    @can('create', App\Specie::class)
        <a href="{{ route('admin.specie.add') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter une Espèce
        </a>     
    @endcan
@endsection
@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-striped DataTable">
            <thead class="thead-dark">
                <tr>
                    <th> Nom </th>
                    <th> identification </th>
                    <th> Auteur </th>
                    <th> Description </th>
                    <th> Date de création </th>
                    <th> Dernière modification </th>
                    <th data-orderable="false"> Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($species as $specie)
                    <tr>
                        <td> {{ $specie->name }} </td>
                        <td> {{ $specie->identification }} </td>
                        <td>
                            @if($specie->creator)
                                {{ $specie->creator->name }}
                            @endif
                        </td>
                        <td> {{ $specie->description }} </td>
                        <td> {{ $specie->created_at->format('d/m/Y à H:i:s') }} </td>
                        <td> {{ $specie->updated_at->format('d/m/Y à H:i:s') }}</td>
                        <td>    
                            @can('update', $specie)
                                <a href="{{ route('admin.specie.edit', $specie->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete', $specie)
                                <a href="javascript:;" class="text-danger deleted" data-id="{{ $specie->id }}">
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
    @can('delete', $specie)
        <script type="text/javascript">
            $('.deleted').click(function(){
                let categoryId = $(this).data('id');
                if(confirm('Êtes-vous sûr de vouloir supprimer cette espèce ?')){
                    $.ajax({
                        url : "{{ route('admin.ajax.specie.delete') }}",
                        type : 'POST',
                        data : {
                            "_token": '{{ csrf_token() }}',
                            "id": specieId
                        },
                        success : function(json){
                            if(json.status){
                                document.location.href = "{{ route('admin.species') }}";
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