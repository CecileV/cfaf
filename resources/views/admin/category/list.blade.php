@extends('layouts.admin')
@section('title', 'Liste des Catégories')
@section('right')
    <a href="{{ route('admin.category.add') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Ajouter une Categorie
    </a>     
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
                @foreach ($categories as $category)
                    <tr>
                        <td> {{ $category->name }} </td>
                        <td> {{ $category->slug }} </td>
                        <td>
                            @if($category->creator)
                                {{ $category->creator->name }} 
                            @endif
                        </td>
                        <td> {{ $category->description }} </td>
                        <td> {{ $category->created_at->format('d/m/Y à H:i:s') }} </td>
                        <td> {{ $category->updated_at->format('d/m/Y à H:i:s') }}</td>
                        <td>    
                            <a href="{{ route('admin.category.edit', $category->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:;" class="text-danger deleted" data-id="{{ $category->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
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
@endsection