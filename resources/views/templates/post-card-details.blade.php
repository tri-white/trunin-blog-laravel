<!-- POST -->
<div class="card mb-5 col-6 mx-auto px-auto mt-5">
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
                <pre class="fs-4">
                    {{ $post->title }}
                </pre>
            </p>
            <hr>
            <p>
                <pre class="fs-5">
                    {{ $post->description }}
                </pre>
            </p>
            @if ($post->photo)
                <img src="{{ asset('storage/' . $post->photo) }}" alt="Post Image"
                    class="card-img-top border border-1 border-dark">
            @endif
        <a href=""
            class="text-decoration-none link-dark">
            
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

                    <p class="my-auto me-2"> {{ $post->likes}} </p>

                    @if(!Auth::check())
                    <a href="{{ route('login') }}" class="btn btn-outline-danger" id="like-button">
                        <i class="fa fa-heart"></i>
                    </a>
                    @else
                        <form method="POST" action="{{ route('like', [$post->id, Auth::user()->id]) }}">
                            @csrf
                            @if(Auth::check())
                                <button type="submit" class="btn btn-outline-danger" id="like-button">
                                    <i class="fa fa-heart"></i>
                                </button>
                            @else
                                <button type="submit" class="btn btn-danger" id="like-button">
                                    <i class="fa fa-heart"></i>
                                </button>
                            @endif
                        </form>
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
