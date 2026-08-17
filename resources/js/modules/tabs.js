document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetSelector = button.getAttribute('data-tab-target');
            const targetPane = document.querySelector(targetSelector);

            if (!targetPane) return;

            tabButtons.forEach(btn => {
                btn.classList.remove('text-blue-600', 'border-blue-600', 'font-semibold');
                btn.classList.add('text-neutral-500', 'border-transparent', 'font-medium');
            });

            button.classList.remove('text-neutral-500', 'border-transparent', 'font-medium');
            button.classList.add('text-blue-600', 'border-blue-600', 'font-semibold');

            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
            });

            targetPane.classList.remove('hidden');
        });
    });
});
