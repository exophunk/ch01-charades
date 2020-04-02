@extends('layouts.app')

@section('content')
    <Room
        :user="{{ auth()->user() }}"
        :room="{{ json_encode($room) }}"
    />
@endsection
