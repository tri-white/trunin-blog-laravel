@extends('shared/layout')
 
@section('content')
    @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif
            @php
                $user = \App\Models\User::where('id', $post->id)->first();
            @endphp
            @include('templates/post-card-details')
@endsection