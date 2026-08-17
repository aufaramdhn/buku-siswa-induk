document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const rombelFilter = document.getElementById('rombel-filter');
    const statusFilter = document.getElementById('status-filter');
    const sortFilter = document.getElementById('sort-filter');
    const tableBody = document.getElementById('student-table-body');
    const resetFiltersBtn = document.getElementById('btn-reset-filters');
    const paginationContainer = document.getElementById('pagination-container');

    if (!searchInput || !tableBody) return;

    let debounceTimeout = null;
    let currentPage = 1;

    const userRole = document.body.getAttribute('data-role');
    const isAdmin = userRole === 'admin';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    const updatePaginationUI = (meta) => {
        if (!paginationContainer) return;

        const infoSpan = document.getElementById('pagination-info');
        if (infoSpan) {
            if (meta.total > 0) {
                infoSpan.innerHTML = `Menampilkan <span class="font-semibold text-neutral-800">${meta.from}</span> – <span class="font-semibold text-neutral-800">${meta.to}</span> dari <span class="font-semibold text-neutral-800">${meta.total}</span> data`;
            } else {
                infoSpan.textContent = 'Tidak ada data untuk ditampilkan';
            }
        }

        const buttonsDiv = document.getElementById('pagination-buttons');
        if (buttonsDiv) {
            if (meta.last_page > 1) {
                let html = '';

                if (meta.current_page === 1) {
                    html += `<span class="px-3 py-1.5 text-sm text-neutral-300 cursor-default select-none font-sans">«</span>`;
                } else {
                    html += `<button type="button" data-page="${meta.current_page - 1}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-ajax-btn">«</button>`;
                }

                const currentPage = meta.current_page;
                const lastPage = meta.last_page;

                if (lastPage <= 5) {
                    for (let i = 1; i <= lastPage; i++) {
                        if (i === currentPage) {
                            html += `<span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">${i}</span>`;
                        } else {
                            html += `<button type="button" data-page="${i}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-ajax-btn">${i}</button>`;
                        }
                    }
                } else {
                    if (currentPage === 1) {
                        html += `<span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">1</span>`;
                    } else {
                        html += `<button type="button" data-page="1" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-ajax-btn">1</button>`;
                    }

                    if (currentPage > 3) {
                        html += `<span class="px-2 py-1.5 text-sm text-neutral-400 font-sans select-none">...</span>`;
                    }

                    let start = Math.max(2, currentPage - 1);
                    let end = Math.min(lastPage - 1, currentPage + 1);

                    if (currentPage <= 3) {
                        end = 4;
                    }
                    if (currentPage >= lastPage - 2) {
                        start = lastPage - 3;
                    }

                    for (let i = start; i <= end; i++) {
                        if (i === currentPage) {
                            html += `<span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">${i}</span>`;
                        } else {
                            html += `<button type="button" data-page="${i}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-ajax-btn">${i}</button>`;
                        }
                    }

                    if (currentPage < lastPage - 2) {
                        html += `<span class="px-2 py-1.5 text-sm text-neutral-400 font-sans select-none">...</span>`;
                    }

                    if (currentPage === lastPage) {
                        html += `<span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">${lastPage}</span>`;
                    } else {
                        html += `<button type="button" data-page="${lastPage}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-ajax-btn">${lastPage}</button>`;
                    }
                }

                if (meta.current_page === meta.last_page) {
                    html += `<span class="px-3 py-1.5 text-sm text-neutral-300 cursor-default select-none font-sans">»</span>`;
                } else {
                    html += `<button type="button" data-page="${meta.current_page + 1}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-ajax-btn">»</button>`;
                }

                buttonsDiv.innerHTML = html;
                buttonsDiv.classList.remove('hidden');
            } else {
                buttonsDiv.innerHTML = '';
                buttonsDiv.classList.add('hidden');
            }
        }
    };

    const performSearch = () => {
        const query = searchInput.value;
        const rombel = rombelFilter ? rombelFilter.value : '';
        const status = statusFilter ? statusFilter.value : '';
        const sortVal = sortFilter ? sortFilter.value : 'name_asc';

        let sortBy = 'name';
        let sortDir = 'asc';

        if (sortVal === 'name_desc') {
            sortBy = 'name';
            sortDir = 'desc';
        } else if (sortVal === 'nipd_asc') {
            sortBy = 'nipd';
            sortDir = 'asc';
        } else if (sortVal === 'nipd_desc') {
            sortBy = 'nipd';
            sortDir = 'desc';
        } else if (sortVal === 'newest') {
            sortBy = 'created_at';
            sortDir = 'desc';
        } else if (sortVal === 'oldest') {
            sortBy = 'created_at';
            sortDir = 'asc';
        }

        const resetWrapper = document.getElementById('reset-button-wrapper');
        if (resetWrapper) {
            if (query.trim().length > 0 || rombel !== '' || status !== '' || sortVal !== 'name_asc') {
                resetWrapper.style.display = 'flex';
                resetWrapper.classList.remove('hidden');
            } else {
                resetWrapper.style.display = 'none';
                resetWrapper.classList.add('hidden');
            }
        }

        const exportPdfBtn = document.getElementById('btn-export-pdf');
        if (exportPdfBtn) {
            const pdfParams = new URLSearchParams({
                search: query,
                rombel_filter: rombel,
                status_filter: status,
                sort_filter: sortVal
            });
            exportPdfBtn.href = `/students/all-students-print?${pdfParams.toString()}`;
        }

        const url = `/students?search=${encodeURIComponent(query)}&rombel=${encodeURIComponent(rombel)}&status=${encodeURIComponent(status)}&page=${currentPage}&sort_by=${sortBy}&sort_dir=${sortDir}`;

        fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            let html = '';
            let cardsHtml = '';
            const students = data.data || [];
            
            if (students.length === 0) {
                html = `
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-neutral-500 font-sans">
                            Tidak ada data siswa ditemukan
                        </td>
                    </tr>
                `;
                cardsHtml = `
                    <div class="col-span-full bg-white border border-neutral-200 rounded-xl p-8 text-center text-sm text-neutral-500 font-sans">
                        Tidak ada data siswa ditemukan
                    </div>
                `;
            } else {
                students.forEach(student => {
                    const statusClass = student.rombel.includes('IX') ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200';
                    const statusLabel = student.rombel.includes('IX') ? 'Lulus' : 'Aktif';

                    let deleteBtnHtml = '';
                    let deleteModalHtml = '';

                    if (isAdmin) {
                        deleteBtnHtml = `
                            <button type="button" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors cursor-pointer outline-none bg-white border border-neutral-200 text-red-600 hover:bg-neutral-50 active:bg-neutral-100 select-none" data-modal-target="#delete-confirm-modal-${student.id}">
                                <svg class="w-4 h-4 text-red-600 stroke-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        `;

                        deleteModalHtml = `
                            <div id="delete-confirm-modal-${student.id}" class="modal-backdrop fixed inset-0 bg-neutral-900/50 z-50 flex items-center justify-center p-4 transition-opacity duration-100 ease-out opacity-0 pointer-events-none">
                                <div class="modal-card bg-white rounded-xl w-full max-w-md p-6 shadow-xl border border-neutral-100 transform scale-95 transition-transform duration-100 ease-out">
                                    <form action="/students/${student.id}" method="POST" class="no-validate-modal">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="w-12 h-12 rounded-full bg-danger-bg border border-danger-bg/10 flex items-center justify-center mb-4 flex-shrink-0">
                                                <svg class="w-6 h-6 text-danger stroke-danger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-neutral-900 mb-2 font-sans">Hapus Data Siswa</h3>
                                            <p class="text-sm text-neutral-500 mb-6 font-sans">
                                                Apakah Anda yakin ingin menghapus data siswa <strong>${student.name}</strong> (NIPD: ${student.nipd}) secara permanen? Tindakan ini tidak dapat dibatalkan.
                                            </p>
                                            <div class="grid grid-cols-2 gap-3 w-full">
                                                <button type="button" class="font-medium px-5 py-2.5 rounded-lg text-sm inline-flex items-center justify-center gap-2 transition-colors cursor-pointer outline-none whitespace-nowrap bg-white border border-neutral-200 text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 w-full modal-close-btn" data-modal-dismiss="#delete-confirm-modal-${student.id}">Batal</button>
                                                <button type="submit" class="font-medium px-5 py-2.5 rounded-lg text-sm inline-flex items-center justify-center gap-2 transition-colors cursor-pointer outline-none whitespace-nowrap bg-danger text-white hover:bg-red-700 active:bg-red-950 shadow-sm border border-transparent w-full">Hapus</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        `;
                    }

                    html += `
                        <tr class="border-b border-neutral-200 hover:bg-neutral-50/50 transition-colors">
                            <td class="px-6 py-2.5 text-sm font-sans text-neutral-900">${student.nipd}</td>
                            <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 font-medium">${student.name}</td>
                            <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 text-center">${student.gender}</td>
                            <td class="px-6 py-2.5 text-sm font-sans text-neutral-900">${student.nisn || '-'}</td>
                            <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 text-center">${student.rombel}</td>
                            <td class="px-6 py-2.5 text-sm font-sans text-center">
                                <span class="text-xs px-2.5 py-0.5 rounded-full font-medium inline-flex items-center ${statusClass}">
                                    ${statusLabel}
                                </span>
                            </td>
                            <td class="px-6 py-2.5 text-sm font-sans">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="/students/${student.id}/edit" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors cursor-pointer outline-none bg-white border border-neutral-200 text-amber-600 hover:bg-neutral-50 active:bg-neutral-100 select-none">
                                        <svg class="w-4 h-4 text-amber-600 stroke-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4z"></path></svg>
                                    </a>
                                    <a href="/students/${student.id}/print" target="_blank" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors cursor-pointer outline-none bg-white border border-neutral-200 text-blue-600 hover:bg-neutral-50 active:bg-neutral-100 select-none">
                                        <svg class="w-4 h-4 text-blue-600 stroke-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                    </a>
                                    ${deleteBtnHtml}
                                    ${deleteModalHtml}
                                </div>
                            </td>
                        </tr>
                    `;

                    cardsHtml += `
                        <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm flex flex-col justify-between gap-3">
                            <div class="flex items-start justify-between gap-2 border-b border-neutral-100 pb-2.5 select-none">
                                <div>
                                    <h4 class="text-sm font-semibold text-neutral-900 font-sans">${student.name}</h4>
                                    <span class="text-xs text-neutral-500 font-sans font-mono">NIPD: ${student.nipd}</span>
                                </div>
                                <span class="text-xs px-2.5 py-0.5 rounded-full font-medium inline-flex items-center ${statusClass}">
                                    ${statusLabel}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs font-sans select-none">
                                <div>
                                    <span class="text-neutral-400 block text-[10px] font-bold uppercase tracking-wider">NISN</span>
                                    <span class="text-neutral-800 font-medium font-mono">${student.nisn || '-'}</span>
                                </div>
                                <div>
                                    <span class="text-neutral-400 block text-[10px] font-bold uppercase tracking-wider">L/P</span>
                                    <span class="text-neutral-800 font-medium">${student.gender === 'L' ? 'Laki-laki' : 'Perempuan'}</span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-neutral-400 block text-[10px] font-bold uppercase tracking-wider">Kelas</span>
                                    <span class="text-neutral-800 font-medium">Kelas ${student.rombel}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-2.5 border-t border-neutral-100">
                                <a href="/students/${student.id}/edit" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors cursor-pointer outline-none bg-white border border-neutral-200 text-amber-600 hover:bg-neutral-50 active:bg-neutral-100 select-none">
                                    <svg class="w-4 h-4 text-amber-600 stroke-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4z"></path></svg>
                                </a>
                                <a href="/students/${student.id}/print" target="_blank" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors cursor-pointer outline-none bg-white border border-neutral-200 text-blue-600 hover:bg-neutral-50 active:bg-neutral-100 select-none">
                                    <svg class="w-4 h-4 text-blue-600 stroke-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                </a>
                                ${deleteBtnHtml}
                            </div>
                        </div>
                    `;
                });
            }
            
            if (tableBody) tableBody.innerHTML = html;
            const cardsContainer = document.getElementById('student-cards-container');
            if (cardsContainer) cardsContainer.innerHTML = cardsHtml;
            updatePaginationUI(data);
        });
    };

    searchInput.addEventListener('input', () => {
        currentPage = 1;
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(performSearch, 300);
    });

    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            currentPage = 1;
            performSearch();
        }
    });

    if (rombelFilter) {
        rombelFilter.addEventListener('change', () => {
            currentPage = 1;
            performSearch();
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', () => {
            currentPage = 1;
            performSearch();
        });
    }

    if (sortFilter) {
        sortFilter.addEventListener('change', () => {
            currentPage = 1;
            performSearch();
        });
    }

    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            
            document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                const hiddenInput = dropdown.querySelector('input[type="hidden"]');
                const label = dropdown.querySelector('.dropdown-label');
                const items = dropdown.querySelectorAll('.dropdown-item');
                
                if (hiddenInput && hiddenInput.id === 'rombel-filter') {
                    hiddenInput.value = '';
                    if (label) label.textContent = 'Semua Kelas';
                } else if (hiddenInput && hiddenInput.id === 'status-filter') {
                    hiddenInput.value = '';
                    if (label) label.textContent = 'Semua Status';
                } else if (hiddenInput && hiddenInput.id === 'sort-filter') {
                    hiddenInput.value = 'name_asc';
                    if (label) label.textContent = 'Nama (A - Z)';
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

            currentPage = 1;
            performSearch();
        });
    }

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.pagination-ajax-btn');
        if (btn) {
            currentPage = parseInt(btn.getAttribute('data-page')) || 1;
            performSearch();
            
            const mainContainer = document.querySelector('main');
            if (mainContainer) {
                mainContainer.scrollTop = 0;
            }
        }
    });

    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
    });
});
