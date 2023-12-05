<!-- resources/views/friends.blade.php -->

@extends('shared/layout')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center">Друзі</h2>
                <div class="row">
                    @if($friends && $friends->count() > 0)
                        @foreach($friends as $friend)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                <div class="friend-item">
                                    <a href="{{ route('profile', $friend->id) }}" class="text-decoration-none link-dark">
                                        <img src="{{ $friend->photo ? asset(str_replace('public/', 'storage/', $friend->photo)) : asset('images/user_male.jpg') }}"
                                             class="rounded-circle" alt="{{ $friend->email }}" style="width: 50px; height: 50px;">
                                    <span>{{ $friend->email }}</span>
</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-lg-12">
                            <p>Немає друзів на даний момент.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
