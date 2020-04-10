@extends('layouts.app')

@section('content')



<div class="page-login">
    <form class="page-login__form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="pane-top">
            <a href="/register" class="button-sign-up">
                {{ __('Neuer Account') }}
            </a>
        </div>

        <div class="pane-fields">
            <div class="field field-text field-email @error('email') field--is-invalid @enderror">
                <input id="email" placeholder="" type="email" name="email" class="field__input" value="{{ old('email') }}" autocomplete="email" autofocus>
                <label for="email" class="field__label">{{ __('E-Mail') }}</label>

                @error('email')
                    <div class="field__error" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="field field-text field-password @error('password') field--is-invalid @enderror">
                <input id="password" placeholder="" type="password" name="password" class="field__input" autocomplete="current-password" autofocus>
                <label for="password" class="field__label">{{ __('Passwort') }}</label>

                @error('password')
                    <div class="field__error" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="field field-checkbox">
                <input class="field__input" placeholder="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="field__label">{{ __('Eingeloggt bleiben') }}</label>
            </div>
        </div>

        <div class="pane-bottom">

            @if (Route::has('password.request'))
                <a class="link-reset-passwort" href="{{ route('password.request') }}">
                    {{ __('Passwort vergessen?') }}
                </a>
            @endif

            <button type="submit" class="button-submit">
                {{ __('Login') }}
            </button>
        </div>

    </form>
</div>

@endsection
