@extends('layouts.admin')
@section('title', 'Modifier un Article')
@section('content')
    <form method="POST" action="{{ route('admin.article.update', $article) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label">Titre *</label>
                    <input type="text" class="form-control" name="title" placeholder="Mon article" value="{{ $article->title }}">
                </div>        
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="pictureSelect">Image</label>
                    <label class="custom-file">
                        <input type="file" id="pictureSelect" class="custom-file-input" name="picture">
                        <span class="custom-file-control">Choisir une image...</span>
                    </label>
                     @if($article->picture)
                        <img src="{{ url($article->picture) }}" class="img-thumbnail">
                    @endif
                </div>
            </div>
           

            <div class="col">
                <div class="form-group">
                    <label for="categorySelect">Categorie</label>
                    <select class="form-control" id="category" name="category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $article->categories()->first()->id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="content">Article *</label>
                    <textarea name="content" class="form-control ckeditor" id="content" rows="15">
                        {{ $article->content }}
                    </textarea>
                </div>
            </div>
        </div>

        <div class="text-right">
            @can('update', $article)
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Enregistrer
                </button>
            @endcan 
            @can('delete', $article)
                <button type="button" class="btn btn-danger deleted">
                    <i class="fas fa-trash-alt"></i> Supprimer
                </button>
            @endcan 
        </div>
    </form>
    <hr/>
    <small>
        Création le {{ $article->created_at->format('d/m/Y à H:m') }} par {{ $article->creator->name }}
        @if( $article->updated_at && $article->updator )
            <br/> Dernière modification le {{ $article->updated_at->format('d/m/Y à H:m') }} par {{ $article->updator->name }}
        @endif
    </small>
@endsection

@section('jscontent')
    @can('delete', $article)
        <script type="text/javascript">
            $('.deleted').click(function(){
                if(confirm('Êtes-vous sûr de vouloir supprimer cette article ?')){
                    $.ajax({
                        url : "{{ route('admin.ajax.article.delete') }}",
                        type : 'POST',
                        data : {
                            "_token": '{{ csrf_token() }}',
                            "id": '{{ $article->id }}'
                        },
                        success : function(json){
                            if(json){
                                document.location.href = "{{ route('admin.articles') }}";
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