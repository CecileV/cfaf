@extends('layouts.admin')
@section('title', 'Liste des espèces')
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
                <th> Slug </th>
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
                    <td> {{ $specie->slug }} </td>
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
                            <a href="{{ route('admin.category.edit', $category->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endcan
                        @can('delete', $category)
                            <a href="javascript:;" class="text-danger deleted" data-id="{{ $category->id }}">
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
    @can('delete', $category)
        <script type="text/javascript">
            $('.deleted').click(function(){
                let categoryId = $(this).data('id');
                if(confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')){
                    $.ajax({
                        url : "{{ route('admin.ajax.category.delete') }}",
                        type : 'POST',
                        data : {
                            "_token": '{{ csrf_token() }}',
                            "id": categoryId
                        },
                        success : function(json){
                            if(json.status){
                                document.location.href = "{{ route('admin.categories') }}";
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