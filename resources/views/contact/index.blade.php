@extends('layouts.app')

@section('content')
    <div>
        <h1>Formulaire de contact</h1>
        {!! Form::open( array('url' => action('ContactController@postForm'), 'files'=>true,'method'=>'post') )  !!}

        {{--{!! Form::open(['url' => 'contact']) !!}--}}
        <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Votre nom']) !!}
            {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
        </div>
        <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Votre email']) !!}
            {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
        </div>
        <div class="form-group {!! $errors->has('text') ? 'has-error' : '' !!}">
            {!! Form::textarea ('text', null, ['class' => 'form-control', 'placeholder' => 'Votre message']) !!}
            {!! $errors->first('text', '<small class="help-block">:message</small>') !!}
        </div>
        {!! Form::submit('Envoyer !', ['class' => 'btn btn-info pull-right']) !!}
        {!! Form::close() !!}

        </div>
    </div>
@stop
