@extends('layouts.app')

@section('content')
<div class="row chat-page">
    <chat-side-bar-section></chat-side-bar-section>
    <chat-messages-section :chat-room-id="{{$id}}"></chat-messages-section>
</div>
@endsection
