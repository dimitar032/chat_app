@extends('layouts.app')

@section('content')
<div class="row chat-page">
    <chat-side-bar-section></chat-side-bar-section>
    <home-section user-name="{{auth()->user()->name}}"></home-section>
</div>
@endsection
