@extends('shared/layout')
 
@section('content')
    @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif

            @include('templates/post-card-details')
@endsection