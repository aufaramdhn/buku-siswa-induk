document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', (e) => {
        const triggerBtn = e.target.closest('[data-modal-target]');
        if (triggerBtn) {
            const targetSelector = triggerBtn.getAttribute('data-modal-target');
            const targetModal = document.querySelector(targetSelector);
            if (targetModal) {
                targetModal.classList.add('is-visible');
            }
        }

        const dismissBtn = e.target.closest('[data-modal-dismiss]');
        if (dismissBtn) {
            const targetSelector = dismissBtn.getAttribute('data-modal-dismiss');
            const targetModal = document.querySelector(targetSelector);
            if (targetModal) {
                targetModal.classList.remove('is-visible');
            }
        }

        const backdrop = e.target.closest('.modal-backdrop');
        if (backdrop && e.target === backdrop) {
            backdrop.classList.remove('is-visible');
        }
    });
});
