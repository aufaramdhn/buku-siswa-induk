document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('topbar-search-input');
    const dropdown = document.getElementById('topbar-search-dropdown');
    const loading = document.getElementById('topbar-search-loading');
    const results = document.getElementById('topbar-search-results');
    const container = document.getElementById('topbar-search-container');

    if (!searchInput || !dropdown || !results) return;

    let debounceTimeout = null;

    const openDropdown = () => {
        document.querySelectorAll('.dropdown-menu').forEach(d => {
            if (d !== dropdown) {
                d.classList.add('hidden');
                d.classList.remove('scale-100', 'opacity-100');
                d.classList.add('scale-95', 'opacity-0');
            }
        });
        dropdown.classList.remove('hidden');
        void dropdown.offsetHeight;
        dropdown.classList.remove('scale-95', 'opacity-0');
        dropdown.classList.add('scale-100', 'opacity-100');
    };

    const closeDropdown = () => {
        dropdown.classList.remove('scale-100', 'opacity-100');
        dropdown.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            if (dropdown.classList.contains('opacity-0')) {
                dropdown.classList.add('hidden');
            }
        }, 150);
    };

    const handleSearch = () => {
        const query = searchInput.value.trim();

        if (query.length < 2) {
            results.innerHTML = '';
            closeDropdown();
            return;
        }

        if (loading) loading.classList.remove('hidden');
        results.innerHTML = '';
        openDropdown();

        fetch(`/quick-search?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                if (loading) loading.classList.add('hidden');
                let html = '';

                if (data.students && data.students.length > 0) {
                    html += `<div class="px-3.5 py-1.5 text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">Siswa Ditemukan</div>`;
                    data.students.forEach(student => {
                        html += `
                            <a href="/students/${student.id}/edit" class="flex items-center gap-3 px-4 py-2 hover:bg-neutral-50 active:bg-neutral-100 transition-colors font-sans text-sm text-neutral-800">
                                <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 font-semibold text-xs flex-shrink-0">
                                    ${student.name.charAt(0).toUpperCase()}
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-medium text-neutral-900 truncate">${student.name}</span>
                                    <span class="text-[10px] text-neutral-400">NIPD. ${student.nipd} • Rombel ${student.rombel}</span>
                                </div>
                            </a>
                        `;
                    });
                }

                if (data.routes && data.routes.length > 0) {
                    if (html !== '') {
                        html += `<div class="h-px bg-neutral-100 my-1.5"></div>`;
                    }
                    html += `<div class="px-3.5 py-1.5 text-[9px] font-bold text-neutral-400 uppercase tracking-wider font-sans select-none">Pintasan Menu</div>`;
                    data.routes.forEach(route => {
                        let iconSvg = '';
                        if (route.icon === 'users') {
                            iconSvg = '<svg class="w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>';
                        } else if (route.icon === 'plus') {
                            iconSvg = '<svg class="w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
                        } else if (route.icon === 'bookopen') {
                            iconSvg = '<svg class="w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>';
                        } else if (route.icon === 'award') {
                            iconSvg = '<svg class="w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>';
                        } else if (route.icon === 'school') {
                            iconSvg = '<svg class="w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"></path></svg>';
                        } else if (route.icon === 'user') {
                            iconSvg = '<svg class="w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
                        } else if (route.icon === 'activity') {
                            iconSvg = '<svg class="w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>';
                        }

                        html += `
                            <a href="${route.url}" class="flex items-center gap-3 px-4 py-2 hover:bg-neutral-50 active:bg-neutral-100 transition-colors font-sans text-sm text-neutral-800">
                                <div class="w-8 h-8 rounded-lg bg-neutral-50 border border-neutral-100 flex items-center justify-center flex-shrink-0">
                                    ${iconSvg}
                                </div>
                                <span class="font-medium text-neutral-900 truncate">${route.label}</span>
                            </a>
                        `;
                    });
                }

                if (html === '') {
                    html = `
                        <div class="px-4 py-8 text-center text-xs text-neutral-400 font-sans">
                            Tidak ada hasil ditemukan untuk "${query}"
                        </div>
                    `;
                }

                results.innerHTML = html;
            })
            .catch(() => {
                if (loading) loading.classList.add('hidden');
                results.innerHTML = `
                    <div class="px-4 py-8 text-center text-xs text-neutral-400 font-sans">
                        Tidak ada hasil ditemukan untuk "${query}"
                    </div>
                `;
            });
    };

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(handleSearch, 200);
    });

    searchInput.addEventListener('focus', () => {
        if (searchInput.value.trim().length >= 2) {
            openDropdown();
        }
    });

    document.addEventListener('click', (e) => {
        if (container && !container.contains(e.target)) {
            closeDropdown();
        }
    });
});
