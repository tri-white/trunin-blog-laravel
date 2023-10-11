<!-- POST -->
@php
                $user = \App\Models\User::where('id', $post->userid)->first();
            @endphp
<div class="card mb-5 col-6 mx-auto px-auto mt-5 shadow">
    <div class="card-body">
        <a href="{{ route('profile', $user->id) }}" class="text-decoration-none link-dark">
            <div class="d-flex align-items-center">
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
        <p class="text-wrap fs-3 text-center">
            {{ $post->title }}
        </p>
        <hr>
        <p class="text-wrap fs-5">
            {{ $post->description }}
        </p>

        <div class="d-flex justify-content-between align-items-center py-auto mt-2">
            <div class="col-lg-6 py-auto">
                <p class="my-auto me-2 text-muted">{{ $post->category }}</p>
            </div>
            <div class="col-lg-6 py-auto">
                <div class="d-flex justify-content-end align-items-center my-auto py-auto">
                    @if(Auth::check())
                        @if (Auth::user()->admin == 1 || Auth::user()->id == $user->id)
                            <form method="POST" action="{{ route('remove-post', ['postid'=>$post->id]) }}">
                                @csrf
                                <button type="submit" style="border: none; background: none; cursor: pointer;">
                                    <i class="fa fa-trash-can"></i>
                                </button>
                            </form>
                        @endif
                        @if(Auth::user()->id == $user->id || Auth::user()->admin == 1)
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editPostModal">
                            <i class="fa fa-pencil"></i>
                        </button>
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
        @endphp

        @if($commentCount > 0)
            @foreach($comms as $comm)
                @php
                    $row_user = \App\Models\User::find($comm->userid);
                @endphp
                @include('templates/comment-card')
                
            @endforeach
        @else
            <div class='my-2 text-muted col-lg-12 text-center fs-5'>
                Немає комментарів.
            </div>
        @endif
     </li>
   </ul>
   <!-- END POST COMMENTS -->


   <!-- YOUR COMMENT -->
    @if(Auth::check())
   <div class="card-body">
     <form method="POST" action="{{ route('add-comment', ['userid' => Auth::user()->id, 'postid' => $post->id]) }}" autocomplete="off">
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
</div>
<!-- POST END -->
