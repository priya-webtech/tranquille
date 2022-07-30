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


var channel = window.Echo.channel('notify');
console.log(channel);
// channel.listen('SendNotification', function(data) {
//     $.get('/latest-notification/', function (new_notifications) {
//         if(data.blog.id == new_notifications.data.id){
//             addNotifications(new_notifications, "#notifications");
//
//             //show popup
//             var app_url = $('#app_url').val();
//             var blog_detail = '<h3>'+data.blog.title+'</h3><br><img src="'+app_url+'/images/blog/'+data.blog.photo+'" /><p>'+data.blog.description+'</p>';
//             $('.blog-popup .blog-detail').html(blog_detail);
//
//             $('.blog-popup').removeClass("out");
//             $('.blog-popup').addClass("side-popup");
//         }
//     });
//
// });


const NOTIFICATION_TYPES = {
    announcement: 'App\\Notifications\\Announcement'
};


$(document).ready(function() {
    $.get('http://127.0.0.1:8000/notifications', function (data) {
        addNotifications(data, "#notifications");
    });
});

function addNotifications(newNotifications, target) {
    notifications = _.concat(newNotifications, notifications);
    // show only last 5 notifications
    notifications = notifications.slice(0, 5);
    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
    if(notifications.length) {

        $('.badge-counter').text(notifications.length);

        var htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $(target + 'Menu').html(htmlElements.join(''));
        $(target).addClass('has-notifications')
    } else {
        $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
        $(target).removeClass('has-notifications');
    }
}


// Make a single notification string
function makeNotification(notification) {
    var to = routeNotification(notification);
    var notificationText = makeNotificationText(notification);
    return '<li><a href="' + to + '">' + notificationText + '</a></li>';
}

function routeNotification(notification) {
    var to = `?read=${notification.id}`;
    if(notification.type === NOTIFICATION_TYPES.announcement) {
        const id = notification.data.id;
        if(notification.notifiable_type == 'App\\Player'){
            var guard = 'player';
        } else if(notification.notifiable_type == 'App\\Store'){
            var guard = 'store';
        }

        to = `${guard}/annoucement_detail/${id}` + to;
    }
    return '/' + to;
}

function makeNotificationText(notification) {

    var text = '';
    if(notification.type === NOTIFICATION_TYPES.announcement) {
        const title = notification.data.title;
        text += `<strong>${title}</strong>`;
    }
    return text;
}
