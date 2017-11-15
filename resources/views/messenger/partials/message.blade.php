<li class="ks-item @if($message->user->id == Auth::user()->id) ks-from @else ks-self @endif">
    <span class="ks-avatar ks-offline">
        <img src="{{ asset($message->user->photo) }}" width="36" height="36"
             class="rounded-circle">
    </span>
    <div class="ks-body">
        <div class="ks-header">
            <span class="ks-name">{{$message->user->name}}</span>
            <span class="ks-datetime">{{ $message->created_at->diffForHumans() }}</span>
        </div>
        <div class="ks-message">{{ $message->body }}</div>
    </div>
</li>
