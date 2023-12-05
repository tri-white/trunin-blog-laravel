<!-- resources/views/private_messages/friends.blade.php -->

@foreach($friends as $friend)
    @php 
                    $friends = App\Models\friend::where('user_id',$friend->id)->where('friend_id',Auth::user()->id)->first();
                    $friends2 = App\Models\friend::where('friend_id',$friend->id)->where('user_id',Auth::user()->id)->first();
                    @endphp
                        
    <a href="{{ route('private_messages', ['friend_id' => $friend->id]) }}"
        class="d-flex text-center py-auto list-group-item list-group-item-action {{ request('friend_id') == $friend->id ? ' active' : '' }}">
        <div class="img-container d-flex" style="height:50px; width:50px;">
            <img src="{{ $friend->photo ? asset('/storage/app/' . $friend->photo) : asset('images/user_male.jpg') }}"
                style="width:100%; height:100%; object-fit: contain;"
                class="rounded-circle border border-1 border-secondary" alt="Profile Picture">
        </div>
        <span class="my-auto ms-3">{{ $friend->email }} @if(isset($friends) || isset($friends2)) (друг) @endif</span>
    </a>
@endforeach
