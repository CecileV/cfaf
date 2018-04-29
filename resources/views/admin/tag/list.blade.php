@extends('layouts.admin')
@section('title', 'Mots Clés')
@section('right')
    <a href="{{ route('admin.tag.add') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Ajouter un mot-clé
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
                @foreach ($tags as $tag)
                    <tr>
                        <td> {{ $tag->name }} </td>
                        <td> {{ $tag->slug }} </td>
                        <td>
                            @if($tag->creator)
                                {{ $tag->creator->name }} 
                            @endif
                        </td>
                        <td> {{ $tag->description }} </td>
                        <td> {{ $tag->created_at->format('d/m/Y à H:i:s') }}</td>
                        <td> {{ $tag->updated_at->format('d/m/Y à H:i:s') }}</td>
                        <td>    
                            @can('update', $tag)
                                <a href="{{ route('admin.tag.edit', $tag->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete', $tag)
                                <a href="javascript:;" class="text-danger deleted" data-id="{{ $tag->id }}">
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
            let tagId = $(this).data('id');
            if(confirm('Êtes-vous sûr de vouloir supprimer ce mot-clé ?')){
                $.ajax({
                    url : "{{ route('admin.ajax.tag.delete') }}",
                    type : 'POST',
                    data : {
                        "_token": '{{ csrf_token() }}',
                        "id": tagId
                    },
                    success : function(json){
                        if(json.status){
                            document.location.href = "{{ route('admin.tags') }}";
                        } else {
                            alert('Il y a eu une erreur.')
                        }
                    }
                });                
            }
        });
    </script>
@endsection