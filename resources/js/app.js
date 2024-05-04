import './bootstrap';
import {Livewire, Alpine} from '../../vendor/livewire/livewire/dist/livewire.esm';
import './ago.js'
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

Pusher.logToConsole = true;


Livewire.start();

document.querySelectorAll('[data-format="datetime"]').forEach(item => {
    flatpickr(item, {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        "locale": 'fr',
        onChange: function (selectedDates, dateStr, instance) {
            console.log(selectedDates)
            console.log(dateStr)
            console.log(instance)
        }// locale for this instance only
    });
})

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

let secure_account_channel = window.Echo.channel('secure_account_channel');
secure_account_channel.listen('UserDeleteNotification', (e) => {
    console.log(e)
})
