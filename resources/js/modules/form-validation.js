document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.setAttribute('novalidate', '');
    });

    const validationModal = document.getElementById('validation-error-modal');
    const dismissModalBtn = document.getElementById('btn-dismiss-validation-modal');
    const confirmSaveModal = document.getElementById('save-confirm-modal');
    const confirmSaveForm = document.getElementById('save-confirm-modal-form');
    const btnTriggerSave = document.getElementById('btn-trigger-save');

    let activeErrorTabTarget = null;
    let firstErrorElement = null;
    let pendingSubmitForm = null;

    const openValidationModal = () => {
        if (!validationModal) return;
        validationModal.classList.remove('hidden');
        requestAnimationFrame(() => {
            validationModal.classList.remove('opacity-0');
            const card = validationModal.querySelector('.modal-card');
            if (card) {
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }
        });
    };

    const closeValidationModal = () => {
        if (!validationModal) return;
        const card = validationModal.querySelector('.modal-card');
        if (card) {
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }
        validationModal.classList.add('opacity-0');
        setTimeout(() => {
            validationModal.classList.add('hidden');
            if (activeErrorTabTarget) {
                const tabBtn = document.querySelector(`.tab-item[data-target="${activeErrorTabTarget}"]`);
                if (tabBtn) {
                    tabBtn.click();
                }
            }
            if (firstErrorElement) {
                firstErrorElement.focus();
                firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 150);
    };

    if (dismissModalBtn) {
        dismissModalBtn.addEventListener('click', closeValidationModal);
    }
    if (validationModal) {
        validationModal.addEventListener('click', (e) => {
            if (e.target === validationModal) {
                closeValidationModal();
            }
        });
    }

    const openConfirmModal = () => {
        if (!confirmSaveModal) return;
        confirmSaveModal.classList.remove('hidden');
        requestAnimationFrame(() => {
            confirmSaveModal.classList.remove('opacity-0');
            const card = confirmSaveModal.querySelector('.modal-card');
            if (card) {
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }
        });
    };

    if (confirmSaveForm) {
        confirmSaveForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const studentForm = document.getElementById('create-student-form') || document.getElementById('edit-student-form') || pendingSubmitForm;
            if (studentForm) {
                studentForm.classList.add('submitting-validated');
                studentForm.submit();
            }
        });
    }

    const checkFormValidity = (form) => {
        let isValid = true;
        firstErrorElement = null;
        activeErrorTabTarget = null;

        const allFormGroups = form.querySelectorAll('.w-full');
        allFormGroups.forEach(group => {
            const hasAsterisk = group.querySelector('label .text-danger') !== null;
            const targetField = group.querySelector('input, select, textarea');
            if (!targetField) return;

            const isRequired = targetField.hasAttribute('required') || hasAsterisk;
            const val = targetField.value ? targetField.value.trim() : '';
            const isInvalid = isRequired && val === '';

            if (isInvalid || targetField.classList.contains('has-error')) {
                isValid = false;
                targetField.classList.add('has-error', 'border-danger');

                const selectWrapper = group.querySelector('.custom-select-wrapper');
                const customTrigger = selectWrapper ? selectWrapper.querySelector('.custom-select-trigger') : null;
                if (customTrigger) {
                    customTrigger.classList.add('has-error', 'border-danger');
                }

                const datepickerWrapper = group.querySelector('.custom-datepicker-wrapper');
                const datepickerDisplay = datepickerWrapper ? datepickerWrapper.querySelector('.datepicker-display') : null;
                if (datepickerDisplay) {
                    datepickerDisplay.classList.add('has-error', 'border-danger');
                }

                if (!firstErrorElement) {
                    firstErrorElement = customTrigger || datepickerDisplay || targetField;
                    const tabPane = group.closest('.tab-pane');
                    if (tabPane) {
                        activeErrorTabTarget = tabPane.id;
                    }
                }
            }
        });

        return isValid;
    };

    const handleSaveTrigger = (form) => {
        pendingSubmitForm = form;
        const isValid = checkFormValidity(form);

        if (!isValid) {
            openValidationModal();
        } else {
            if (confirmSaveModal) {
                openConfirmModal();
            } else {
                form.classList.add('submitting-validated');
                form.submit();
            }
        }
    };

    if (btnTriggerSave) {
        btnTriggerSave.addEventListener('click', (e) => {
            e.preventDefault();
            const form = btnTriggerSave.closest('form');
            if (form) {
                handleSaveTrigger(form);
            }
        });
    }

    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (form === confirmSaveForm) return;
        if (form.classList.contains('no-validate-modal')) return;
        if (form.classList.contains('submitting-validated')) return;

        e.preventDefault();
        handleSaveTrigger(form);
    });

    const hasServerErrors = document.querySelectorAll('.has-error, .text-danger');
    if (hasServerErrors.length > 0) {
        const firstErrorNode = document.querySelector('.has-error, .text-danger');
        if (firstErrorNode) {
            const tabPane = firstErrorNode.closest('.tab-pane');
            if (tabPane) {
                const tabBtn = document.querySelector(`.tab-item[data-target="${tabPane.id}"]`);
                if (tabBtn) {
                    tabBtn.click();
                }
            }
        }
    }

    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        const clearError = () => {
            input.classList.remove('has-error', 'border-danger');
            const group = input.closest('.w-full');
            if (group) {
                const customTrigger = group.querySelector('.custom-select-trigger');
                if (customTrigger) {
                    customTrigger.classList.remove('has-error', 'border-danger');
                }
                const datepickerDisplay = group.querySelector('.datepicker-display');
                if (datepickerDisplay) {
                    datepickerDisplay.classList.remove('has-error', 'border-danger');
                }
                const clientError = group.querySelector('.client-error-msg');
                if (clientError) {
                    clientError.remove();
                }
            }
        };

        input.addEventListener('input', clearError);
        input.addEventListener('change', clearError);
    });
});
