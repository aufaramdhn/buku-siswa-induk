@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('breadcrumbs')
    <span class="text-neutral-500 font-normal">Mata Pelajaran</span>
@endsection

@section('content')
    <x-data.section-header title="Manajemen Mata Pelajaran" subtitle="Kelola master data mata pelajaran kurikulum sekolah" />

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-1/3 order-first lg:order-last">
            <x-ui.card>
                <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider mb-4 font-sans select-none">Tambah Mata Pelajaran</h3>
                
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-4">
                        <x-form.form-group label="Kode Mata Pelajaran" name="code" helper="Contoh: MP12">
                            <x-form.input name="code" placeholder="Masukkan kode unik" value="{{ old('code') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="Nama Mata Pelajaran" name="name" helper="Masukkan nama lengkap mapel">
                            <x-form.input name="name" placeholder="Contoh: Bahasa Daerah" value="{{ old('name') }}" required />
                        </x-form.form-group>

                        <x-ui.button type="submit" variant="primary" class="w-full mt-2">
                            <x-ui.icon name="plus" class="w-4 h-4 text-white stroke-white" />
                            <span>Tambah Mapel</span>
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
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Nama Mata Pelajaran</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr class="border-b border-neutral-200 hover:bg-neutral-50/50 transition-colors">
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 font-semibold text-center">{{ $subject->code }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900">{{ $subject->name }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans">
                                    <div class="flex items-center justify-center">
                                        <x-ui.button-icon 
                                            icon="trash" 
                                            variant="danger" 
                                            data-modal-target="#delete-confirm-modal-{{ $subject->id }}" 
                                        />
                                    </div>

                                    <x-feedback.modal-confirm 
                                        id="delete-confirm-modal-{{ $subject->id }}" 
                                        action="{{ route('subjects.destroy', $subject->id) }}" 
                                        method="DELETE"
                                        title="Hapus Mata Pelajaran" 
                                        confirmText="Hapus" 
                                        confirmVariant="danger"
                                    >
                                        Apakah Anda yakin ingin menghapus mata pelajaran <strong>{{ $subject->name }}</strong> (Kode: {{ $subject->code }})? Tindakan ini juga akan memutuskan mata pelajaran ini dari seluruh siswa yang terdaftar.
                                    </x-feedback.modal-confirm>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sm text-neutral-500 font-sans">
                                    Belum ada mata pelajaran terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-data.table>
            </div>

            <!-- Mobile Cards (< md) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
                @forelse($subjects as $subject)
                    <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm flex flex-col justify-between gap-3">
                        <div class="flex items-center justify-between border-b border-neutral-100 pb-2 select-none">
                            <span class="text-xs font-mono font-bold text-neutral-500 bg-neutral-100 px-2 py-0.5 rounded border border-neutral-200">
                                {{ $subject->code }}
                            </span>
                            <x-ui.button-icon 
                                icon="trash" 
                                variant="danger" 
                                data-modal-target="#delete-confirm-modal-mobile-{{ $subject->id }}" 
                            />
                        </div>
                        <div>
                            <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider block">Mata Pelajaran</span>
                            <h4 class="text-sm font-semibold text-neutral-900 font-sans">{{ $subject->name }}</h4>
                        </div>

                        <x-feedback.modal-confirm 
                            id="delete-confirm-modal-mobile-{{ $subject->id }}" 
                            action="{{ route('subjects.destroy', $subject->id) }}" 
                            method="DELETE"
                            title="Hapus Mata Pelajaran" 
                            confirmText="Hapus" 
                            confirmVariant="danger"
                        >
                            Apakah Anda yakin ingin menghapus mata pelajaran <strong>{{ $subject->name }}</strong> (Kode: {{ $subject->code }})? Tindakan ini juga akan memutuskan mata pelajaran ini dari seluruh siswa yang terdaftar.
                        </x-feedback.modal-confirm>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-neutral-200 rounded-xl p-8 text-center text-sm text-neutral-500 font-sans">
                        Belum ada mata pelajaran terdaftar.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
