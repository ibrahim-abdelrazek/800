@extends('layouts.app')
@push('customcss')
    <link rel="stylesheet" type="text/css" href="assets/styles/apps/messenger.min.css"> <!-- Customization -->
@endpush
@section('content')
    @include('messenger.partials.flash')
    <div class="ks-page-header">
        <section class="ks-title">
            <h3>Messenger</h3>
            <button class="btn btn-primary-outline ks-light ks-messenger-info-block-toggle"
                    data-block-toggle=".ks-messenger__info">Info
            </button>
        </section>
    </div>

    <div class="ks-page-content">
        <div class="ks-page-content-body">
            <div class="ks-messenger">
                <div class="ks-discussions">
                    <div class="ks-search">
                        <div class="input-icon icon-right icon icon-lg icon-color-primary">
                            <input id="input-group-icon-text" type="text" class="form-control" placeholder="Search">
                            <span class="icon-addon">
                <span class="la la-search"></span>
            </span>
                        </div>
                    </div>
                    <div class="ks-body ks-scrollable" data-auto-height>

                        <ul class="ks-items">
                            @each('messenger.partials.threads', $threads, 'thread', 'messenger.partials.no-threads')
                        </ul>

                    </div>
                </div>
                <div class="ks-messages ks-messenger__messages">
                    @include('messenger.partials.thread', ['thread'=>$threads[0]]);
                </div>
                @include('messenger.partials.info', ['user'=>$threads[0]->participants->where('user_id', '!=', Auth::user()->id)->first()->user]);

            </div>
        </div>
    </div>
@endsection
@push('customjs')
    <script type="application/javascript">

        (function ($) {
            function _ajax_request(url, data, callback, method) {
                return jQuery.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: callback
                });
            }
            jQuery.extend({
                put: function(url, data, callback) {
                    return _ajax_request(url, data, callback, 'PUT');
                }});
            $(document).ready(function () {
                var socket = io.connect('http://46.4.98.167:8890/');
                console.log(socket.status);
                socket.on('connect', function () {

                    socket.on('chat', function (data) {
                        $("#message-holder").find(".ks-items").append(data);
                    });
                });

                var messagesBoxItems = $('#message-holder .ks-items');
                var messagesBox = $('.ks-messages');

                $('.ks-discussions .ks-item').on('click', function () {

                    messagesBox.LoadingOverlay("show", {
                        image: "",
                        custom: $("<div>", {
                            text: 'Loading...'
                        }),
                        color: "rgba(255, 255, 255, 0.6)",
                        zIndex: 2
                    });
                    //Loading Thread Content
                    setTimeout(function () {
                        messagesBox.LoadingOverlay("hide");
                    }, 2000);
                });
                //Sending Message
                $('.ks-messages #send').on('click', function () {
                    var message = $('#message');
                    if(message.val().length > 1 && message.val() != "")
                        sendMessage(message.val());

                });
                document.getElementById("message").addEventListener("keydown", function(e) {
                    if (!e) { var e = window.event; }
                    // Enter is pressed
                    if (e.keyCode == 13) {
                        if($(this).val().length > 1 && $(this).val() != "")
                            sendMessage($(this).val()); }
                }, false);
                function sendMessage(message) {
                    var data = {
                        '_token': "{{ csrf_token() }}",
                        'message': message
                    };
                    messagesBox.LoadingOverlay("show", {
                        image: "",
                        custom: $("<div>", {
                            text: 'Loading...'
                        }),
                        color: "rgba(255, 255, 255, 0.6)",
                        zIndex: 2
                    });
                    $.put("{{ route('messages.update', ['id'=>$threads[0]->id]) }}", data, function (html) {
                        $('#message').val("");
                        messagesBox.LoadingOverlay("hide");
                        //messagesBoxItems.append(html);
                    });
                }

                if (Response.band(0, 800)) {
                    var ksMessagesView = $('.ks-messenger > .ks-messages');
                    var ksDiscussions = $('.ks-messenger > .ks-discussions > .ks-body .ks-items > .ks-item');
                    var ksViewCancel = $('.ks-mail > .ks-view .ks-view-cancel');

                    ksDiscussions.on('click', function () {
                        ksMessagesView.addClass('ks-open');
                    });

                    ksViewCancel.on('click', function () {
                        ksMessagesView.removeClass('ks-open');
                    });
                }
            });
        })(jQuery);
    </script>
@endpush