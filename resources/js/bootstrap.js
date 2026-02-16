import axios from 'axios';
window.axios = axios;


import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: 'local',
    wsHost: window.location.hostname,
    wsPort: 8080,
    wssPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

// ============= LISTENER ================
window.listenForFriendRequests = function (userId) {
    window.Echo.private(`user.${userId}`)
        .listen('FriendRequestSent', (e) => {
            alert("🔔 New Friend Request from: " + e.from.name);
        });
};


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
