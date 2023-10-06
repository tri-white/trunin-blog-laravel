@extends('shared/layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="profile-image mx-auto" style="height:150px; width:150px;">
            <img src="{{ Auth::check() && Auth::user()->photo ? asset(Auth::user()->photo) : asset('images/user_male.jpg') }}"
     style="width:100%; height:100%; object-fit: contain;"
     class="rounded-circle border border-1 border-dark" alt="Profile Picture">
            </div>

            @if(Auth::check())
            <form action="{{ url('/change_profile_image') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12 my-2 align-items-center text-center">
                    <label for="inputField" class="text-muted text-decoration-underline" style="cursor:pointer;">Змінити фотографію профілю</label>
                    <input name="profile-image" type="file" id="inputField" style="display:none">
                    <button class="ms-2" type="submit">Зберегти фото</button>
                </div>
            </form>
            @endif

            <div class="profile-info text-center mt-2">
                <h5>{{ Auth::user()->login }}</h5>
                @if(Auth::user()->admin == 1)
                    <a class="my-auto me-4 link-dark"
                       href="">
                        <i class="fa fa-trash-can"></i>
                    </a>
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
                        <!-- here should be profile user's posts -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
