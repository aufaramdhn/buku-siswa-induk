@extends('layouts.app')

@section('title', 'Ekstrakurikuler')

@section('breadcrumbs')
    <span class="text-neutral-500 font-normal">Ekstrakurikuler</span>
@endsection

@section('content')
    <x-data.section-header title="Manajemen Ekstrakurikuler" subtitle="Kelola master data kegiatan ekstrakurikuler sekolah" />

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-1/3 order-first lg:order-last">
            <x-ui.card>
                <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider mb-4 font-sans select-none">Tambah Ekstrakurikuler</h3>
                
                <form action="{{ route('extracurriculars.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-4">
                        <x-form.form-group label="Kode Ekstrakurikuler" name="code" helper="Contoh: EK09">
                            <x-form.input name="code" placeholder="Masukkan kode unik" value="{{ old('code') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="Nama Ekstrakurikuler" name="name" helper="Masukkan nama lengkap kegiatan">
                            <x-form.input name="name" placeholder="Contoh: Seni Musik" value="{{ old('name') }}" required />
                        </x-form.form-group>

                        <x-ui.button type="submit" variant="primary" class="w-full mt-2">
                            <x-ui.icon name="plus" class="w-4 h-4 text-white stroke-white" />
                            <span>Tambah Ekskul</span>
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>

        <div class="w-full lg:w-2/3 order-last lg:order-first">
            <!-- Desktop Table (>= md) -->
            <div class="hidden md:block">
                <x-data.table>
                    <thead>
                        <tr class="bg-neutral-50 border-b border-neutral-200 select-none">
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Kode</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Nama Ekstrakurikuler</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($extracurriculars as $ekskul)
                            <tr class="border-b border-neutral-200 hover:bg-neutral-50/50 transition-colors">
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 font-semibold text-center">{{ $ekskul->code }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900">{{ $ekskul->name }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans">
                                    <div class="flex items-center justify-center">
                                        <x-ui.button-icon 
                                            icon="trash" 
                                            variant="danger" 
                                            data-modal-target="#delete-confirm-modal-{{ $ekskul->id }}" 
                                        />
                                    </div>

                                    <x-feedback.modal-confirm 
                                        id="delete-confirm-modal-{{ $ekskul->id }}" 
                                        action="{{ route('extracurriculars.destroy', $ekskul->id) }}" 
                                        method="DELETE"
                                        title="Hapus Ekstrakurikuler" 
                                        confirmText="Hapus" 
                                        confirmVariant="danger"
                                    >
                                        Apakah Anda yakin ingin menghapus ekstrakurikuler <strong>{{ $ekskul->name }}</strong> (Kode: {{ $ekskul->code }})? Tindakan ini juga akan memutuskan kegiatan ini dari seluruh siswa yang terdaftar.
                                    </x-feedback.modal-confirm>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sm text-neutral-500 font-sans">
                                    Belum ada kegiatan ekstrakurikuler terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-data.table>
            </div>

            <!-- Mobile Cards (< md) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
                @forelse($extracurriculars as $ekskul)
                    <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm flex flex-col justify-between gap-3">
                        <div class="flex items-center justify-between border-b border-neutral-100 pb-2 select-none">
                            <span class="text-xs font-mono font-bold text-neutral-500 bg-neutral-100 px-2 py-0.5 rounded border border-neutral-200">
                                {{ $ekskul->code }}
                            </span>
                            <x-ui.button-icon 
                                icon="trash" 
                                variant="danger" 
                                data-modal-target="#delete-confirm-modal-mobile-{{ $ekskul->id }}" 
                            />
                        </div>
                        <div>
                            <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider block">Ekstrakurikuler</span>
                            <h4 class="text-sm font-semibold text-neutral-900 font-sans">{{ $ekskul->name }}</h4>
                        </div>

                        <x-feedback.modal-confirm 
                            id="delete-confirm-modal-mobile-{{ $ekskul->id }}" 
                            action="{{ route('extracurriculars.destroy', $ekskul->id) }}" 
                            method="DELETE"
                            title="Hapus Ekstrakurikuler" 
                            confirmText="Hapus" 
                            confirmVariant="danger"
                        >
                            Apakah Anda yakin ingin menghapus ekstrakurikuler <strong>{{ $ekskul->name }}</strong> (Kode: {{ $ekskul->code }})? Tindakan ini juga akan memutuskan kegiatan ini dari seluruh siswa yang terdaftar.
                        </x-feedback.modal-confirm>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-neutral-200 rounded-xl p-8 text-center text-sm text-neutral-500 font-sans">
                        Belum ada kegiatan ekstrakurikuler terdaftar.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
