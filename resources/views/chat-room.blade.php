@extends('layouts.app')

@section('content')
<div class="row chat-page">

    <chat-side-bar-section :auth-user-id="{{auth()->user()->id}}" :opened-chat-room-id="{{$id}}"></chat-side-bar-section>
    <chat-messages-section :auth-user-id="{{auth()->user()->id}}" :chat-room-id="{{$id}}"></chat-messages-section>
</div>
@endsection
