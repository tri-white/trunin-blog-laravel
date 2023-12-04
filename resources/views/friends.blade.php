

@extends('shared/layout')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center">Ваші друзі</h2>

                @foreach(Auth::user()->friends as $friend)
                    <div class="friend-item">
                        <img src="{{ $friend->photo ? asset(str_replace('public/', 'storage/', $friend->photo)) : asset('images/user_male.jpg') }}"
                             class="rounded-circle" alt="{{ $friend->login }}">
                        <a href="{{ route('profile', ['userid' => $friend->id]) }}">{{ $friend->login }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
