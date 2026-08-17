document.addEventListener('DOMContentLoaded', () => {
    const months = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const initCustomDatepicker = (wrapper) => {
        const hiddenInput = wrapper.querySelector('.datepicker-value');
        const displayInput = wrapper.querySelector('.datepicker-display');
        const triggerBtn = wrapper.querySelector('.datepicker-trigger');
        const calendarPane = wrapper.querySelector('.datepicker-calendar');
        
        if (!hiddenInput || !displayInput || !calendarPane) return;

        const prevBtn = calendarPane.querySelector('.prev-month');
        const nextBtn = calendarPane.querySelector('.next-month');
        const label = calendarPane.querySelector('.month-year-label');
        const grid = calendarPane.querySelector('.days-grid');
        const btnClear = calendarPane.querySelector('.btn-clear-date');
        const btnToday = calendarPane.querySelector('.btn-today-date');

        let selectedDate = null;
        let viewMonth = new Date().getMonth();
        let viewYear = new Date().getFullYear();

        const parseDate = (val) => {
            if (!val) return null;
            const parts = val.split('-');
            if (parts.length === 3) {
                return new Date(parts[0], parts[1] - 1, parts[2]);
            }
            return null;
        };

        const formatDateDisplay = (date) => {
            if (!date) return '';
            const d = String(date.getDate()).padStart(2, '0');
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const y = date.getFullYear();
            return `${d}-${m}-${y}`;
        };

        const formatDateDb = (date) => {
            if (!date) return '';
            const d = String(date.getDate()).padStart(2, '0');
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const y = date.getFullYear();
            return `${y}-${m}-${d}`;
        };

        const syncFromValue = () => {
            selectedDate = parseDate(hiddenInput.value);
            if (selectedDate) {
                displayInput.value = formatDateDisplay(selectedDate);
                viewMonth = selectedDate.getMonth();
                viewYear = selectedDate.getFullYear();
            } else {
                displayInput.value = '';
            }
        };

        const openCalendar = () => {
            document.querySelectorAll('.dropdown-menu').forEach(c => {
                if (c !== calendarPane) {
                    c.classList.add('hidden');
                    c.classList.remove('scale-100', 'opacity-100');
                    c.classList.add('scale-95', 'opacity-0');
                    const w = c.closest('.custom-select-wrapper');
                    const t = w ? w.querySelector('.custom-select-trigger') : null;
                    if (t) t.classList.remove('border-blue-600', 'ring-4', 'ring-blue-600/10');
                    const a = t ? t.querySelector('svg') : null;
                    if (a) a.classList.remove('rotate-180');
                }
            });

            syncFromValue();
            renderCalendar();

            calendarPane.classList.remove('hidden');
            void calendarPane.offsetHeight;
            calendarPane.classList.remove('scale-95', 'opacity-0');
            calendarPane.classList.add('scale-100', 'opacity-100');
        };

        const closeCalendar = () => {
            calendarPane.classList.remove('scale-100', 'opacity-100');
            calendarPane.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                if (calendarPane.classList.contains('opacity-0')) {
                    calendarPane.classList.add('hidden');
                }
            }, 150);
        };

        const renderCalendar = () => {
            grid.innerHTML = '';

            const headerContainer = calendarPane.querySelector('.month-year-label');
            headerContainer.innerHTML = '';

            const monthSelect = document.createElement('select');
            monthSelect.className = 'text-sm font-semibold text-neutral-800 bg-transparent border-none outline-none cursor-pointer pr-1 appearance-none hover:text-blue-600 transition-colors';
            months.forEach((m, i) => {
                const opt = document.createElement('option');
                opt.value = i;
                opt.textContent = m;
                if (i === viewMonth) opt.selected = true;
                monthSelect.appendChild(opt);
            });

            const yearSelect = document.createElement('select');
            yearSelect.className = 'text-sm font-semibold text-neutral-800 bg-transparent border-none outline-none cursor-pointer appearance-none hover:text-blue-600 transition-colors';
            const currentYear = new Date().getFullYear();
            for (let y = currentYear; y >= currentYear - 100; y--) {
                const opt = document.createElement('option');
                opt.value = y;
                opt.textContent = y;
                if (y === viewYear) opt.selected = true;
                yearSelect.appendChild(opt);
            }

            monthSelect.addEventListener('change', (e) => {
                e.stopPropagation();
                viewMonth = parseInt(monthSelect.value);
                renderCalendar();
            });

            yearSelect.addEventListener('change', (e) => {
                e.stopPropagation();
                viewYear = parseInt(yearSelect.value);
                renderCalendar();
            });

            headerContainer.appendChild(monthSelect);
            headerContainer.appendChild(yearSelect);

            const firstDay = new Date(viewYear, viewMonth, 1).getDay();
            const totalDays = new Date(viewYear, viewMonth + 1, 0).getDate();
            const prevTotalDays = new Date(viewYear, viewMonth, 0).getDate();

            for (let i = firstDay - 1; i >= 0; i--) {
                const dayNum = prevTotalDays - i;
                const cell = document.createElement('div');
                cell.className = 'text-center py-1.5 text-xs text-neutral-300 select-none font-sans cursor-default';
                cell.textContent = dayNum;
                grid.appendChild(cell);
            }

            const today = new Date();

            for (let day = 1; day <= totalDays; day++) {
                const cell = document.createElement('div');
                const isSelected = selectedDate && 
                                   selectedDate.getDate() === day && 
                                   selectedDate.getMonth() === viewMonth && 
                                   selectedDate.getFullYear() === viewYear;
                
                const isToday = today.getDate() === day && 
                                today.getMonth() === viewMonth && 
                                today.getFullYear() === viewYear;

                let cellClass = 'text-center py-1.5 text-xs font-sans rounded-lg cursor-pointer transition-colors select-none flex items-center justify-center h-8 w-8 mx-auto ';
                
                if (isSelected) {
                    cellClass += 'bg-blue-600 text-white font-semibold';
                } else if (isToday) {
                    cellClass += 'border border-blue-600 text-blue-600 font-semibold hover:bg-neutral-50';
                } else {
                    cellClass += 'text-neutral-700 hover:bg-neutral-50 active:bg-neutral-100';
                }

                cell.className = cellClass;
                cell.textContent = day;

                cell.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const newDate = new Date(viewYear, viewMonth, day);
                    hiddenInput.value = formatDateDb(newDate);
                    displayInput.value = formatDateDisplay(newDate);
                    hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                    selectedDate = newDate;
                    closeCalendar();
                });

                grid.appendChild(cell);
            }

            const filledCells = firstDay + totalDays;
            const remaining = (7 - (filledCells % 7)) % 7;
            for (let i = 1; i <= remaining; i++) {
                const cell = document.createElement('div');
                cell.className = 'text-center py-1.5 text-xs text-neutral-300 select-none font-sans cursor-default';
                cell.textContent = i;
                grid.appendChild(cell);
            }
        };

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                viewMonth--;
                if (viewMonth < 0) {
                    viewMonth = 11;
                    viewYear--;
                }
                renderCalendar();
            });

            nextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                viewMonth++;
                if (viewMonth > 11) {
                    viewMonth = 0;
                    viewYear++;
                }
                renderCalendar();
            });
        }

        if (btnClear) {
            btnClear.addEventListener('click', (e) => {
                e.stopPropagation();
                hiddenInput.value = '';
                displayInput.value = '';
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                selectedDate = null;
                closeCalendar();
            });
        }

        if (btnToday) {
            btnToday.addEventListener('click', (e) => {
                e.stopPropagation();
                const now = new Date();
                hiddenInput.value = formatDateDb(now);
                displayInput.value = formatDateDisplay(now);
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                selectedDate = now;
                viewMonth = now.getMonth();
                viewYear = now.getFullYear();
                closeCalendar();
            });
        }

        displayInput.addEventListener('click', (e) => {
            e.stopPropagation();
            openCalendar();
        });

        displayInput.addEventListener('focus', () => {
            openCalendar();
        });

        if (triggerBtn) {
            triggerBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = !calendarPane.classList.contains('hidden') && calendarPane.classList.contains('opacity-100');
                if (isOpen) {
                    closeCalendar();
                } else {
                    openCalendar();
                }
            });
        }

        displayInput.addEventListener('input', (e) => {
            let val = displayInput.value.replace(/[^0-9-]/g, '');
            
            const originalLen = val.length;
            const pureDigits = val.replace(/-/g, '');
            
            if (e.inputType !== 'deleteContentBackward') {
                if (pureDigits.length > 2 && pureDigits.length <= 4) {
                    val = pureDigits.slice(0, 2) + '-' + pureDigits.slice(2);
                } else if (pureDigits.length > 4) {
                    val = pureDigits.slice(0, 2) + '-' + pureDigits.slice(2, 4) + '-' + pureDigits.slice(4, 8);
                }
            }
            
            displayInput.value = val;

            const match = val.match(/^(\d{2})-(\d{2})-(\d{4})$/);
            if (match) {
                const d = parseInt(match[1], 10);
                const m = parseInt(match[2], 10) - 1;
                const y = parseInt(match[3], 10);

                if (m >= 0 && m < 12 && d > 0 && d <= 31) {
                    const parsed = new Date(y, m, d);
                    if (parsed.getFullYear() === y && parsed.getMonth() === m && parsed.getDate() === d) {
                        hiddenInput.value = formatDateDb(parsed);
                        hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                        selectedDate = parsed;
                        viewMonth = m;
                        viewYear = y;
                        renderCalendar();
                    }
                }
            } else if (val === '') {
                hiddenInput.value = '';
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                selectedDate = null;
            }
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
                closeCalendar();
            }
        });
    };

    const initAll = () => {
        document.querySelectorAll('.custom-datepicker-wrapper').forEach(wrapper => {
            if (!wrapper.classList.contains('initialized')) {
                wrapper.classList.add('initialized');
                initCustomDatepicker(wrapper);
            }
        });
    };

    initAll();

    const observer = new MutationObserver(initAll);
    observer.observe(document.body, { childList: true, subtree: true });
});
