<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>@yield('title') - Buku Induk Siswa</title>
    <link rel="icon" type="image/png" href="/images/logo_smp_cisewu.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas text-neutral-900 flex h-screen overflow-hidden">

    @if(session('success'))
        @php
            $successMsg = session('success');
            $successTitle = session('success_title');
            if (!$successTitle) {
                $lowerMsg = strtolower($successMsg);
                if (str_contains($lowerMsg, 'dihapus') || str_contains($lowerMsg, 'hapus')) {
                    $successTitle = 'Berhasil Menghapus Data';
                } elseif (str_contains($lowerMsg, 'diperbarui') || str_contains($lowerMsg, 'diubah') || str_contains($lowerMsg, 'edit')) {
                    $successTitle = 'Berhasil Memperbarui Data';
                } elseif (str_contains($lowerMsg, 'ditambahkan') || str_contains($lowerMsg, 'disimpan') || str_contains($lowerMsg, 'tambah')) {
                    $successTitle = 'Berhasil Menyimpan Data';
                } else {
                    $successTitle = 'Berhasil';
                }
            }
        @endphp
        <x-feedback.modal-alert 
            id="session-success-modal" 
            type="success" 
            :title="$successTitle" 
            :message="$successMsg" 
        />
    @endif

    @if(session('error'))
        <x-feedback.modal-alert 
            id="session-error-modal" 
            type="danger" 
            :title="session('error_title', 'Gagal Memproses Data')" 
            :message="session('error')" 
        />
    @endif

    <div id="sidebar-backdrop" class="fixed inset-0 bg-neutral-900/50 z-40 transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden"></div>

    <aside id="app-sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-sidebar-bg flex flex-col justify-between h-full flex-shrink-0 z-50 no-print transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-out shadow-2xl lg:shadow-none">
        <div class="p-5 flex flex-col">
            <div class="flex items-center gap-3 px-3 py-2 select-none">
                <img src="/images/logo_smp_cisewu.png" alt="Logo SMPN 1 Cisewu" class="w-8 h-8 rounded-lg object-contain" />
                <div class="flex flex-col sidebar-text">
                    <span class="text-sm font-semibold text-white tracking-tight font-sans">Buku Induk</span>
                    <span class="text-[10px] text-zinc-500 font-sans">SMPN 1 Cisewu</span>
                </div>
            </div>

            <nav class="mt-6 flex flex-col gap-1">
                <x-navigation.sidebar-item 
                    route="{{ route('dashboard') }}" 
                    :active="request()->routeIs('dashboard')" 
                    icon="dashboard"
                >
                    Dasbor
                </x-navigation.sidebar-item>

                <x-navigation.sidebar-item 
                    route="{{ route('students.index') }}" 
                    :active="request()->routeIs('students.*')" 
                    icon="users"
                >
                    Data Siswa
                </x-navigation.sidebar-item>

                @can('admin-only')
                    <x-navigation.sidebar-item 
                        route="{{ route('subjects.index') }}" 
                        :active="request()->routeIs('subjects.*')" 
                        icon="bookopen"
                    >
                        Mata Pelajaran
                    </x-navigation.sidebar-item>

                    <x-navigation.sidebar-item 
                        route="{{ route('extracurriculars.index') }}" 
                        :active="request()->routeIs('extracurriculars.*')" 
                        icon="award"
                    >
                        Ekstrakurikuler
                    </x-navigation.sidebar-item>

                    <x-navigation.sidebar-item 
                        route="{{ route('settings.edit') }}" 
                        :active="request()->routeIs('settings.*')" 
                        icon="school"
                    >
                        Profil Sekolah
                    </x-navigation.sidebar-item>

                    <x-navigation.sidebar-item 
                        route="{{ route('users.index') }}" 
                        :active="request()->routeIs('users.*')" 
                        icon="user"
                    >
                        Operator Sekolah
                    </x-navigation.sidebar-item>

                    <x-navigation.sidebar-item 
                        route="{{ route('audit_logs.index') }}" 
                        :active="request()->routeIs('audit_logs.*')" 
                        icon="activity"
                    >
                        Log Audit
                    </x-navigation.sidebar-item>
                @endcan
            </nav>
        </div>

        <div class="p-5">
            <button 
                type="button" 
                data-modal-target="#logout-confirm-modal"
                class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-zinc-400 rounded-lg hover:bg-white/5 hover:text-white transition-all cursor-pointer outline-none"
            >
                <x-ui.icon name="logout" class="stroke-zinc-400 w-5 h-5" />
                <span class="sidebar-text">Keluar</span>
            </button>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden h-full">
        <header class="h-16 border-b border-neutral-200 bg-white flex items-center justify-between px-4 sm:px-8 flex-shrink-0 z-30 no-print">
            <!-- Left Section: Sidebar Toggle & Breadcrumbs -->
            <div class="flex items-center gap-4 flex-shrink-0">
                <button id="btn-toggle-sidebar" class="p-1.5 rounded-lg hover:bg-neutral-100 text-neutral-500 active:bg-neutral-200 transition-colors cursor-pointer outline-none select-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="h-5 w-px bg-neutral-200 select-none"></div>
                <div class="flex items-center gap-1.5 text-xs font-medium text-neutral-400 font-sans select-none">
                    @yield('breadcrumbs')
                </div>
            </div>

            <!-- Middle Section: Longer Global Search Bar -->
            <div class="flex-1 max-w-lg px-8 hidden md:block relative" id="topbar-search-container">
                <div class="relative w-full select-none">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <form action="{{ route('students.index') }}" method="GET" class="w-full">
                        <input 
                            type="text" 
                            name="search"
                            id="topbar-search-input"
                            autocomplete="off"
                            placeholder="Cari data siswa..." 
                            class="w-full pl-9 pr-4 py-2 bg-neutral-50 border border-neutral-200 text-neutral-900 rounded-lg text-xs focus:border-blue-600 focus:bg-white transition-all outline-none"
                        />
                    </form>
                </div>

                <!-- Quick Search Dropdown Panel -->
                <div id="topbar-search-dropdown" class="dropdown-menu absolute left-8 right-8 mt-2 bg-white border border-neutral-200 rounded-xl shadow-lg z-50 hidden max-h-80 overflow-y-auto transform scale-95 opacity-0 origin-top transition-all duration-150 py-2 select-none">
                    <div id="topbar-search-loading" class="px-4 py-6 text-center text-xs text-neutral-400 font-sans hidden">
                        Mencari data...
                    </div>
                    <div id="topbar-search-results" class="flex flex-col">
                        <!-- Render dynamic contents here -->
                    </div>
                </div>
            </div>

            <!-- Right Section: User Profile -->
            <div class="flex items-center gap-4 flex-shrink-0">
                <div class="flex flex-col text-right select-none">
                    <span class="text-sm font-semibold text-neutral-900 font-sans">{{ auth()->user()->username }}</span>
                    <span class="text-[10px] text-neutral-400 uppercase tracking-wider font-sans font-medium">{{ auth()->user()->role }}</span>
                </div>
                <x-ui.avatar :name="auth()->user()->username" />
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-8 h-full">
            @yield('content')
        </main>
    </div>

    <x-feedback.modal-confirm 
        id="logout-confirm-modal" 
        action="{{ route('logout') }}" 
        title="Konfirmasi Keluar" 
        confirmText="Keluar" 
        confirmVariant="danger"
        icon="logout"
    >
        Apakah Anda yakin ingin keluar dari aplikasi?
    </x-feedback.modal-confirm>

    <x-feedback.modal-validation />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('app-sidebar');
            const toggleBtn = document.getElementById('btn-toggle-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            const openMobileSidebar = () => {
                if (sidebar) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                }
                if (backdrop) {
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    backdrop.classList.add('opacity-100', 'pointer-events-auto');
                }
            };

            const closeMobileSidebar = () => {
                if (sidebar && window.innerWidth < 1024) {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                }
                if (backdrop) {
                    backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                }
            };

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        const isOpen = sidebar && sidebar.classList.contains('translate-x-0');
                        if (isOpen) {
                            closeMobileSidebar();
                        } else {
                            openMobileSidebar();
                        }
                    } else {
                        if (sidebar) {
                            sidebar.classList.toggle('sidebar-collapsed');
                        }
                    }
                });
            }

            if (backdrop) {
                backdrop.addEventListener('click', closeMobileSidebar);
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
