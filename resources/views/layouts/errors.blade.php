@if ( $errors->any() )
    <div class="alert alert-danger" role="alert">
        <ol> 
            @foreach ( $errors->all() as $error ) 
                <li>{{ $error }}</li> 
            @endforeach 
        </ol> 
    </div>
@endif
@if ( session('success') && !$errors->any() )
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
@endif