@extends('layouts.app')

@section('title', 'Data Siswa')

@section('breadcrumbs')
    <span class="text-neutral-500 font-normal">Data Siswa</span>
@endsection

@section('content')
    <x-data.section-header title="Buku Induk Siswa" subtitle="Daftar lengkap registrasi data induk siswa">
        @slot('actions')
            <div class="flex items-center gap-2.5 w-full sm:w-auto flex-wrap sm:flex-nowrap">
                <x-ui.button id="btn-export-pdf" href="{{ route('students.all_students_print') }}" target="_blank" variant="secondary" class="w-full sm:w-auto justify-center whitespace-nowrap">
                    <svg class="w-4 h-4 text-neutral-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span class="whitespace-nowrap">Cetak Rekap Seluruh Siswa</span>
                </x-ui.button>
                <x-ui.button href="{{ route('students.create') }}" variant="primary" class="w-full sm:w-auto justify-center whitespace-nowrap">
                    <x-ui.icon name="plus" class="w-4 h-4 text-white stroke-white" />
                    <span class="whitespace-nowrap">Tambah Siswa Baru</span>
                </x-ui.button>
            </div>
        @endslot
    </x-data.section-header>

    <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-center justify-start no-print select-none">
        <div class="relative w-full md:w-80">
            <div class="absolute left-3.5 top-1/2 -translate-y-1/2 flex items-center pointer-events-none select-none">
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <input 
                type="text" 
                id="search-input" 
                placeholder="Cari NIPD, nama, atau NISN..." 
                value="{{ request('search') }}"
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all outline-none"
            />
        </div>

        <div class="h-8 w-px bg-neutral-200 hidden md:block select-none"></div>

        <div class="flex items-end gap-4 w-full md:w-auto flex-wrap md:flex-nowrap">
            <!-- Dropdown Rombel / Kelas -->
            <div class="relative w-full md:w-48 custom-dropdown" id="dropdown-rombel">
                <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">Kelas</span>
                <button 
                    type="button" 
                    class="dropdown-trigger w-full flex items-center justify-between pl-4 pr-3 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm transition-all outline-none cursor-pointer select-none"
                >
                    <span class="dropdown-label truncate">Semua Kelas</span>
                    <svg class="w-4 h-4 text-neutral-500 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <input type="hidden" name="rombel_filter" id="rombel-filter" value="" />
                <div class="dropdown-menu absolute left-0 right-0 mt-1.5 bg-white border border-neutral-200 rounded-lg shadow-lg py-1.5 z-50 hidden max-h-60 overflow-y-auto transform scale-95 opacity-0 origin-top transition-all duration-150">
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors active bg-blue-50 text-blue-600 font-semibold" data-value="">Semua Kelas</div>
                    @foreach($rombels as $r)
                        <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors" data-value="{{ $r }}">{{ $r }}</div>
                    @endforeach
                </div>
            </div>

            <!-- Dropdown Status -->
            <div class="relative w-full md:w-44 custom-dropdown" id="dropdown-status">
                <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">Status</span>
                <button 
                    type="button" 
                    class="dropdown-trigger w-full flex items-center justify-between pl-4 pr-3 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm transition-all outline-none cursor-pointer select-none"
                >
                    <span class="dropdown-label truncate">Semua Status</span>
                    <svg class="w-4 h-4 text-neutral-500 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <input type="hidden" name="status_filter" id="status-filter" value="" />
                <div class="dropdown-menu absolute left-0 right-0 mt-1.5 bg-white border border-neutral-200 rounded-lg shadow-lg py-1.5 z-50 hidden max-h-60 overflow-y-auto transform scale-95 opacity-0 origin-top transition-all duration-150">
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors active bg-blue-50 text-blue-600 font-semibold" data-value="">Semua Status</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors" data-value="aktif">Aktif</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors" data-value="lulus">Lulus</div>
                </div>
            </div>

            <!-- Dropdown Urutkan -->
            <div class="relative w-full md:w-52 custom-dropdown" id="dropdown-sort">
                <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">Urutkan</span>
                <button 
                    type="button" 
                    class="dropdown-trigger w-full flex items-center justify-between pl-4 pr-3 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm transition-all outline-none cursor-pointer select-none"
                >
                    <span class="dropdown-label truncate">Nama (A - Z)</span>
                    <svg class="w-4 h-4 text-neutral-500 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <input type="hidden" name="sort_filter" id="sort-filter" value="name_asc" />
                <div class="dropdown-menu absolute left-0 right-0 mt-1.5 bg-white border border-neutral-200 rounded-lg shadow-lg py-1.5 z-50 hidden max-h-60 overflow-y-auto transform scale-95 opacity-0 origin-top transition-all duration-150">
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors active bg-blue-50 text-blue-600 font-semibold" data-value="name_asc">Nama (A - Z)</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors" data-value="name_desc">Nama (Z - A)</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors" data-value="nipd_asc">NIPD (Terkecil)</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors" data-value="nipd_desc">NIPD (Terbesar)</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors" data-value="newest">Terbaru Terdaftar</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors" data-value="oldest">Terlama Terdaftar</div>
                </div>
            </div>

            <div id="reset-button-wrapper" class="hidden flex-col justify-end w-full md:w-auto select-none">
                <x-ui.button 
                    type="button" 
                    id="btn-reset-filters" 
                    variant="secondary"
                    class="w-full md:w-auto"
                >
                    Reset
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="w-full">
        <!-- Desktop Table View (>= md) -->
        <div class="hidden md:block overflow-hidden border border-neutral-200 rounded-xl bg-white shadow-sm mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50 border-b border-neutral-200 select-none">
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">NIPD</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Nama Lengkap</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">L/P</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">NISN</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Kelas</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Status</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="student-table-body">
                        @forelse($students as $student)
                            <tr class="border-b border-neutral-200 hover:bg-neutral-50/50 transition-colors">
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900">{{ $student->nipd }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 font-medium">{{ $student->name }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 text-center">{{ $student->gender }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900">{{ $student->nisn ?? '-' }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 text-center">{{ $student->rombel }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-center">
                                    <x-ui.badge :type="str_starts_with($student->rombel, 'IX') ? 'warning' : 'success'">
                                        {{ str_starts_with($student->rombel, 'IX') ? 'Lulus' : 'Aktif' }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-6 py-2.5 text-sm font-sans">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-ui.button-icon icon="edit" variant="warning" href="{{ route('students.edit', $student->id) }}" />
                                        <x-ui.button-icon icon="printer" variant="primary" href="{{ route('students.single_student_print', $student->id) }}" target="_blank" />
                                        @can('admin-only')
                                            <x-ui.button-icon 
                                                icon="trash" 
                                                variant="danger" 
                                                data-modal-target="#delete-confirm-modal-{{ $student->id }}" 
                                            />

                                            <x-feedback.modal-confirm 
                                                id="delete-confirm-modal-{{ $student->id }}" 
                                                action="{{ route('students.destroy', $student->id) }}" 
                                                method="DELETE"
                                                title="Hapus Data Siswa" 
                                                confirmText="Hapus" 
                                                confirmVariant="danger"
                                            >
                                                Apakah Anda yakin ingin menghapus data siswa <strong>{{ $student->name }}</strong> (NIPD: {{ $student->nipd }}) secara permanen? Tindakan ini tidak dapat dibatalkan.
                                            </x-feedback.modal-confirm>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-sm text-neutral-500 font-sans">
                                    Tidak ada data siswa terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-data.pagination :paginator="$students" />
        </div>

        <!-- Mobile Cards View (< md) -->
        <div id="student-cards-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden mb-6">
            @forelse($students as $student)
                <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm flex flex-col justify-between gap-3">
                    <div class="flex items-start justify-between gap-2 border-b border-neutral-100 pb-2.5 select-none">
                        <div>
                            <h4 class="text-sm font-semibold text-neutral-900 font-sans">{{ $student->name }}</h4>
                            <span class="text-xs text-neutral-500 font-sans font-mono">NIPD: {{ $student->nipd }}</span>
                        </div>
                        <x-ui.badge :type="str_starts_with($student->rombel, 'IX') ? 'warning' : 'success'">
                            {{ str_starts_with($student->rombel, 'IX') ? 'Lulus' : 'Aktif' }}
                        </x-ui.badge>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-xs font-sans select-none">
                        <div>
                            <span class="text-neutral-400 block text-[10px] font-bold uppercase tracking-wider">NISN</span>
                            <span class="text-neutral-800 font-medium font-mono">{{ $student->nisn ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-neutral-400 block text-[10px] font-bold uppercase tracking-wider">L/P</span>
                            <span class="text-neutral-800 font-medium">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-neutral-400 block text-[10px] font-bold uppercase tracking-wider">Kelas</span>
                            <span class="text-neutral-800 font-medium">Kelas {{ $student->rombel }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2.5 border-t border-neutral-100">
                        <x-ui.button-icon icon="edit" variant="warning" href="{{ route('students.edit', $student->id) }}" />
                        <x-ui.button-icon icon="printer" variant="primary" href="{{ route('students.single_student_print', $student->id) }}" target="_blank" />
                        @can('admin-only')
                            <x-ui.button-icon 
                                icon="trash" 
                                variant="danger" 
                                data-modal-target="#delete-confirm-modal-mobile-{{ $student->id }}" 
                            />

                            <x-feedback.modal-confirm 
                                id="delete-confirm-modal-mobile-{{ $student->id }}" 
                                action="{{ route('students.destroy', $student->id) }}" 
                                method="DELETE"
                                title="Hapus Data Siswa" 
                                confirmText="Hapus" 
                                confirmVariant="danger"
                            >
                                Apakah Anda yakin ingin menghapus data siswa <strong>{{ $student->name }}</strong> (NIPD: {{ $student->nipd }}) secara permanen? Tindakan ini tidak dapat dibatalkan.
                            </x-feedback.modal-confirm>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white border border-neutral-200 rounded-xl p-8 text-center text-sm text-neutral-500 font-sans">
                    Tidak ada data siswa terdaftar.
                </div>
            @endforelse
        </div>

        <div class="md:hidden border border-neutral-200 rounded-xl bg-white overflow-hidden mb-6">
            <x-data.pagination :paginator="$students" />
        </div>
    </div>
@endsection
