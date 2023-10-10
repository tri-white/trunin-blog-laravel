<!-- POST -->
<div class="card mb-5">
    <div class="card-body">
        <a href="{{ route('profile', $user->id) }}" class="text-decoration-none link-dark">
            <div class="d-flex">
                <div class="img-container" style="height:50px; width:50px;">
                    <img src="{{ $user->photo ? $user->photo : asset('images/user_male.jpg') }}"
                        style="width:100%; height:100%; object-fit: contain;"
                        class="rounded-circle border border-1 border-dark" alt="Profile Picture">
                </div>
                <div class="ms-2">
                    <h5 class="card-title">{{ $user->login }}</h5>
                    <p class="card-text text-muted">
                        <i class="fa fa-clock"></i> {{ $post->created_at }}
                    </p>
                </div>
            </div>
        </a>
        <hr>

        <p>
            {{ $post->title }}
        </p>
        <hr>
        <p class="text-wrap">
            {{ strlen($post->description) > 200 ? substr($post->description, 0, 200) . '...' : $post->description }}
        </p>

        <a href="{{ route('post-details',$post->id) }}" class="d-flex justify-content-end text-decoration-none">
            Детальніше...
        </a>

        <div class="d-flex justify-content-between mt-2 align-items-center">
            <div class="col-lg-6">
                <p class="my-auto me-2 text-muted">{{ $post->category }}</p>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-end">
                    @if(Auth::check())
                    @if (Auth::user()->admin == 1 || Auth::user()->id == $user->id)
                    <form method="POST" action="{{ route('remove-post', ['postid'=>$post->id]) }}">
                        @csrf
                        <button type="submit" style="border: none; background: none; cursor: pointer;">
                            <i class="fa fa-trash-can"></i>
                        </button>
                    </form>
                    @endif
                    @endif
                    @if(Auth::user()->id == $user->id || Auth::user()->admin == 1)
                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#editPostModal">
                        <i class="fa fa-pencil"></i>
                    </button>
                    @endif
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
        $counter= 0;
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
        @if($commentCount>$showCount)
        <div class="col-12 mt-4">
            <a href="{{ route('post-details', $post->id) }}" class="text-decoration-none link-dark text-light py-2">
                <div class="container-fluid bg-primary text-center">

                    <p>
                        Переглянути ще {{ $commentCount-$showCount }} комментарів
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
<div class="card-body">
    <form method="POST" action="{{ route('add-comment', ['userid' => Auth::user()->id, 'postid' => $post->id]) }}"
        autocomplete="off">
        @csrf
        <div class="input-group align-items-center">
            <input name="description" type="text" class="form-control" placeholder="Ваш коментар"
                aria-label="Add a comment" aria-describedby="comment-button">
            <button class="btn btn-primary" type="submit" id="comment-button">Додати коментар</button>
        </div>
    </form>
</div>
@endif
<!-- END YOUR COMMENT -->
</div>
</div>
<!-- POST END -->

<!-- Edit Post -->
<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostModalLabel">Редагування посту</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('edit-post', ['postid'=>$post->id]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="editedTitle">Редагування заголовку поста:</label>
                        <input type="text" class="form-control" id="editedTitle" name="editedTitle"
                            value="{{ $post->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="editedDescription">Редагування опису поста:</label>
                        <textarea class="form-control" id="editedDescription" name="editedDescription"
                            rows="4">{{ $post->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                </form>
            </div>
        </div>
    </div>
</div>