<!-- POST -->
@php
                $user = \App\Models\User::where('id', $post->userid)->first();
            @endphp
<div class="card mb-5 col-lg-6 mx-auto px-auto mt-5 shadow">
    <div class="card-body">
        <a href="{{ route('profile', $user->id) }}" class="text-decoration-none link-dark">
            <div class="d-flex align-items-center">
                <div class="img-container" style="height:50px; width:50px;">
                    <img src="{{ $user->photo ? asset(str_replace('public/', 'storage/', $user->photo)) : asset('images/user_male.jpg') }}"
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

        @if ($post->photo_path)
            <img src="{{ asset(str_replace('public/', 'storage/', $post->photo_path)) }}" alt="Post Image" class="img-fluid" style="height:100%;">
        @endif               

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
                    <a href="{{ route('edit-post', ['postid' => $post->id]) }}">
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
</div>
<!-- POST END -->
