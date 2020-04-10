@extends('layouts.app')

@section('content')

    <div class="page-create-room">


        <h2>Neues Spiel erstellen</h2>

        <form class="form-create-room" method="POST" action="{{ route('action-create-room') }}">
            @csrf

            <div class="form-create-room__field">
                <label for="room-name">Spielname</label>
                <input class="form-create-room__input" type="text" id="room-name" name="name">
            </div>

            <div class="form-create-room__field">
                <input class="form-create-room__submit" type="submit" id="submit" value="Erstellen">
            </div>

        </form>
    </div>

@endsection
