<!-- resources/views/friend_requests.blade.php -->

@extends('shared/layout')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center">Запити в друзі</h2>
                <div class="row">
                    @if($friendRequests && $friendRequests->count() > 0)
                        @foreach($friendRequests as $request)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                <div class="friend-request-item">
                                    @if($request->id)
                                        <a href="{{ route('profile', $request->id) }}">
                                            <img src="{{ $request->photo ? asset(str_replace('public/', 'storage/', $request->photo)) : asset('images/user_male.jpg') }}"
                                                 class="rounded-circle" alt="{{ $request->login }}" style="width: 50px; height: 50px;">
                                        </a>
                                        <span>{{ $request->login }}</span>
                                        <div class="friend-request-buttons d-flex">
                                            <form method="POST" class="me-2" action="{{ route('accept-friend-request', ['requestId' => $request->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success">&#10003;</button>
                                            </form>

                                            <form method="POST" action="{{ route('decline-friend-request', ['requestId' => $request->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">&#10008;</button>
                                            </form>
                                        </div>
                                    @else
                                        <span>Невідомий користувач</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-lg-12">
                            <p>Немає запитів у друзі на даний момент.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
