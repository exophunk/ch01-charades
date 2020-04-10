@extends('layouts.app')

@section('content')

    <div class="page-home">

        <img class="intro-image" src="/build/images/intro.svg" alt="">


        <div class="pane pane-rooms">

            <h2 class="pane-rooms__heading">{{ 'Offene Spiele' }}</h2>

            <ul class="list-rooms">
                @foreach ($rooms as $room)
                    <li class="list-rooms__room">
                        <a class="list-rooms__room-link" href="{{ route('room', [ 'room_id' => $room->id ]) }}">
                            <div class="list-rooms__room-name">
                                {{ $room->name }}
                            </div>
                            <div class="list-rooms__room-admin">
                                {{ $room->admin->name }}
                            </div>
                            <div class="list-rooms__room-players">
                                {{ count($room->teamUsers) }} <i class="far fa-user"></i>
                            </div>
                            <div class="list-rooms__room-button">
                                <button class="button-join-room"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>


        <div class="pane-bottom">
            <div class="meta-links">
                <ul>
                    <li class="meta-links__link"><a href="/docs">{{ 'Wie funktioniert es?' }}</a></li>
                    <li class="meta-links__link"><a href="/about">{{ 'About?' }}</a></li>
                </ul>
            </div>

            <a href="/create-room" class="button-create-room">{{ 'Neues Spiel' }}</a>
        </div>



    </div>

@endsection
