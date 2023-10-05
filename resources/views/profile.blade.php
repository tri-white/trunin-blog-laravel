@extends('shared/layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="profile-image mx-auto" style="height:150px; width:150px;">
                <img src="{{ $user_data['photo'] ?? 'images/user_male.jpg' }}" style="width:100%; height:100%; object-fit: contain;"
                     class="rounded-circle border border-1 border-dark" alt="Profile Picture">
            </div>

            @if(isset($user_data['userid']) && $user_data['userid'] == request()->input('id'))
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
                <h5>{{ $user_data['login'] }}</h5>
                @if($admin == 1 && $user_data['userid'] != request()->input('id'))
                    <a class="my-auto me-4 link-dark"
                       href="{{ url('/remove_profile') }}/{{ $user_data['userid'] }}">
                        <i class="fa fa-trash-can"></i>
                    </a>
                @endif
            </div>

            <div class="profile-posts">
                <h1>{{ $user_data['description'] }}</h1>
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
                        @if(is_bool($posts))
                            <div class='mb-5 text-muted col-lg-12 text-center display-4'>
                                Не знайдено постів
                            </div>
                        @else
                            @foreach($posts as $row)
                                <?php
                                $user_class = new User();
                                $post_class = new Post();
                                $row_user = $user_class->get_data($row['userid']);
                                $row_post = $post_class->get_data($row['postid']);
                                ?>
                                @include('post-card_profile', ['row_user' => $row_user, 'row_post' => $row_post])
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
