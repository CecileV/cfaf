@extends('layouts.admin')
@section('title', 'Articles')

@section('right')
    @can('create', App\Article::class)
        <a href="{{ route('admin.article.add') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter un Article
        </a>     
    @endcan
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-striped DataTable">
            <thead class="thead-dark">
                <tr>
                    <th> Titre </th>
                    <th> Slug </th>
                    <th> Auteur </th>
                    <th> Date de création </th>
                    <th> Dernière modification </th>
                    <th> État </th>
                    <th data-orderable="false"> Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td> {{ $article->title }} </td>
                        <td> {{ $article->slug }} </td>
                        <td> 
                            @if($article->creator)
                                {{ $article->creator->name }} 
                            @endif
                        </td>
                        <td> {{ $article->created_at->format('d/m/Y à H:i:s') }} </td>
                        <td> {{ $article->updated_at->format('d/m/Y à H:i:s') }} </td>
                        <td>
                            @if($article->draft)
                                @can('unpublish', $article)
                                    <a href="javascript:;" class="drafted" data-toggle="tooltip" data-placement="left" title="Brouillon" data-id="{{ $article->id }}">
                                        <i class="fas fa-circle text-warning"></i>
                                    <a>
                                @endcan
                            @else
                                @can('publish', $article)
                                    <a href="javascript:;" class="undrafted" data-toggle="tooltip" data-placement="left" title="Publié" data-id="{{ $article->id }}">
                                        <i class="fas fa-circle text-success"></i>
                                    </a>
                                @endcan
                            @endif
                        </td>
                        <td>    
                            @can('update', $article)
                                <a href="{{ route('admin.article.edit', $article->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete', $article)
                                <a href="javascript:;" class="text-danger deleted" data-id="{{ $article->id }}">
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
            let articleId = $(this).data('id');
            if(confirm('Êtes-vous sûr de vouloir supprimer cette article ?')){
                $.ajax({
                    url : "{{ route('admin.ajax.article.delete') }}",
                    type : 'POST',
                    data : {
                        "_token": '{{ csrf_token() }}',
                        "id": articleId
                    },
                    success : function(json){
                        if(json.status){
                            document.location.href = "{{ route('admin.articles') }}";
                        } else {
                            alert('Il y a eu une erreur.')
                        }
                    }
                });                
            }
        });

        $(document).on('click','.undrafted', function() {
            let articleId = $(this).data('id');
            if(confirm('Êtes-vous sûr de vouloir dépublier cette article ?')){
                $.ajax({
                    url : "{{ route('admin.ajax.article.unpublish') }}",
                    type : 'POST',
                    context: this,
                    data : {
                        "_token": '{{ csrf_token() }}',
                        "id": articleId
                    },
                    success : function(json){
                        if(json.status){
                            $(this).toggleClass('undrafted drafted');
                            $(this).children().toggleClass('text-success text-warning');
                        } else {
                            alert('Il y a eu une erreur.')
                        }
                    }
                });                
            }
        });

         $(document).on('click','.drafted',function() {
            let articleId = $(this).data('id');
            if(confirm('Êtes-vous sûr de vouloir publier cette article ?')){
                $.ajax({
                    url : "{{ route('admin.ajax.article.publish') }}",
                    type : 'POST',
                    context: this,
                    data : {
                        "_token": '{{ csrf_token() }}',
                        "id": articleId
                    },
                    success : function(json){
                        if(json.status){
                            $(this).toggleClass('drafted undrafted');
                            $(this).children().toggleClass('text-warning text-success');
                        } else {
                            alert('Il y a eu une erreur.')
                        }
                    }
                });                
            }
        });

        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endsection