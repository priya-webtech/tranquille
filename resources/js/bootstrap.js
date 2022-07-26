window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: false,
    wsHost: window.location.hostname,
    wsPort: 6001,
});


var notifications = [];
var channel = window.Echo.channel('admin-notify');
channel.listen('SendNotification', function (data) {
    $.get('/latest-notification/', function (new_notifications) {

        if (data.data.id == new_notifications.id) {
            addNotifications(new_notifications, "#notifications"); //show popup
            var app_url = $('#app_url').val();
            var blog_detail = '<h3>' + data.data.name + '</h3><br><p>' + data.data.message + '</p>';
            $('.blog-popup .blog-detail').html(blog_detail);
            $('.blog-popup').removeClass("out");
            $('.blog-popup').addClass("side-popup");
        }
    });
});
var NOTIFICATION_TYPES = {
    notify: 'App\\Notifications\\Notify'
};
$(document).ready(function () {
    $.get('/notifications', function (data) {
        addNotifications(data, "#notifications");
    });
});

function addNotifications(newNotifications, target) {
    notifications = _.concat(newNotifications, notifications); // show only last 5 notifications

    notifications = notifications.slice(0, 5);
    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
    if (notifications.length) {
        $('.number').text(notifications.length);
        var htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $('#notifications').html(htmlElements);
        $(target + 'Menu').html(htmlElements.join(''));
        $(target).addClass('has-notifications');
    } else {
        $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
        $(target).removeClass('has-notifications');
    }
} // Make a single notification string


function makeNotification(notification) {
    var to = routeNotification(notification);
    var notificationText = makeNotificationText(notification);
    return '<li>' + notificationText + '</li>';
}

function routeNotification(notification) {
    var to = "?read=".concat(notification.id);

    if (notification.type === NOTIFICATION_TYPES.notify) {
        var id = notification.data.id;
        to = "".concat(guard, "/notify/").concat(id) + to;
    }

    return '/' + to;
}

function makeNotificationText(notification) {
    var text = '';
    // if (notification.type === NOTIFICATION_TYPES.notify) {
    //     alert(notification.name);
    var title = notification.name;
    text += "<strong>".concat(title, "</strong>");
    // }

    return text;
}
