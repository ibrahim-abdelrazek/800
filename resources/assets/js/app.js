window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
window.Pusher = require('pusher-js');
import Echo from "laravel-echo";

window.Echo = new Echo({
    "authEndpoint": "/broadcasting/auth",
    broadcaster: 'pusher',
    key: '9297ea644bd39f8d2fc5',
    cluster: 'eu',
    encrypted: true
});

var notifications = [];
var messages = [];


$(document).ready(function () {
    if (Laravel.userId) {
        //...
       //Notifing Dashboard
        window.Echo.private('order.' + Laravel.userId)
            .notification((notification) => {
            console.log(notification);
        });
        window.Echo.private('chat.'+ Laravel.userId)
            .notification((notification) => {
            console.log(notification);
        });

        //Notifing Desktop
        window.Echo.channel('order.' + Laravel.userId)
                .listen('OrderCreated', notification => {
                    console.log(notification);
                if (! ('Notification' in window)) {
                alert('Web Notification is not supported');
            }


        });

        }
});
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
    $('<audio id="notificationAudio">' +
        '<source src="raw/jingle-bells-sms.mp3" type="audio/mpeg">' +
        '</audio>').appendTo('body');

// play sound
    $('#notificationAudio')[0].play();
    return '<a href="' + to + '" class="ks-notification">' + notificationText + '</a>';
}
function makeMessage(message) {
    var to = routeMessage(message);
    var messageText = makeMessageText(message);
    $('<audio id="notificationAudio">' +
        '<source src="raw/jingle-bells-sms.mp3" type="audio/mpeg">' +
        '</audio>').appendTo('body');

// play sound
    $('#notificationAudio')[0].play();
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
        const user_name = notification.data.user_name;
        text += '<div class="ks-avatar">' +
            '<img src="' + notification.data.user_photo + '" width="36" height="36">' +
            '</div>' +
            '<div class="ks-info">' +
            '<div class="ks-user-name">' + user_name + '<span class="ks-text"> has add new order</span>' +
            '</div>' +
            '<div class="ks-datetime">' + notification.data.order_time + '</div>' +
            '</div>';
    }

    return text;
}
