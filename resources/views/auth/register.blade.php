@extends('layouts.app')

@section('content')



<div class="page-signup">
    <form class="page-signup__form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="pane-top">
            <a href="/">Zurück</a>
        </div>

        <div class="pane-fields">
            <div class="field field-text field-name @error('name') field--is-invalid @enderror">
                <input id="name" placeholder="" type="name" name="name" class="field__input" value="{{ old('name') }}" autocomplete="name" autofocus>
                <label for="name" class="field__label">{{ __('Name') }}</label>
            </div>

            <div class="field field-text field-email @error('email') field--is-invalid @enderror">
                <input id="email" placeholder="" type="email" name="email" class="field__input" value="{{ old('email') }}" autocomplete="email">
                <label for="email" class="field__label">{{ __('E-Mail') }}</label>
            </div>

            <div class="field field-text field-password @error('password') field--is-invalid @enderror">
                <input id="password" placeholder="" type="password" name="password" class="field__input" autocomplete="new-password">
                <label for="password" class="field__label">{{ __('Passwort') }}</label>
            </div>

            <div class="field field-text field-password_confirmation @error('password') field--is-invalid @enderror">
                <input id="password_confirmation" placeholder="" type="password" name="password_confirmation" class="field__input" autocomplete="new-password">
                <label for="password_confirmation" class="field__label">{{ __('Passwort Bestätigen') }}</label>
            </div>


        </div>

        <div class="pane-bottom">
            <button type="submit" class="button-submit">
                {{ __('Los!') }}
            </button>
        </div>

    </form>
</div>

@endsection
