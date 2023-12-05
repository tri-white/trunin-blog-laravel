@forelse($messages as $message)
    @php 
        $sender = App\Models\User::find($message->sender_id);
    @endphp
    <div style="background-color: {{ $message->sender_id == Auth::user()->id ? 'yellow' : 'lightgreen' }}; padding: 10px; margin-bottom: 5px; width:35%; {{ $message->sender_id == Auth::user()->id ? 'margin-left: auto;' : 'margin-right: auto;' }}">
        {{ $message->message }}
    </div>
@empty
    <p class="text-center fs-3">Немає повідомлень.</p>
@endforelse
