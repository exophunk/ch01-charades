@extends('layouts.app')

@section('content')

    <div class="page-home">
        <h1>Charades</h1>


        <div class="pane pane-rooms">

            <h2>Teilnehmen</h2>

            <ul class="list-rooms">
                @foreach ($rooms as $room)
                    <li>
                        <a href="{{ route('room', [ 'room_id' => $room->id ]) }}">{{ $room->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="pane pane-create-room">

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
    </div>

@endsection
