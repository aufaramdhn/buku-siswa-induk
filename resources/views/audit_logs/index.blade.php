@extends('layouts.app')

@section('title', 'Log Audit')

@section('breadcrumbs')
    <span class="text-neutral-500 font-normal">Log Audit</span>
@endsection

@section('content')
    <x-data.section-header title="Histori Log Audit" subtitle="Daftar lengkap mutasi data sensitif pada sistem" />

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
                name="search"
                id="search-input" 
                placeholder="Cari operator, IP, atau tindakan..." 
                value="{{ request('search') }}"
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all outline-none"
                autocomplete="off"
            />
        </div>

        <div class="h-8 w-px bg-neutral-200 hidden md:block select-none"></div>

        <div class="flex items-end gap-4 w-full md:w-auto flex-wrap md:flex-nowrap">
            <!-- Dropdown Jenis Tindakan -->
            <div class="relative w-full md:w-48 custom-dropdown" id="dropdown-action">
                <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">Tindakan</span>
                <button 
                    type="button" 
                    class="dropdown-trigger w-full flex items-center justify-between pl-4 pr-3 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm transition-all outline-none cursor-pointer select-none"
                >
                    <span class="dropdown-label truncate">
                        @if(request('action') === 'CREATE')
                            Tambah (CREATE)
                        @elseif(request('action') === 'UPDATE')
                            Ubah (UPDATE)
                        @elseif(request('action') === 'DELETE')
                            Hapus (DELETE)
                        @else
                            Semua Tindakan
                        @endif
                    </span>
                    <svg class="w-4 h-4 text-neutral-500 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <input type="hidden" name="action" id="action-filter" value="{{ request('action') }}" />
                <div class="dropdown-menu absolute left-0 right-0 mt-1.5 bg-white border border-neutral-200 rounded-lg shadow-lg py-1.5 z-50 hidden max-h-60 overflow-y-auto transform scale-95 opacity-0 origin-top transition-all duration-150">
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors {{ !request('action') ? 'active bg-blue-50 text-blue-600 font-semibold' : '' }}" data-value="">Semua Tindakan</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors {{ request('action') === 'CREATE' ? 'active bg-blue-50 text-blue-600 font-semibold' : '' }}" data-value="CREATE">Tambah (CREATE)</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors {{ request('action') === 'UPDATE' ? 'active bg-blue-50 text-blue-600 font-semibold' : '' }}" data-value="UPDATE">Ubah (UPDATE)</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors {{ request('action') === 'DELETE' ? 'active bg-blue-50 text-blue-600 font-semibold' : '' }}" data-value="DELETE">Hapus (DELETE)</div>
                </div>
            </div>

            <!-- Dropdown Urutkan -->
            <div class="relative w-full md:w-48 custom-dropdown" id="dropdown-sort">
                <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">Urutkan</span>
                <button 
                    type="button" 
                    class="dropdown-trigger w-full flex items-center justify-between pl-4 pr-3 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm transition-all outline-none cursor-pointer select-none"
                >
                    <span class="dropdown-label truncate">
                        {{ request('sort_dir') === 'asc' ? 'Terlama' : 'Terbaru' }}
                    </span>
                    <svg class="w-4 h-4 text-neutral-500 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <input type="hidden" name="sort_dir" id="sort-dir-filter" value="{{ request('sort_dir', 'desc') }}" />
                <div class="dropdown-menu absolute left-0 right-0 mt-1.5 bg-white border border-neutral-200 rounded-lg shadow-lg py-1.5 z-50 hidden max-h-60 overflow-y-auto transform scale-95 opacity-0 origin-top transition-all duration-150">
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors {{ request('sort_dir', 'desc') === 'desc' ? 'active bg-blue-50 text-blue-600 font-semibold' : '' }}" data-value="desc">Terbaru</div>
                    <div class="dropdown-item px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 cursor-pointer transition-colors {{ request('sort_dir') === 'asc' ? 'active bg-blue-50 text-blue-600 font-semibold' : '' }}" data-value="asc">Terlama</div>
                </div>
            </div>

            <div id="reset-button-wrapper" class="flex-col justify-end w-full md:w-auto select-none {{ (request('search') || request('action') || request('sort_dir') === 'asc') ? 'flex' : 'hidden' }}" style="display: {{ (request('search') || request('action') || request('sort_dir') === 'asc') ? 'flex' : 'none' }};">
                <x-ui.button id="reset-filter-btn" href="{{ route('audit_logs.index') }}" variant="secondary" class="w-full md:w-auto">
                    Reset
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="w-full">
        <!-- Desktop Table (>= md) -->
        <div class="hidden md:block overflow-hidden border border-neutral-200 rounded-xl bg-white shadow-sm mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50 border-b border-neutral-200 select-none">
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Waktu</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Operator</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Tindakan</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">IP Address</th>
                        </tr>
                    </thead>
                    <tbody id="audit-log-table-body">
                        @forelse($auditLogs as $log)
                            <tr class="border-b border-neutral-200 hover:bg-neutral-50/50 transition-colors">
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 select-none">{{ $log->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') }} WIB</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 select-none font-medium">{{ $log->user->username ?? 'Sistem / Terhapus' }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans select-none">
                                    <x-ui.badge :type="str_contains($log->action, 'DELETE') ? 'danger' : (str_contains($log->action, 'CREATE') ? 'success' : 'warning')">
                                        {{ $log->action }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 select-none font-mono">{{ $log->ip_address }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-neutral-500 font-sans">
                                    Belum ada log mutasi data terekam.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div id="audit-log-pagination-desktop">
                <x-data.pagination :paginator="$auditLogs" />
            </div>
        </div>

        <!-- Mobile Cards (< md) -->
        <div id="audit-log-cards-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden mb-6">
            @forelse($auditLogs as $log)
                <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm flex flex-col justify-between gap-3">
                    <div class="flex items-start justify-between gap-2 border-b border-neutral-100 pb-2.5 select-none">
                        <div>
                            <h4 class="text-sm font-semibold text-neutral-900 font-sans">{{ $log->user->username ?? 'Sistem / Terhapus' }}</h4>
                            <span class="text-[10px] text-neutral-400 font-sans">{{ $log->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') }} WIB</span>
                        </div>
                        <x-ui.badge :type="str_contains($log->action, 'DELETE') ? 'danger' : (str_contains($log->action, 'CREATE') ? 'success' : 'warning')">
                            {{ $log->action }}
                        </x-ui.badge>
                    </div>

                    <div class="flex items-center justify-between text-xs font-sans select-none">
                        <span class="text-neutral-400 text-[10px] font-bold uppercase tracking-wider">IP Address</span>
                        <span class="text-neutral-800 font-medium font-mono">{{ $log->ip_address }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white border border-neutral-200 rounded-xl p-8 text-center text-sm text-neutral-500 font-sans">
                    Belum ada log mutasi data terekam.
                </div>
            @endforelse
        </div>

        <div id="audit-log-pagination-mobile" class="md:hidden border border-neutral-200 rounded-xl bg-white overflow-hidden mb-6">
            <x-data.pagination :paginator="$auditLogs" />
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search-input');
            const actionInput = document.getElementById('action-filter');
            const sortDirInput = document.getElementById('sort-dir-filter');
            const tableBody = document.getElementById('audit-log-table-body');
            const cardsContainer = document.getElementById('audit-log-cards-container');
            const desktopPagination = document.getElementById('audit-log-pagination-desktop');
            const mobilePagination = document.getElementById('audit-log-pagination-mobile');
            const resetWrapper = document.getElementById('reset-button-wrapper');

            const updateResetVisibility = () => {
                const query = searchInput.value.trim();
                const action = actionInput ? actionInput.value : '';
                const sortDir = sortDirInput ? sortDirInput.value : 'desc';

                if (resetWrapper) {
                    if (query !== '' || action !== '' || sortDir === 'asc') {
                        resetWrapper.style.display = 'flex';
                        resetWrapper.classList.remove('hidden');
                    } else {
                        resetWrapper.style.display = 'none';
                        resetWrapper.classList.add('hidden');
                    }
                }
            };

            const performFetch = (page = 1) => {
                const query = searchInput.value.trim();
                const action = actionInput ? actionInput.value : '';
                const sortDir = sortDirInput ? sortDirInput.value : 'desc';

                updateResetVisibility();

                const params = new URLSearchParams({
                    search: query,
                    action: action,
                    sort_dir: sortDir,
                    page: page
                });

                fetch(`/audit-logs?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    renderDesktopTable(data.data || []);
                    renderMobileCards(data.data || []);
                    renderPagination(data);
                })
                .catch(err => console.error('Audit Log fetch error:', err));
            };

            const renderDesktopTable = (logs) => {
                if (logs.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-neutral-500 font-sans">
                                Belum ada log mutasi data terekam.
                            </td>
                        </tr>
                    `;
                    return;
                }

                let html = '';
                logs.forEach(log => {
                    let badgeBg = 'bg-amber-100 text-amber-800 border-amber-200';
                    if (log.badge_type === 'danger') {
                        badgeBg = 'bg-red-100 text-red-800 border-red-200';
                    } else if (log.badge_type === 'success') {
                        badgeBg = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                    }

                    html += `
                        <tr class="border-b border-neutral-200 hover:bg-neutral-50/50 transition-colors">
                            <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 select-none">${log.created_at}</td>
                            <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 select-none font-medium">${log.username}</td>
                            <td class="px-6 py-2.5 text-sm font-sans select-none">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${badgeBg}">
                                    ${log.action}
                                </span>
                            </td>
                            <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 select-none font-mono">${log.ip_address}</td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = html;
            };

            const renderMobileCards = (logs) => {
                if (logs.length === 0) {
                    cardsContainer.innerHTML = `
                        <div class="col-span-full bg-white border border-neutral-200 rounded-xl p-8 text-center text-sm text-neutral-500 font-sans">
                            Belum ada log mutasi data terekam.
                        </div>
                    `;
                    return;
                }

                let html = '';
                logs.forEach(log => {
                    let badgeBg = 'bg-amber-100 text-amber-800 border-amber-200';
                    if (log.badge_type === 'danger') {
                        badgeBg = 'bg-red-100 text-red-800 border-red-200';
                    } else if (log.badge_type === 'success') {
                        badgeBg = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                    }

                    html += `
                        <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm flex flex-col justify-between gap-3">
                            <div class="flex items-start justify-between gap-2 border-b border-neutral-100 pb-2.5 select-none">
                                <div>
                                    <h4 class="text-sm font-semibold text-neutral-900 font-sans">${log.username}</h4>
                                    <span class="text-[10px] text-neutral-400 font-sans">${log.created_at}</span>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${badgeBg}">
                                    ${log.action}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-xs font-sans select-none">
                                <span class="text-neutral-400 text-[10px] font-bold uppercase tracking-wider">IP Address</span>
                                <span class="text-neutral-800 font-medium font-mono">${log.ip_address}</span>
                            </div>
                        </div>
                    `;
                });
                cardsContainer.innerHTML = html;
            };

            const renderPagination = (data) => {
                if (!desktopPagination && !mobilePagination) return;

                if (data.total === 0 || !data.first_item) {
                    const emptyHtml = `
                        <div class="flex items-center justify-center px-6 py-4 border-t border-neutral-200 bg-white select-none text-sm text-neutral-500 font-sans">
                            Tidak ada data untuk ditampilkan
                        </div>
                    `;
                    if (desktopPagination) desktopPagination.innerHTML = emptyHtml;
                    if (mobilePagination) mobilePagination.innerHTML = emptyHtml;
                    return;
                }

                let buttonsHtml = '';
                if (data.last_page > 1) {
                    buttonsHtml += `<div class="inline-flex items-center justify-center flex-wrap gap-1">`;
                    
                    if (data.current_page > 1) {
                        buttonsHtml += `<button type="button" data-page="${data.current_page - 1}" class="audit-page-btn font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 px-3 py-1.5 font-sans">«</button>`;
                    } else {
                        buttonsHtml += `<span class="px-3 py-1.5 text-sm text-neutral-300 select-none font-sans">«</span>`;
                    }

                    for (let i = 1; i <= data.last_page; i++) {
                        if (i === data.current_page) {
                            buttonsHtml += `<span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">${i}</span>`;
                        } else {
                            buttonsHtml += `<button type="button" data-page="${i}" class="audit-page-btn font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 px-3 py-1.5 font-sans">${i}</button>`;
                        }
                    }

                    if (data.current_page < data.last_page) {
                        buttonsHtml += `<button type="button" data-page="${data.current_page + 1}" class="audit-page-btn font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 px-3 py-1.5 font-sans">»</button>`;
                    } else {
                        buttonsHtml += `<span class="px-3 py-1.5 text-sm text-neutral-300 select-none font-sans">»</span>`;
                    }

                    buttonsHtml += `</div>`;
                }

                const paginationMarkup = `
                    <div class="flex flex-col sm:flex-row items-center justify-between px-4 sm:px-6 py-4 gap-3 border-t border-neutral-200 bg-white select-none">
                        <div class="text-sm text-neutral-500 font-sans text-center sm:text-left">
                            Menampilkan <span class="font-semibold text-neutral-800">${data.first_item}</span> – <span class="font-semibold text-neutral-800">${data.last_item}</span> dari <span class="font-semibold text-neutral-800">${data.total}</span> data
                        </div>
                        ${buttonsHtml}
                    </div>
                `;

                if (desktopPagination) desktopPagination.innerHTML = paginationMarkup;
                if (mobilePagination) mobilePagination.innerHTML = paginationMarkup;

                document.querySelectorAll('.audit-page-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const targetPage = btn.getAttribute('data-page');
                        performFetch(targetPage);
                    });
                });
            };

            // Event Listeners for Live Search & Filter
            searchInput.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    performFetch(1);
                }, 300);
            });

            if (actionInput) {
                actionInput.addEventListener('change', () => performFetch(1));
            }
            if (sortDirInput) {
                sortDirInput.addEventListener('change', () => performFetch(1));
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    searchInput.value = '';
                    if (actionInput) actionInput.value = '';
                    if (sortDirInput) sortDirInput.value = 'desc';

                    document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
                        const label = dropdown.querySelector('.dropdown-label');
                        const items = dropdown.querySelectorAll('.dropdown-item');

                        if (hiddenInput && hiddenInput.id === 'action-filter') {
                            if (label) label.textContent = 'Semua Tindakan';
                        } else if (hiddenInput && hiddenInput.id === 'sort-dir-filter') {
                            if (label) label.textContent = 'Terbaru';
                        }

                        if (items && hiddenInput) {
                            items.forEach(i => {
                                i.classList.remove('active', 'bg-blue-50', 'text-blue-600', 'font-semibold');
                                if (i.getAttribute('data-value') === hiddenInput.value) {
                                    i.classList.add('active', 'bg-blue-50', 'text-blue-600', 'font-semibold');
                                }
                            });
                        }
                    });

                    performFetch(1);
                });
            }
        });
    </script>
@endsection
