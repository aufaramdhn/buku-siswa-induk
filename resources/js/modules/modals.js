document.addEventListener('DOMContentLoaded', () => {
    const triggerButtons = document.querySelectorAll('[data-modal-target]');
    const dismissButtons = document.querySelectorAll('[data-modal-dismiss]');
    const backdrops = document.querySelectorAll('.modal-backdrop');

    triggerButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetSelector = button.getAttribute('data-modal-target');
            const targetModal = document.querySelector(targetSelector);

            if (targetModal) {
                targetModal.classList.add('is-visible');
            }
        });
    });

    dismissButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetSelector = button.getAttribute('data-modal-dismiss');
            const targetModal = document.querySelector(targetSelector);

            if (targetModal) {
                targetModal.classList.remove('is-visible');
            }
        });
    });

    backdrops.forEach(backdrop => {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                backdrop.classList.remove('is-visible');
            }
        });
    });
});
