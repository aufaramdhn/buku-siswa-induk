import './modules/tabs.js';
import './modules/modals.js';
import './modules/form-validation.js';
import './modules/student-search.js';
import './modules/quick-search.js';
import './modules/custom-select.js';
import './modules/datepicker.js';

document.addEventListener('DOMContentLoaded', () => {
    const sessionSuccessModal = document.querySelector('#session-success-modal');
    if (sessionSuccessModal) {
        setTimeout(() => {
            sessionSuccessModal.classList.add('is-visible');
        }, 100);
    }

    const sessionErrorModal = document.querySelector('#session-error-modal');
    if (sessionErrorModal) {
        setTimeout(() => {
            sessionErrorModal.classList.add('is-visible');
        }, 100);
    }

    document.querySelectorAll('form').forEach(form => {
        form.setAttribute('autocomplete', 'one-time-code');
    });
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.setAttribute('autocomplete', 'one-time-code');
    });
});
