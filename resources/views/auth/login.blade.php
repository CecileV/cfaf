@extends('layouts.admin')

@section('title', 'Connexion')
@section('content')
    <div>
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">Adresse E-Mail</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="control-label">Mot de Passe</label>
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                    Se souvenir de moi
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Connexion
            </button>

            <a href="{{ route('password.request') }}">
                Mot de passe oublié ?
            </a>
            <p> Pas encore de compte ?  
                <a href="{{ route('register') }}">
                    Inscrivez-vous.
                </a>
            </p>
        </form> 
    </div>
@endsection
