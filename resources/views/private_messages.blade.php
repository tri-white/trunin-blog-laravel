<!-- resources/views/private_messages.blade.php -->

@extends('shared/layout')

@section('content')

    <div class="container mt-5">
        <div class="row">
        <div class="col-lg-4">
    <h2 class="text-center">Список друзів</h2>
    <div class="list-group" style="max-height: 300px; overflow-y: auto;">
        <input type="text" id="friendSearch" class="form-control mb-3" placeholder="Знайти друга...">

        @foreach($friends as $friend)
            <a href="{{ route('private_messages', ['friend_id' => $friend->id]) }}"
                class="d-flex text-center py-auto list-group-item list-group-item-action{{ request('friend_id') == $friend->id ? ' active' : '' }}">
                <div class="img-container d-flex" style="height:50px; width:50px;">
                    <img src="{{ $friend->photo ? asset('/storage/app/' . $friend->photo) : asset('images/user_male.jpg') }}"
                        style="width:100%; height:100%; object-fit: contain;"
                        class="rounded-circle border border-1 border-secondary" alt="Profile Picture">
                </div>
                <span class="my-auto ms-3">{{ $friend->email }}</span>
            </a>
        @endforeach
    </div>
</div>

            <div class="col-lg-8">
                <h2 class="text-center">Приватні повідомлення</h2>
                @if($selectedFriend)
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex" style="width:100%; background-color:lightgray;">
                        <a href="{{route('profile', $selectedFriend->id)}}" class=" text-decoration-none link-dark d-flex py-auto my-2 ms-2">
                        <div class="py-auto">
                            <img src="{{ $selectedFriend->photo ? asset('/storage/app/' . $selectedFriend->photo) : asset('images/user_male.jpg') }}"
                                style="width: 50px; height: 50px; object-fit: contain;"
                                class="rounded-circle border border-1 border-secondary" alt="Profile Picture">
                        </div>
                        <h3 class="py-auto ms-3">{{ $selectedFriend->email }}</h3>
                        </a>
                    </div>
                    <div id="messageContainer" class="mt-4" style="width:100%; height: 300px; overflow-y: auto;">
                        
                    </div>

                    </div>
  
                    <form method="post" id="privateMessageForm" class="mt-4" action="{{ route('send_private_message', $selectedFriend->id) }}">
    @csrf
    <textarea name="message" class="form-control" placeholder="Введіть своє повідомлення..."></textarea>
    <button type="button" id="sendMessageBtn" class="btn btn-dark mt-2">Надіслати</button>
</form>
                @else
                    <p class="fs-3 text-center">Оберіть друга з яким хочете розмовляти.</p>
                @endif
            </div>
        </div>
    </div>
    <script>
// Function to update messages
function updateMessages() {
    var messageContainer = $('#messageContainer');
    var friendId = {{ $selectedFriend ? $selectedFriend->id : 'null' }};

    // Use Ajax to fetch new messages
    $.ajax({
        url: '/fetch-messages/' + friendId,
        method: 'GET',
        success: function(data) {
            // Get the current scroll position
            var isScrolledToBottom = messageContainer.prop('scrollHeight') - messageContainer.prop('scrollTop') === messageContainer.prop('clientHeight');

            messageContainer.empty();
            messageContainer.append(data);

            // Scroll to the bottom only if the user was already at the bottom
            if (isScrolledToBottom) {
                messageContainer.scrollTop(messageContainer.prop('scrollHeight'));
            }
        },
        error: function(error) {
            console.error('Error fetching messages: ', error);
        }
    });
}

setInterval(updateMessages, 1000);

// Event listener for the scroll event
$('#messageContainer').on('scroll', function() {
    // You can add additional logic here if needed
    // For example, you can check whether the user has scrolled up
});

// Friend search functionality
$('#friendSearch').on('input', function() {
    // Your existing friend search logic
});

$('#sendMessageBtn').on('click', function() {
    var formData = $('#privateMessageForm').serialize(); 

    $.ajax({
        url: '{{ route("send_private_message", $selectedFriend->id) }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#privateMessageForm')[0].reset();
             // Scroll to the bottom of the message container
    var messageContainer = $('#messageContainer');
    messageContainer.scrollTop(messageContainer.prop('scrollHeight'));
            updateMessages();
        },
        error: function(error) {
            console.error('Error sending message:', error);
        }
    });
});
</script>



@endsection
