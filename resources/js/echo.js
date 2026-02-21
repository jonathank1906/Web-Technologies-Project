import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    wssPort: import.meta.env.VITE_PUSHER_PORT,
    enabledTransports: ["ws", "wss"],
});

window.UserStatus = {
    users: {},

    updateUI() {
        window.dispatchEvent(
            new CustomEvent("status-updated", { detail: this.users })
        );
        console.log(this.users);
    }
};

window.Echo.join('status')
    .here((users) => {
        users.forEach(u => UserStatus.users[u.id] = 'Online');
        UserStatus.updateUI();
    })
    .joining((user) => {
        UserStatus.users[user.id] = 'Online';
        UserStatus.updateUI();
    })
    .leaving((user) => {
        UserStatus.users[user.id] = 'Offline';
        UserStatus.updateUI();
    });
