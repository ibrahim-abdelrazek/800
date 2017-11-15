<?php $class = $thread->isUnread(Auth::id()) ? 'ks-unread' : ''; ?>
<li class="ks-item {{$class}}">
    <a data-id="{{$thread->id}}" href="#">
        <span class="ks-avatar">
            <img src="{{ $thread->participants->where('user_id', '!=',  Auth::user()->id)->first()->user->photo }}" width="36" height="36">
            @if($thread->userUnreadMessagesCount(Auth::id()) > 0)
            <span class="badge badge-pill badge-danger ks-badge ks-notify">{{$thread->userUnreadMessagesCount(Auth::id())}}</span>
            @endif
        </span>
        <div class="ks-body">
            <div class="ks-name">
                {{ $thread->participants->where('user_id', '!=', Auth::user()->id)->first()->user->name }}
                <span class="ks-datetime">{{ $thread->latestMessage->created_at->diffForHumans()}}</span>
            </div>
            <div class="ks-message">{{ $thread->latestMessage->body }}</div>
        </div>
    </a>
</li>
