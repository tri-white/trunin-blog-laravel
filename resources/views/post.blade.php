@extends('shared/layout')
 
@section('content')
        @foreach($posts as $post)
            @php
                $user = \App\Models\User::where('id', Auth::user()->id);
            @endphp
            @include('templates/post-card-details')
        @endforeach
@endsection