<div 
    id="validation-error-modal" 
    class="modal-backdrop fixed inset-0 z-[60] flex items-center justify-center bg-neutral-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-150 ease-out select-none"
>
    <div class="modal-card bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl border border-neutral-100 transform scale-95 transition-transform duration-150 ease-out text-center flex flex-col items-center">
        <div class="w-14 h-14 rounded-full bg-danger-bg flex items-center justify-center mb-4 text-danger border border-danger/10">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>

        <h3 class="text-base font-bold text-neutral-900 mb-1.5 font-sans">Formulir Belum Lengkap</h3>
        <p class="text-xs text-neutral-600 mb-6 leading-relaxed font-sans px-2">
            Terdapat kolom wajib bertanda (<span class="text-danger font-bold">*</span>) yang belum diisi atau tidak valid. Harap periksa dan lengkapi data terlebih dahulu.
        </p>

        <div class="w-full flex items-center justify-center">
            <x-ui.button type="button" variant="primary" id="btn-dismiss-validation-modal" class="w-full justify-center">
                <span>Periksa Formulir</span>
            </x-ui.button>
        </div>
    </div>
</div>
