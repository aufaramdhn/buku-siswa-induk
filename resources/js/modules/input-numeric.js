document.addEventListener('DOMContentLoaded', () => {
    const isNumericField = (input) => {
        if (!input) return false;
        if (input.type === 'number') return true;
        if (input.getAttribute('inputmode') === 'numeric') return true;
        if (input.dataset.numeric === 'true') return true;

        const exactNumericNames = [
            'nipd', 'nisn', 'nik', 'kk_number', 'no_kk', 'rt', 'rw', 'postal_code',
            'phone', 'mobile_phone', 'father_nik', 'mother_nik', 'guardian_nik',
            'npsn', 'nss', 'headmaster_nip', 'tu_head_nip', 'child_order',
            'siblings_count', 'height', 'weight', 'head_circumference',
            'distance_km', 'travel_time_minutes', 'kps_number', 'kks_number',
            'kip_number', 'pip_number'
        ];

        const fieldName = (input.name || input.id || '').toLowerCase();
        return exactNumericNames.includes(fieldName);
    };

    document.addEventListener('keydown', (e) => {
        const input = e.target;
        if (input.tagName === 'INPUT' && isNumericField(input)) {
            if (['-', '+', 'e', 'E', '.', ','].includes(e.key)) {
                e.preventDefault();
            }
        }
    });

    document.addEventListener('input', (e) => {
        const input = e.target;
        if (input.tagName === 'INPUT' && isNumericField(input)) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }
    });

    document.addEventListener('paste', (e) => {
        const input = e.target;
        if (input.tagName === 'INPUT' && isNumericField(input)) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const sanitized = pastedText.replace(/[^0-9]/g, '');
            const start = input.selectionStart || 0;
            const end = input.selectionEnd || 0;
            const currentVal = input.value;
            input.value = currentVal.substring(0, start) + sanitized + currentVal.substring(end);
            input.setSelectionRange(start + sanitized.length, start + sanitized.length);
            input.dispatchEvent(new Event('input', { bubbles: true }));
        }
    });
});
