document.addEventListener('DOMContentLoaded', () => {
    const initCustomSelect = (wrapper) => {
        const nativeSelect = wrapper.querySelector('.hidden-native-select');
        const trigger = wrapper.querySelector('.custom-select-trigger');
        const label = wrapper.querySelector('.custom-select-label');
        const dropdown = wrapper.querySelector('.custom-select-dropdown');

        if (!nativeSelect || !trigger || !label || !dropdown) return;

        const renderOptions = () => {
            const options = Array.from(nativeSelect.options);
            let html = '';
            
            options.forEach((opt, idx) => {
                const isSelected = opt.selected;
                const activeClass = isSelected ? 'bg-primary-50 text-primary-600 font-semibold font-sans' : 'text-neutral-700 hover:bg-neutral-50 font-sans';
                
                html += `
                    <div 
                        class="custom-select-item px-4 py-2 text-sm cursor-pointer transition-colors ${activeClass}" 
                        data-value="${opt.value}" 
                        data-index="${idx}"
                    >
                        ${opt.text}
                    </div>
                `;

                if (isSelected) {
                    label.textContent = opt.text;
                }
            });

            dropdown.innerHTML = html;

            dropdown.querySelectorAll('.custom-select-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const index = parseInt(item.getAttribute('data-index'));
                    
                    nativeSelect.selectedIndex = index;
                    nativeSelect.dispatchEvent(new Event('change', { bubbles: true }));
                    nativeSelect.dispatchEvent(new Event('input', { bubbles: true }));
                    
                    closeDropdown();
                });
            });
        };

        const openDropdown = () => {
            document.querySelectorAll('.dropdown-menu').forEach(d => {
                if (d !== dropdown) {
                    d.classList.add('hidden');
                    d.classList.remove('scale-100', 'opacity-100');
                    d.classList.add('scale-95', 'opacity-0');
                }
            });

            document.querySelectorAll('.custom-select-wrapper').forEach(w => {
                if (w !== wrapper) {
                    const t = w.querySelector('.custom-select-trigger');
                    if (t) t.classList.remove('border-primary-600', 'border-danger', 'ring-4', 'ring-primary-600/10', 'ring-danger/10');
                    const a = t ? t.querySelector('svg') : null;
                    if (a) a.classList.remove('rotate-180');
                }
            });

            dropdown.classList.remove('hidden');
            void dropdown.offsetHeight;
            dropdown.classList.remove('scale-95', 'opacity-0');
            dropdown.classList.add('scale-100', 'opacity-100');
            
            const isError = trigger.classList.contains('has-error') || trigger.classList.contains('border-danger') || nativeSelect.classList.contains('has-error');
            if (isError) {
                trigger.classList.add('border-danger', 'ring-4', 'ring-danger/10');
            } else {
                trigger.classList.add('border-primary-600', 'ring-4', 'ring-primary-600/10');
            }

            const arrow = trigger.querySelector('svg');
            if (arrow) arrow.classList.add('rotate-180');
        };

        const closeDropdown = () => {
            dropdown.classList.remove('scale-100', 'opacity-100');
            dropdown.classList.add('scale-95', 'opacity-0');
            trigger.classList.remove('border-primary-600', 'ring-4', 'ring-primary-600/10', 'ring-danger/10');
            const arrow = trigger.querySelector('svg');
            if (arrow) arrow.classList.remove('rotate-180');
            setTimeout(() => {
                if (dropdown.classList.contains('opacity-0')) {
                    dropdown.classList.add('hidden');
                }
            }, 150);
        };

        renderOptions();

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = !dropdown.classList.contains('hidden') && dropdown.classList.contains('opacity-100');
            if (isOpen) {
                closeDropdown();
            } else {
                openDropdown();
            }
        });

        nativeSelect.addEventListener('change', () => {
            renderOptions();
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
                closeDropdown();
            }
        });
    };

    const initCustomDropdown = (dropdown) => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const label = dropdown.querySelector('.dropdown-label');
        const menu = dropdown.querySelector('.dropdown-menu');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
        const items = dropdown.querySelectorAll('.dropdown-item');
        const arrow = trigger ? trigger.querySelector('svg') : null;

        if (!trigger || !menu || !hiddenInput) return;

        const openMenu = () => {
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) {
                    m.classList.add('hidden');
                    m.classList.remove('scale-100', 'opacity-100');
                    m.classList.add('scale-95', 'opacity-0');
                }
            });

            menu.classList.remove('hidden');
            void menu.offsetHeight;
            menu.classList.remove('scale-95', 'opacity-0');
            menu.classList.add('scale-100', 'opacity-100');
            trigger.classList.add('border-primary-600', 'ring-4', 'ring-primary-600/10');
            if (arrow) arrow.classList.add('rotate-180');
        };

        const closeMenu = () => {
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            trigger.classList.remove('border-primary-600', 'ring-4', 'ring-primary-600/10');
            if (arrow) arrow.classList.remove('rotate-180');
            setTimeout(() => {
                if (menu.classList.contains('opacity-0')) {
                    menu.classList.add('hidden');
                }
            }, 150);
        };

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = !menu.classList.contains('hidden') && menu.classList.contains('opacity-100');
            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        items.forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                const value = item.getAttribute('data-value');
                const text = item.textContent;

                hiddenInput.value = value;
                if (label) label.textContent = text;

                items.forEach(i => i.classList.remove('active', 'bg-primary-50', 'text-primary-600', 'font-semibold'));
                item.classList.add('active', 'bg-primary-50', 'text-primary-600', 'font-semibold');

                closeMenu();
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            });
        });

        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                closeMenu();
            }
        });
    };

    const initAll = () => {
        document.querySelectorAll('.custom-select-wrapper').forEach(wrapper => {
            if (!wrapper.classList.contains('initialized')) {
                wrapper.classList.add('initialized');
                initCustomSelect(wrapper);
            }
        });

        document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
            if (!dropdown.classList.contains('initialized')) {
                dropdown.classList.add('initialized');
                initCustomDropdown(dropdown);
            }
        });
    };

    initAll();

    const observer = new MutationObserver(initAll);
    observer.observe(document.body, { childList: true, subtree: true });
});
