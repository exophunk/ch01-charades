@extends('layouts.app')

@section('content')


    <div class="page-create-room">
    <form class="page-create-room__form" method="POST" action="{{ route('action-create-room') }}">
        @csrf

        <div class="pane-top"></div>

        <div class="pane-fields">
            <div class="field field-text field-name @error('name') field--is-invalid @enderror">
                <input id="name" placeholder="" type="text" name="name" class="field__input" value="{{ old('name') }}">
                <label for="name" class="field__label">{{ __('Spielname') }}</label>

                @error('name')
                    <div class="field__error" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="pane-bottom">
            <button type="submit" class="button-submit">
                {{ __('Weiter') }}
            </button>
        </div>

    </form>
</div>

@endsection
