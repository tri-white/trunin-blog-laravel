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
        <hr class="my-2 mb-4">
        <a href=""
            class="text-decoration-none link-dark">
            @if ($post->description)
            <p class="card-text">
                <pre class="fs-5">
                    {{ $post->description }}
                </pre>
            </p>
            @endif
            @if ($post->photo)
                <img src="{{ asset('storage/' . $post->photo) }}" alt="Post Image"
                    class="card-img-top border border-1 border-dark">
            @endif
        </a>
        <div class="d-flex justify-content-between mt-2 align-items-center">
            <div class="col-lg-6">
                <p class="my-auto me-2 text-muted">{{ $post->category }}</p>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-end">
                    @if(Auth::check())
                        @if (Auth::user()->admin == 1)
                            <a class="my-auto me-4 link-dark"
                                href="">
                                <i class="fa fa-trash-can"></i>
                            </a>
                        @endif
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
         <a href=""
           class="text-decoration-none link-dark text-light py-2">
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
     <form method="POST" action="{{ route('add-comment', ['userid' => $user->id, 'postid' => $post->id]) }}" autocomplete="off">
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