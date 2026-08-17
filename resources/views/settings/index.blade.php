@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('breadcrumbs')
    <span class="text-neutral-500 font-normal">Profil Sekolah</span>
@endsection

@section('content')
    <x-data.section-header title="Profil Sekolah" subtitle="Atur identitas lembaga, kepala sekolah, dan tahun pelajaran" />

    <form action="{{ route('settings.update') }}" method="POST" id="settings-form" autocomplete="one-time-code">
        @csrf

        <div class="flex border-b border-neutral-200 mb-8 gap-2 no-print select-none overflow-x-auto whitespace-nowrap pb-1">
            <x-navigation.tab-item target="tab-lembaga" label="1. Identitas Lembaga" active />
            <x-navigation.tab-item target="tab-alamat" label="2. Data Alamat" />
            <x-navigation.tab-item target="tab-pejabat" label="3. Pejabat Penandatangan" />
        </div>

        <x-ui.card class="mb-6 shadow-sm">
            <fieldset id="settings-fieldset" disabled class="disabled:opacity-90 transition-opacity duration-150">
                <div id="tab-lembaga" class="tab-pane flex flex-col gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form.form-group label="Nama Sekolah Resmi" name="name" :required="true">
                            <x-form.input name="name" placeholder="Contoh: SMPN 1 Cisewu" value="{{ old('name', $school->name ?? '') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="Tahun Pelajaran Aktif" name="academic_year" helper="Format: YYYY-YYYY" :required="true">
                            <x-form.input name="academic_year" placeholder="Contoh: 2025-2026" value="{{ old('academic_year', $school->academic_year ?? '') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="NPSN (Nomor Pokok Sekolah Nasional)" name="npsn" :required="true">
                            <x-form.input name="npsn" placeholder="NPSN Sekolah" value="{{ old('npsn', $school->npsn ?? '') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="NSS (Nomor Statistik Sekolah)" name="nss">
                            <x-form.input name="nss" placeholder="NSS Sekolah" value="{{ old('nss', $school->nss ?? '') }}" />
                        </x-form.form-group>
                    </div>
                </div>

                <div id="tab-alamat" class="tab-pane hidden flex flex-col gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-form.form-group label="Alamat Jalan Sekolah" name="address" :required="true">
                                <x-form.textarea name="address" placeholder="Masukkan alamat lengkap sekolah" value="{{ old('address', $school->address ?? '') }}" required />
                            </x-form.form-group>
                        </div>

                        <x-form.form-group label="RT" name="rt">
                            <x-form.input name="rt" type="number" placeholder="Contoh: 15" value="{{ old('rt', $school->rt ?? '') }}" />
                        </x-form.form-group>

                        <x-form.form-group label="RW" name="rw">
                            <x-form.input name="rw" type="number" placeholder="Contoh: 18" value="{{ old('rw', $school->rw ?? '') }}" />
                        </x-form.form-group>

                        <x-form.form-group label="Desa / Kelurahan" name="village" :required="true">
                            <x-form.input name="village" placeholder="Contoh: Desa Cisewu" value="{{ old('village', $school->village ?? '') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="Kecamatan" name="district" :required="true">
                            <x-form.input name="district" placeholder="Contoh: Cisewu" value="{{ old('district', $school->district ?? '') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="Kabupaten / Kota" name="regency" :required="true">
                            <x-form.input name="regency" placeholder="Contoh: Kabupaten Garut" value="{{ old('regency', $school->regency ?? '') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="Provinsi" name="province" :required="true">
                            <x-form.input name="province" placeholder="Contoh: Jawa Barat" value="{{ old('province', $school->province ?? '') }}" required />
                        </x-form.form-group>
                    </div>
                </div>

                <div id="tab-pejabat" class="tab-pane hidden flex flex-col gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-6">
                            <x-form.form-group label="Nama Kepala Sekolah" name="headmaster_name" :required="true">
                                <x-form.input name="headmaster_name" placeholder="Nama Lengkap & Gelar" value="{{ old('headmaster_name', $school->headmaster_name ?? '') }}" required />
                            </x-form.form-group>

                            <x-form.form-group label="NIP Kepala Sekolah" name="headmaster_nip" :required="true">
                                <x-form.input name="headmaster_nip" placeholder="NIP Kepala Sekolah" value="{{ old('headmaster_nip', $school->headmaster_nip ?? '') }}" required />
                            </x-form.form-group>

                            <x-form.form-group label="Masa Jabatan" name="headmaster_period">
                                <x-form.input name="headmaster_period" placeholder="Contoh: 2024 - Sekarang" value="{{ old('headmaster_period', $school->headmaster_period ?? '') }}" />
                            </x-form.form-group>
                        </div>

                        <div class="flex flex-col gap-6">
                            <x-form.form-group label="Nama Kepala Tata Usaha" name="tu_head_name">
                                <x-form.input name="tu_head_name" placeholder="Nama Lengkap & Gelar" value="{{ old('tu_head_name', $school->tu_head_name ?? '') }}" />
                            </x-form.form-group>

                            <x-form.form-group label="NIP Kepala Tata Usaha" name="tu_head_nip">
                                <x-form.input name="tu_head_nip" placeholder="NIP Kepala TU" value="{{ old('tu_head_nip', $school->tu_head_nip ?? '') }}" />
                            </x-form.form-group>

                            <x-form.form-group label="Masa Jabatan" name="tu_head_period">
                                <x-form.input name="tu_head_period" placeholder="Contoh: 2023 - Sekarang" value="{{ old('tu_head_period', $school->tu_head_period ?? '') }}" />
                            </x-form.form-group>
                        </div>
                    </div>
                </div>
            </fieldset>
        </x-ui.card>

        <div class="flex items-center justify-end gap-3 select-none">
            <div id="read-only-footer-actions">
                <x-ui.button type="button" variant="warning" id="btn-enable-edit-footer">
                    <x-ui.icon name="edit" class="w-4 h-4 text-white stroke-white" />
                    <span>Ubah Profil Sekolah</span>
                </x-ui.button>
            </div>

            <div id="edit-mode-footer-actions" class="flex items-center gap-3 hidden">
                <x-ui.button type="button" variant="secondary" id="btn-cancel-edit-footer">
                    <span>Batal</span>
                </x-ui.button>
                <x-ui.button 
                    type="button" 
                    variant="primary"
                    id="btn-trigger-save"
                >
                    <x-ui.icon name="save" class="w-4 h-4 text-white stroke-white" />
                    <span>Simpan Perubahan</span>
                </x-ui.button>
            </div>
        </div>

        <x-feedback.modal-confirm 
            id="save-confirm-modal" 
            title="Simpan Perubahan Profil Sekolah" 
            confirmText="Simpan" 
            confirmVariant="primary"
        >
            Apakah Anda yakin ingin menyimpan perubahan konfigurasi data sekolah? Perubahan ini akan langsung mempengaruhi penandatanganan cetakan laporan Buku Induk.
        </x-feedback.modal-confirm>
    </form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fieldset = document.getElementById('settings-fieldset');
        const form = document.getElementById('settings-form');
        const readOnlyFooter = document.getElementById('read-only-footer-actions');
        const editModeFooter = document.getElementById('edit-mode-footer-actions');

        const btnEnableEditFooter = document.getElementById('btn-enable-edit-footer');
        const btnCancelEditFooter = document.getElementById('btn-cancel-edit-footer');

        const enableEditMode = () => {
            if (fieldset) fieldset.disabled = false;
            if (readOnlyFooter) readOnlyFooter.classList.add('hidden');
            if (editModeFooter) editModeFooter.classList.remove('hidden');

            const firstInput = form ? form.querySelector('input:not([type="hidden"]), select, textarea') : null;
            if (firstInput) {
                firstInput.focus();
            }
        };

        const disableEditMode = () => {
            if (form) form.reset();
            if (fieldset) fieldset.disabled = true;
            if (readOnlyFooter) readOnlyFooter.classList.remove('hidden');
            if (editModeFooter) editModeFooter.classList.add('hidden');

            document.querySelectorAll('.has-error, .border-danger').forEach(el => {
                el.classList.remove('has-error', 'border-danger');
            });
        };

        if (btnEnableEditFooter) btnEnableEditFooter.addEventListener('click', enableEditMode);
        if (btnCancelEditFooter) btnCancelEditFooter.addEventListener('click', disableEditMode);
    });
</script>
@endsection
