import './bootstrap';
import {Livewire, Alpine} from '../../vendor/livewire/livewire/dist/livewire.esm';

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
