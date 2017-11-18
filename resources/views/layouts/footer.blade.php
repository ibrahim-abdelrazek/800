<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/responsejs/response.min.js') }}"></script>
<script src="{{ asset('libs/loading-overlay/loadingoverlay.min.js') }}"></script>
<script src="{{ asset('libs/tether/js/tether.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/jscrollpane/jquery.jscrollpane.min.js') }}"></script>
<script src="{{ asset('libs/jscrollpane/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('libs/flexibility/flexibility.js') }}"></script>
<script src="{{ asset('libs/noty/noty.min.js') }}"></script>
<script src="{{ asset('libs/velocity/velocity.min.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets/scripts/common.min.js') }}"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

<div class="ks-mobile-overlay"></div>
<script>
    var notifications = [];
    var messages = [];
    const NOTIFICATION_TYPES = {
        order: 'App\\Notifications\\OrderCreated',
        message: 'App\\Notifications\\MessageCreated'
    };
    $(document).ready(function () {
        // check if there's a logged in user
        if (Laravel.userId) {
            $.get('/notifications', function (data) {
                addNotifications(data, "#notifications");
            });
            $.get('/threads', function (data) {
                addMessages(data, "#messages");
            });
        }
        $('select').select2();
    });

    function addNotifications(newNotifications, target) {
        notifications = _.concat(notifications, newNotifications);
        // show only last 5 notifications
        notifications.slice(0, 5);
        showNotifications(notifications, target);
    }
    function addMessages(newMessages, target) {
        messages = _.concat(messages, newMessages);
        // show only last 5 notifications
        messages.slice(0, 5);
        showMessages(messages, target);
    }

    function showNotifications(notifications, target) {
        if (notifications.length) {
            var htmlElements = notifications.map(function (notification) {
                return makeNotification(notification);
            });
            $(target + 'Menu').html(htmlElements.join(''));
            $('#notifier').html('<span class="badge badge-pill badge-info">' + notifications.length + '</span>')
        } else {
            $(target + 'Menu').html('');
            $('#notifier').html('');
        }
    }
    function showMessages(messages, target) {
        if (messages.length) {
            var htmlElements = messages.map(function (message) {
                return makeMessage(message);
            });
            $(target + 'Menu').html(htmlElements.join(''));
            $('#messenger-notifier').html('<span class="badge badge-pill badge-info">' + messages.length + '</span>')
        } else {
            $(target + 'Menu').html('');
            $('#messenger-notifier').html('');
        }
    }

    // Make a single notification string
    function makeNotification(notification) {
        var to = routeNotification(notification);
        var notificationText = makeNotificationText(notification);
        return '<a href="' + to + '" class="ks-notification">' + notificationText + '</a>';
    }
    function makeMessage(message) {
        var to = routeMessage(message);
        var messageText = makeMessageText(message);
        return '<a href="' + to + '" class="ks-message">' + messageText + '</a>';
    }

    // get the notification route based on it's type
    function routeNotification(notification) {
        var to = '?read=' + notification.id;
        if (notification.type === NOTIFICATION_TYPES.order) {
            to = 'orders/' + notification.data.order_id + to;
        }
        return '/' + to;
    }
    function routeMessage(message) {
        var to = '';
        if (message.type === NOTIFICATION_TYPES.message) {
            to = 'messages/' + message.data.message_id;
        }
        return '/' + to;
    }

    // get the notification text based on it's type
    function makeNotificationText(notification) {
        var text = '';
        if (notification.type === NOTIFICATION_TYPES.order) {
            const user_name = notification.data.user_name;
            text += '<div class="ks-avatar">' +
                '<img src="' + notification.data.user_photo + '" width="36" height="36">' +
                '</div>' +
                '<div class="ks-info">' +
                '<div class="ks-user-name">' + user_name + '<span class="ks-description"> has add new order</span>' +
                '</div>' +
                '<div class="ks-datetime">' + notification.data.order_time + '</div>' +
                '</div>';
        }

        return text;
    }
    function makeMessageText(message) {
        var text = '';
        if (message.type === NOTIFICATION_TYPES.message) {
            const user_name = message.data.user_name;
            text += '<div class="ks-avatar">' +
                '<img src="' + message.data.user_photo + '" width="36" height="36">' +
                '</div>' +
                '<div class="ks-info">' +
                '<div class="ks-user-name">' + user_name + '<span class="ks-text"> sent you new message</span>' +
                '</div>' +
                '<div class="ks-datetime">' + message.data.order_time + '</div>' +
                '</div>';
        }

        return text;
    }



</script>
@stack('customjs')
</body>
</html>