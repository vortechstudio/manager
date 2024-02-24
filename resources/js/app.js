import './bootstrap';

document.querySelectorAll('[data-format="datetime"]').forEach(item => {
    new tempusDominus.TempusDominus(item);
})
