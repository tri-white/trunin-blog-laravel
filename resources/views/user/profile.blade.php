@extends('shared/layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="profile-image mx-auto" style="height:150px; width:150px;">
                <img src="{{ asset('images/user_male.jpg') }}"
                     style="width:100%; height:100%; object-fit: contain;"
                     class="rounded-circle border border-1 border-dark" alt="Profile Picture">
            </div>

            <div class="profile-info text-center mt-2">
                <h5>{{ $user->login }}</h5>
                @if(Auth::check())
                @if((Auth::user()->admin == 1 && $user->id !== Auth::user()->id) || Auth::user()->id == $user->id)
                    <form method="POST" action="{{ route('remove-user', ['userid'=>$user->id]) }}">
                        @csrf
                        <button type="submit" style="border: none; background: none; cursor: pointer;">
                            <i class="fa fa-trash-can"></i>
                        </button>
                    </form>
                @endif
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="container mt-5">
                <div class="row d-flex justify-content-center">
                    <div class="mb-3 col-lg-12 text-center display-2">
                        Пости
                    </div>
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        @foreach($user->posts as $post)
                            @include('templates/post-card');
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
