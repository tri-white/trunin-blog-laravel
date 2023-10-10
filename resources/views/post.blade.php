@extends('shared/layout')
 
@section('content')
            @php
                $user = \App\Models\User::where('id', $post->id)->first();
            @endphp
            @include('templates/post-card-details')
@endsection