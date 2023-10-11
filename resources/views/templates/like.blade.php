<div class="d-flex align-items-center py-auto my-auto">
    <p class="my-auto me-2 py-auto">{{ $post->likes }}</p>

    @if (!Auth::check())
        <a href="{{ route('login') }}" class="btn btn-outline-danger" id="like-button">
            <i class="fa fa-heart"></i>
        </a>
    @else
        <form method="POST" action="{{ route('like', [$post->id, Auth::user()->id]) }}">
            @csrf
            @php 
                $like = App\Models\Like::where('userid', Auth::user()->id)->where('postid', $post->id)->first();
            @endphp
            @if (!$like)
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
