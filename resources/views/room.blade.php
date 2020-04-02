@extends('layouts.app')

@section('content')
    <App
        :user="{{ auth()->user() }}"
        :room="{{ json_encode($room) }}"
    />
@endsection
