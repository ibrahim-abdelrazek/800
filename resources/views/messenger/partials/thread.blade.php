<div class="ks-header">
    <div class="ks-description">
        <div class="ks-name">{{ $thread->subject }}</div>
    </div>
</div>
<div id="message-holder" class="ks-body ks-scrollable" data-auto-height data-reduce-height=".ks-footer" data-fix-height="32">         <ul class="ks-items">
                @each('messenger.partials.message', $thread->messages, 'message')
            </ul>

    </div>
<div class="ks-footer">
    <textarea id="message" class="form-control" placeholder="Type something..."></textarea>
    <div class="ks-controls">
        <button id="send" class="btn btn-primary">Send</button>
    </div>
</div>
