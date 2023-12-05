<!-- POST -->
@php
    $user = \App\Models\User::find($post->userid);
@endphp

<div class="card mb-5 shadow-lg" style="border-radius: 15px; background-color: #ffffff;">
    <div class="card-body">
        <a href="{{ route('profile', $user->id) }}" class="text-decoration-none link-dark">
            <div class="d-flex">
                <div class="img-container" style="height:50px; width:50px;">
                    <img src="{{ $user->photo ? asset('/storage/app/' . $user->photo) : asset('images/user_male.jpg') }}"
                        style="width:100%; height:100%; object-fit: contain;"
                        class="rounded-circle border border-1 border-secondary" alt="Profile Picture">
                </div>
                <div class="ms-2">
                    <h5 class="card-title">{{ $user->email }}</h5>
                    <p class="card-text text-muted">
                        <i class="fa fa-clock"></i> {{ $post->created_at }}
                    </p>
                </div>
            </div>
        </a>
        <hr style="background-color: #007bff;">
        <a href="{{ route('post-details', $post->id) }}" class="text-decoration-none link-dark">
            <p class="text-wrap fs-3 text-center" style="color: #333333;">
                {{ $post->title }}
            </p>
            <hr style="background-color: #007bff;">
            <p class="text-wrap fs-5" style="color: #555555;">
                {{ strlen($post->description) > 200 ? substr($post->description, 0, 200) . '...' : $post->description }}
            </p>

            @if ($post->photo_path)
    <div style="max-height: 500px; width: 100%; display: flex; justify-content: center; align-items: center; overflow: hidden;">
        <img src="{{ asset('/storage/app/' . $post->photo_path) }}" alt="Post Image" class="img-fluid" style="max-width: 100%; max-height: 500px; height: auto;">
    </div>
@endif


            <a href="{{ route('post-details',$post->id) }}" class="d-flex justify-content-end text-decoration-none" style="color: #007bff;">
                Детальніше...
            </a>
        </a>

        <div class="d-flex justify-content-between mt-3 align-items-center">
            <div class="col-lg-6">
                <p class="my-auto me-2 text-muted">{{ $post->category }}</p>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-end">
                    @if(Auth::check())
                        @if (Auth::user()->admin == 1 || Auth::user()->id == $user->id)
                            <form method="POST" action="{{ route('remove-post', ['postid'=>$post->id]) }}">
                                @csrf
                                <button type="submit" style="border: none; background: none; cursor: pointer; color: #dc3545;">
                                    <i class="fa fa-trash-can"></i>
                                </button>
                            </form>
                        @endif
                        @if(Auth::user()->id == $user->id || Auth::user()->admin == 1)
                            <a href="{{ route('edit-post', ['postid' => $post->id]) }}" style="color: #007bff;">
                                <i class="fa fa-pencil"></i>
                            </a>
                        @endif
                    @endif

                    @include('templates/like')
                </div>
            </div>
        </div>
    </div>

    <!-- POST COMMENTS -->
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            @php
                $comms = $post->comms()->get();
                $commentCount = $comms->count();
                $counter = 0;
                $showCount = 2;
            @endphp

            @if($commentCount > 0)
                @foreach($comms as $comm)
                    @php
                        $row_user = \App\Models\User::find($comm->userid);
                        $counter = $counter+1;
                    @endphp
                    @if($counter>$showCount)
                        @break
                    @endif
                    @include('templates/comment-card')
                @endforeach
            @else
                <div class='my-2 text-muted col-lg-12 text-center fs-5'>
                    Немає комментарів.
                </div>
            @endif

            @if($commentCount > $showCount)
    <div class="col-12 mt-4">
        <a href="{{ route('post-details', $post->id) }}" class="text-decoration-none link-dark text-light py-2">
            <div class="container-fluid bg-info text-center" style="border-radius: 10px;">
                <p>
                    Переглянути ще {{ $commentCount - $showCount }} комментарів
                </p>
            </div>
        </a>
    </div>
@endif

        </li>
    </ul>

    <!-- END POST COMMENTS -->

<!-- YOUR COMMENT -->
@if(Auth::check())
    <div class="card-body" style="background-color: #f8f9fa; /* light gray background color */ border-radius: 10px; margin-top: 15px;">
        <form method="POST" action="{{ route('add-comment', ['userid' => Auth::user()->id, 'postid' => $post->id]) }}" autocomplete="off">
            @csrf
            <div class="input-group align-items-center">
                <input name="description" type="text" class="form-control" placeholder="Ваш коментар"
                    aria-label="Add a comment" aria-describedby="comment-button" style="border-radius: 5px; border: 1px solid #6c757d; /* dark gray border */">
                <button class="btn btn-secondary" type="submit" id="comment-button" style="border-radius: 5px;">Додати коментар</button>
            </div>
        </form>
    </div>
@endif
<!-- END YOUR COMMENT -->


    <!-- END YOUR COMMENT -->
</div>
<!-- POST END -->
