<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Buku Induk Siswa - {{ $schoolProfile->name ?? 'SMP Negeri 1 Cisewu' }}</title>
    <link rel="icon" type="image/png" href="/images/logo_smp_cisewu.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        @media print {
            html, body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }
            .top-action-bar {
                display: none !important;
            }
            .paper-viewport {
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
                width: 100% !important;
            }
            .paper-sheet {
                width: 100% !important;
                min-height: auto !important;
                padding: 12mm 15mm 12mm 15mm !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
                box-sizing: border-box !important;
            }
            .data-table tr {
                page-break-inside: avoid !important;
            }
            .data-table td, .data-table th {
                padding: 5px 6px !important;
            }
        }
    </style>
</head>
<body class="bg-neutral-100 text-neutral-900 font-serif text-[11px] leading-relaxed antialiased">
    <div class="top-action-bar sticky top-0 z-50 bg-white border-b border-neutral-200 px-6 py-3 flex items-center justify-between shadow-sm print:hidden font-sans">
        <div class="flex items-center gap-4">
            <button onclick="window.history.length > 1 ? window.history.back() : window.close()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-lg text-xs font-medium transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                <span>Kembali</span>
            </button>
            <div class="h-5 w-px bg-neutral-200"></div>
            <div>
                <h1 class="text-sm font-semibold text-neutral-900">Laporan Rekapitulasi Buku Induk Siswa</h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-2.5 py-1 bg-neutral-100 border border-neutral-200 rounded-md text-[11px] font-medium text-neutral-600">A4 Landscape</span>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition-colors shadow-sm cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Cetak Dokumen</span>
            </button>
        </div>
    </div>

    <div class="paper-viewport py-8 px-4 flex justify-center items-start min-h-screen print:min-h-0">
        <div class="paper-sheet w-[297mm] min-h-[210mm] bg-white p-6 shadow-xl border border-neutral-200 rounded">
            <table class="master-table w-full border-collapse">
                <thead>
                    <tr>
                        <td class="border-none p-0 pb-3">
                            <div class="text-center pb-2 border-b-2 border-black mb-3">
                                <h1 class="text-base font-bold uppercase tracking-wide text-black m-0">LAPORAN REKAPITULASI BUKU INDUK SISWA</h1>
                                <h2 class="text-sm font-bold uppercase text-black mt-1 m-0">{{ $schoolProfile->name ?? 'SMP Negeri 1 Cisewu' }}</h2>
                                <p class="text-[10px] text-black mt-1 m-0">NPSN: {{ $schoolProfile->npsn ?? '-' }} | NSS: {{ $schoolProfile->nss ?? '-' }} | Tahun Pelajaran: {{ $schoolProfile->academic_year ?? '2025/2026' }}</p>
                            </div>
                            <div class="flex justify-between items-center text-[11px] pb-1.5 border-b border-neutral-300 font-sans mb-3">
                                <div>
                                    <strong>Filter Rombel:</strong> {{ request('rombel_filter') ?: (request('rombel') ?: 'Semua Kelas') }} | 
                                    <strong>Status:</strong> {{ request('status_filter') ? ucfirst(request('status_filter')) : 'Semua Status' }}
                                </div>
                                <div>
                                    <strong>Total:</strong> {{ count($students) }} Siswa (L: {{ $totalMale }}, P: {{ $totalFemale }})
                                </div>
                            </div>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-none p-0">
                            <table class="data-table w-full border-collapse text-[10.5px]">
                                <thead>
                                    <tr class="bg-neutral-100">
                                        <th class="border border-black px-2 py-1.5 text-center font-bold uppercase text-[9.5px] w-8">NO</th>
                                        <th class="border border-black px-2 py-1.5 text-center font-bold uppercase text-[9.5px] w-24">NIPD / NISN</th>
                                        <th class="border border-black px-2 py-1.5 text-left font-bold uppercase text-[9.5px]">NAMA LENGKAP</th>
                                        <th class="border border-black px-2 py-1.5 text-center font-bold uppercase text-[9.5px] w-10">L/P</th>
                                        <th class="border border-black px-2 py-1.5 text-left font-bold uppercase text-[9.5px]">TEMPAT, TGL LAHIR</th>
                                        <th class="border border-black px-2 py-1.5 text-center font-bold uppercase text-[9.5px] w-16">KELAS</th>
                                        <th class="border border-black px-2 py-1.5 text-left font-bold uppercase text-[9.5px]">NAMA ORANG TUA / WALI</th>
                                        <th class="border border-black px-2 py-1.5 text-left font-bold uppercase text-[9.5px]">ALAMAT & HP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $index => $student)
                                        <tr class="align-top">
                                            <td class="border border-black px-2 py-1.5 text-center">{{ $index + 1 }}</td>
                                            <td class="border border-black px-2 py-1.5 text-center">{{ $student->nipd }}<br><span class="text-neutral-600 text-[9.5px]">{{ $student->nisn ?? '-' }}</span></td>
                                            <td class="border border-black px-2 py-1.5 font-bold">{{ $student->name }}</td>
                                            <td class="border border-black px-2 py-1.5 text-center">{{ $student->gender }}</td>
                                            <td class="border border-black px-2 py-1.5">{{ $student->birth_place ?? '-' }}, {{ $student->birth_date ? $student->birth_date->format('d/m/Y') : '-' }}</td>
                                            <td class="border border-black px-2 py-1.5 text-center">{{ $student->rombel }}</td>
                                            <td class="border border-black px-2 py-1.5">
                                                Ayah: {{ $student->parent->father_name ?? '-' }}<br>
                                                Ibu: {{ $student->parent->mother_name ?? '-' }}
                                            </td>
                                            <td class="border border-black px-2 py-1.5">
                                                {{ $student->address->address ?? '-' }}<br>
                                                <span class="text-[9.5px] text-neutral-700">HP: {{ $student->mobile_phone ?? '-' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="border border-black px-4 py-4 text-center">Tidak ada data siswa ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-8 pt-4 w-full text-[11px] print:break-inside-avoid">
                                <div class="float-right w-60 text-center">
                                    <p class="m-0">Garut, {{ date('d-m-Y') }}</p>
                                    <p class="m-0">Kepala Sekolah,</p>
                                    <div class="h-14"></div>
                                    <p class="m-0"><strong><u>{{ $schoolProfile->headmaster_name ?? 'Est nemo labore temp' }}</u></strong></p>
                                    <p class="m-0">NIP. {{ $schoolProfile->headmaster_nip ?? 'Sed illo in amet ve' }}</p>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 300);
        });
    </script>
</body>
</html>
