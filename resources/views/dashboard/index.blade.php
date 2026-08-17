@extends('layouts.app')

@section('title', 'Dasbor')

@section('breadcrumbs')
    <span class="text-neutral-500 font-normal">Dasbor</span>
@endsection

@section('content')
    <x-data.section-header 
        title="Selamat Datang Kembali, {{ auth()->user()->username }}!"
        subtitle="Tahun Pelajaran Aktif: {{ $school->academic_year ?? '2025/2026' }}"
    />

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 select-none">
        <x-data.metric-card 
            title="Total Siswa Terdaftar" 
            value="{{ $totalStudents }}" 
            icon="users" 
            variant="primary" 
        />
        
        <x-data.metric-card 
            title="Kelas Aktif" 
            value="{{ $totalRombel }}" 
            icon="dashboard" 
            variant="success" 
        />
        
        <x-data.metric-card 
            title="Siswa Laki-laki" 
            value="{{ $maleCount }}" 
            icon="user" 
            variant="neutral" 
        />
        
        <x-data.metric-card 
            title="Siswa Perempuan" 
            value="{{ $femaleCount }}" 
            icon="user" 
            variant="danger" 
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <!-- Left Column: Aktivitas Pembaruan Terakhir -->
        <div class="lg:col-span-2 bg-white border border-neutral-200 rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-neutral-200 flex items-center justify-between select-none">
                <h3 class="text-sm font-semibold text-neutral-800 font-sans">Aktivitas Pembaruan Terakhir</h3>
                <a href="{{ route('students.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors font-sans">Lihat Semua</a>
            </div>
            <!-- Desktop Table (>= md) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50 border-b border-neutral-200 select-none">
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">NIPD</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Nama Lengkap</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">L/P</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Kelas</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Terakhir Diperbarui</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents as $student)
                            <tr class="border-b border-neutral-200 hover:bg-neutral-50/50 transition-colors">
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 select-none">{{ $student->nipd }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 font-medium select-none">{{ $student->name }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 text-center select-none">{{ $student->gender }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 text-center select-none">{{ $student->rombel }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 select-none">{{ $student->updated_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB</td>
                                <td class="px-6 py-2.5 text-sm font-sans">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-ui.button-icon icon="edit" variant="warning" href="{{ route('students.edit', $student->id) }}" />
                                        <x-ui.button-icon icon="printer" variant="primary" href="{{ route('students.single_student_print', $student->id) }}" target="_blank" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-neutral-500 font-sans">
                                    Belum ada aktivitas data siswa baru-baru ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (< md) -->
            <div class="grid grid-cols-1 gap-3 p-4 md:hidden">
                @forelse($recentStudents as $student)
                    <div class="bg-neutral-50/60 border border-neutral-200 rounded-xl p-3.5 flex flex-col gap-2.5">
                        <div class="flex items-start justify-between gap-2 border-b border-neutral-200/60 pb-2 select-none">
                            <div>
                                <h4 class="text-sm font-semibold text-neutral-900 font-sans">{{ $student->name }}</h4>
                                <span class="text-xs text-neutral-500 font-mono">NIPD: {{ $student->nipd }}</span>
                            </div>
                            <span class="text-[10px] font-semibold text-neutral-500 bg-white border border-neutral-200 px-2 py-0.5 rounded-full font-sans">
                                Kelas {{ $student->rombel }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-neutral-500 font-sans select-none">
                            <span>Diperbarui: {{ $student->updated_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</span>
                            <div class="flex items-center gap-1.5">
                                <x-ui.button-icon icon="edit" variant="warning" href="{{ route('students.edit', $student->id) }}" />
                                <x-ui.button-icon icon="printer" variant="primary" href="{{ route('students.single_student_print', $student->id) }}" target="_blank" />
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-neutral-500 font-sans">
                        Belum ada aktivitas data siswa baru-baru ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Column: Ringkasan Profil Sekolah -->
        <div class="lg:col-span-1 bg-white border border-neutral-200 rounded-xl p-6 shadow-sm flex flex-col gap-5">
            <div class="select-none pb-2 border-b border-neutral-100">
                <h3 class="text-sm font-semibold text-neutral-800 font-sans">Profil Sekolah Aktif</h3>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0 select-none">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <h4 class="text-sm font-semibold text-neutral-900 font-sans">{{ $school->name ?? 'SMP Negeri 1 Cisewu' }}</h4>
                    <span class="text-[10px] text-neutral-400 font-sans font-medium">Sekolah Menengah Pertama</span>
                </div>
            </div>

            <div class="h-px bg-neutral-100 select-none"></div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">NPSN</span>
                    <span class="text-xs font-semibold text-neutral-800 font-sans mt-0.5 select-none">{{ $school->npsn ?? '-' }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">NSS</span>
                    <span class="text-xs font-semibold text-neutral-800 font-sans mt-0.5 select-none">{{ $school->nss ?? '-' }}</span>
                </div>
            </div>

            <div class="h-px bg-neutral-100 select-none"></div>

            <div class="flex flex-col gap-2.5">
                <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">Kepala Sekolah</span>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-neutral-100 border border-neutral-200 flex items-center justify-center text-neutral-600 flex-shrink-0 overflow-hidden select-none">
                        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-neutral-800 font-sans">{{ $school->headmaster_name ?? '-' }}</span>
                        <span class="text-[10px] text-neutral-400 font-sans font-medium select-none">NIP. {{ $school->headmaster_nip ?? '-' }}</span>
                    </div>
                </div>
            </div>

            @can('admin-only')
                <div class="h-px bg-neutral-100 select-none"></div>
                <a href="{{ route('settings.edit') }}" class="w-full flex items-center justify-center gap-2 py-2 border border-neutral-200 hover:bg-neutral-50 active:bg-neutral-200 rounded-lg text-xs font-semibold text-neutral-700 transition-colors mt-1 font-sans select-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4z"></path>
                    </svg>
                    <span>Edit Profil Sekolah</span>
                </a>
            @endcan
        </div>
    </div>
@endsection
