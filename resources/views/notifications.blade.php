@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Notifications</h1>
        @foreach (Auth::user()->notifications as $notification)
            <div class="alert alert-info">
                {{ $notification->data['message'] }}
                <br>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
@endsection
