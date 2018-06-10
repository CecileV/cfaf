@extends('layouts.admin')
@section('title', 'Ajouter un Article')
@section('content')
    <form method="POST" action="{{ route('admin.article.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="control-label">Titre *</label>
                    <input type="text" class="form-control" name="title" placeholder="Mon article" value="{{old('title')}}">
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
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="categorySelect">Categorie</label>
                    <select class="form-control" id="category" name="category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="content">Article *</label>
                    <textarea class="form-control ckeditor1" id="content" rows="15" name="content">{{old('content')}}</textarea>
                </div>
            </div>
        </div>

        <div class="text-right">
            @can('create', App\Article::class)
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Enregistrer
                </button>
            @endcan 
            <button type="button" class="btn btn-danger aborted">
                <i class="fas fa-trash-alt"></i> Annuler
            </button>
        </div>

    </form>
@endsection

@section('jscontent')
    <script type="text/javascript">
        $('.aborted').click(function(){
            if(confirm('Êtes-vous sûr de vouloir annuler la création de l\'article ?')){
                document.location.href = "{{ route('admin.articles') }}";            
            }
        });

        $('input[type=file]').change( function(){
            if (this.files && this.files[0]) {
                $(this).next().html(this.files[0].name);
            }
        });
    </script>
@endsection