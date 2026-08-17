window.clearAllFormDrafts = () => {
    try {
        Object.keys(sessionStorage).forEach(key => {
            if (key.startsWith('form_draft_')) {
                sessionStorage.removeItem(key);
            }
        });
    } catch (e) {}
};

document.addEventListener('DOMContentLoaded', () => {
    const targetForms = document.querySelectorAll('#create-student-form, #edit-student-form, form[data-auto-draft="true"]');
    if (targetForms.length === 0) return;

    targetForms.forEach(form => {
        const path = window.location.pathname;
        const draftKey = 'form_draft_' + path;
        let isDirty = false;
        let isFormSubmitting = false;
        let saveTimeout = null;

        const getFormState = () => {
            const state = {};
            const inputs = form.querySelectorAll('input:not([type="hidden"]):not([type="password"]):not([type="submit"]), select, textarea');
            inputs.forEach(input => {
                if (!input.name) return;
                if (input.type === 'checkbox' || input.type === 'radio') {
                    if (input.checked) {
                        state[input.name] = input.value;
                    }
                } else {
                    state[input.name] = input.value ? input.value.trim() : '';
                }
            });
            return state;
        };

        const initialFormState = getFormState();

        const getDraft = () => {
            try {
                const saved = sessionStorage.getItem(draftKey);
                return saved ? JSON.parse(saved) : null;
            } catch (e) {
                return null;
            }
        };

        const saveDraft = () => {
            if (window.isFormSubmitting || isFormSubmitting) return;

            const currentState = getFormState();
            let isDifferent = false;

            Object.keys(currentState).forEach(key => {
                if (currentState[key] !== (initialFormState[key] || '')) {
                    isDifferent = true;
                }
            });

            if (isDifferent) {
                sessionStorage.setItem(draftKey, JSON.stringify(currentState));
            } else {
                sessionStorage.removeItem(draftKey);
            }
        };

        const clearDraft = () => {
            sessionStorage.removeItem(draftKey);
        };

        const restoreDraft = (draftData) => {
            if (!draftData) return;

            Object.keys(draftData).forEach(name => {
                const val = draftData[name];
                const fields = form.querySelectorAll(`[name="${name}"]`);

                fields.forEach(field => {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        field.checked = (field.value === val);
                    } else {
                        field.value = val;
                    }

                    field.dispatchEvent(new Event('input', { bubbles: true }));
                    field.dispatchEvent(new Event('change', { bubbles: true }));

                    const selectWrapper = field.closest('.custom-select-wrapper');
                    if (selectWrapper) {
                        const triggerValue = selectWrapper.querySelector('.select-value');
                        const selectedOption = selectWrapper.querySelector(`.select-option[data-value="${val}"]`);
                        if (triggerValue && selectedOption) {
                            triggerValue.textContent = selectedOption.textContent.trim();
                            triggerValue.classList.remove('text-neutral-400');
                            triggerValue.classList.add('text-neutral-900');
                        }
                    }

                    const datepickerWrapper = field.closest('.custom-datepicker-wrapper');
                    if (datepickerWrapper) {
                        const displayInput = datepickerWrapper.querySelector('.datepicker-display');
                        if (displayInput) {
                            displayInput.value = val;
                        }
                    }
                });
            });
            isDirty = true;
        };

        const checkSavedDraft = () => {
            const draft = getDraft();
            if (!draft || Object.keys(draft).length === 0) return;

            let hasMeaningfulDifference = false;
            Object.keys(draft).forEach(key => {
                const draftVal = draft[key] ? draft[key].trim() : '';
                const initVal = initialFormState[key] ? initialFormState[key].trim() : '';
                if (draftVal !== initVal) {
                    hasMeaningfulDifference = true;
                }
            });

            if (!hasMeaningfulDifference) {
                clearDraft();
                return;
            }

            const banner = document.createElement('div');
            banner.id = 'draft-restore-banner';
            banner.className = 'mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 font-sans select-none animate-fade-in shadow-xs';
            banner.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-100 border border-amber-200 flex items-center justify-center text-amber-700 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-amber-900 font-sans">Ditemukan Perubahan Draf Belum Disimpan</h4>
                        <p class="text-xs text-amber-700 font-sans">Anda memiliki perubahan data dari sesi sebelumnya yang belum disubmit.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end flex-shrink-0">
                    <button type="button" id="btn-discard-draft" class="px-3 py-1.5 text-xs font-medium text-amber-800 hover:bg-amber-100 rounded-lg transition-colors cursor-pointer">Buang Draf</button>
                    <button type="button" id="btn-restore-draft" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg shadow-xs transition-colors cursor-pointer">Pulihkan Draf</button>
                </div>
            `;

            form.insertBefore(banner, form.firstChild);

            document.getElementById('btn-restore-draft').addEventListener('click', () => {
                restoreDraft(draft);
                banner.remove();
            });

            document.getElementById('btn-discard-draft').addEventListener('click', () => {
                clearDraft();
                banner.remove();
            });
        };

        checkSavedDraft();

        const handleInput = () => {
            isDirty = true;
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(saveDraft, 400);
        };

        const inputs = form.querySelectorAll('input:not([type="hidden"]):not([type="password"]):not([type="submit"]), select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', handleInput);
            input.addEventListener('change', handleInput);
        });

        form.addEventListener('submit', () => {
            window.isFormSubmitting = true;
            isFormSubmitting = true;
            clearDraft();
        });

        window.addEventListener('beforeunload', (e) => {
            if (isDirty && !isFormSubmitting && !window.isFormSubmitting) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    });
});
