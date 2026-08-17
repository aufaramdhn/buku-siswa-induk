<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Induk - {{ $student->name }}</title>
    <link rel="icon" type="image/png" href="/images/logo_smp_cisewu.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @page {
            size: A4 portrait;
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
                padding: 15mm 15mm 15mm 15mm !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
                box-sizing: border-box !important;
            }
            .section-table tr {
                page-break-inside: avoid !important;
            }
            .section-keep-together {
                page-break-inside: avoid !important;
            }
        }
    </style>
</head>
<body class="bg-neutral-100 text-neutral-900 font-serif text-xs leading-relaxed antialiased">
    <div class="top-action-bar sticky top-0 z-50 bg-white border-b border-neutral-200 px-6 py-3 flex items-center justify-between shadow-sm print:hidden font-sans">
        <div class="flex items-center gap-4">
            <button onclick="window.history.length > 1 ? window.history.back() : window.close()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-neutral-300 text-neutral-700 hover:bg-neutral-50 rounded-lg text-xs font-medium transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                <span>Kembali</span>
            </button>
            <div class="h-5 w-px bg-neutral-200"></div>
            <div>
                <span class="text-sm font-semibold text-neutral-900">Pratinjau Cetak Buku Induk</span>
                <span class="text-xs text-neutral-500 ml-1">({{ $student->name }})</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-2.5 py-1 bg-neutral-100 border border-neutral-200 rounded-md text-[11px] font-medium text-neutral-600">A4 Portrait</span>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition-colors shadow-sm cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Cetak Dokumen</span>
            </button>
        </div>
    </div>

    <div class="paper-viewport py-10 px-4 flex justify-center items-start min-h-screen print:min-h-0">
        <div class="paper-sheet w-[210mm] min-h-[297mm] bg-white p-10 shadow-xl border border-neutral-200 rounded">
            <table class="master-table w-full border-collapse">
                <thead>
                    <tr>
                        <td class="border-none p-0 pb-4">
                            <div class="text-center pb-2 border-b-2 border-black mb-4">
                                <h1 class="text-base font-bold uppercase tracking-wide text-black m-0">Buku Induk Siswa</h1>
                                <h2 class="text-sm font-bold uppercase text-black mt-1 m-0">{{ $schoolProfile->name ?? 'SMP Negeri 1 Cisewu' }}</h2>
                                <p class="text-[10px] text-black mt-1 m-0">NPSN: {{ $schoolProfile->npsn ?? '-' }} | NSS: {{ $schoolProfile->nss ?? '-' }} | Tahun Pelajaran: {{ $schoolProfile->academic_year ?? '2025/2026' }}</p>
                            </div>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-none p-0">
                            <div class="font-bold text-xs uppercase mt-3 mb-1.5 border-b border-black pb-1">I. Keterangan Pribadi Siswa</div>
                            <table class="section-table w-full border-collapse mb-4 text-xs">
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5 w-1/3">Nama Lengkap</td>
                                    <td class="border border-black px-2.5 py-1.5 font-bold">{{ $student->name }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">NIPD / NISN</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->nipd }} / {{ $student->nisn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Jenis Kelamin</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Tempat, Tanggal Lahir</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->birth_place ?? '-' }}, {{ $student->birth_date ? $student->birth_date->format('d-m-Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Agama</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->religion ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Nomor Kartu Keluarga</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->family_card_no ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Email / No. HP</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->email ?? '-' }} / {{ $student->mobile_phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Sekolah Asal (SD/MI)</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->previous_school ?? '-' }}</td>
                                </tr>
                            </table>

                            <div class="font-bold text-xs uppercase mt-4 mb-1.5 border-b border-black pb-1">II. Keterangan Tempat Tinggal</div>
                            <table class="section-table w-full border-collapse mb-4 text-xs">
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5 w-1/3">Alamat Lengkap</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->address->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">RT / RW</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->address->rt ?? '-' }} / {{ $student->address->rw ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Dusun / Kelurahan / Desa</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->address->dusun ?? '-' }} / {{ $student->address->village ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Kecamatan / Kode Pos</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->address->district ?? '-' }} / {{ $student->address->postal_code ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Jenis Tempat Tinggal / Transportasi</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->address->residence_type ?? '-' }} / {{ $student->address->transportation ?? '-' }}</td>
                                </tr>
                            </table>

                            <div class="font-bold text-xs uppercase mt-4 mb-1.5 border-b border-black pb-1">III. Keterangan Orang Tua & Wali</div>
                            <table class="section-table w-full border-collapse mb-4 text-xs">
                                <thead>
                                    <tr class="bg-neutral-100 font-bold uppercase text-[10px]">
                                        <th class="border border-black px-2.5 py-1.5 text-left w-1/3">Data / Hubungan</th>
                                        <th class="border border-black px-2.5 py-1.5 text-left">Ayah Kandung</th>
                                        <th class="border border-black px-2.5 py-1.5 text-left">Ibu Kandung</th>
                                        <th class="border border-black px-2.5 py-1.5 text-left">Wali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-black px-2.5 py-1.5">Nama Lengkap</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->father_name ?? '-' }}</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->mother_name ?? '-' }}</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->guardian_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-black px-2.5 py-1.5">NIK (Data Enkripsi)</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->father_nik ?? '-' }}</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->mother_nik ?? '-' }}</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->guardian_nik ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-black px-2.5 py-1.5">Tahun Lahir / Pendidikan</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->father_birth_year ?? '-' }} / {{ $student->parent->father_education ?? '-' }}</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->mother_birth_year ?? '-' }} / {{ $student->parent->mother_education ?? '-' }}</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->guardian_birth_year ?? '-' }} / {{ $student->parent->guardian_education ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-black px-2.5 py-1.5">Pekerjaan / Penghasilan</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->father_occupation ?? '-' }} / {{ $student->parent->father_income ?? '-' }}</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->mother_occupation ?? '-' }} / {{ $student->parent->mother_income ?? '-' }}</td>
                                        <td class="border border-black px-2.5 py-1.5">{{ $student->parent->guardian_occupation ?? '-' }} / {{ $student->parent->guardian_income ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="font-bold text-xs uppercase mt-4 mb-1.5 border-b border-black pb-1">IV. Perkembangan Jasmani & Akademik</div>
                            <table class="section-table w-full border-collapse mb-4 text-xs">
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5 w-1/3">Kelas</td>
                                    <td class="border border-black px-2.5 py-1.5">Kelas {{ $student->rombel }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Nomor Akta Lahir / Ujian Nasional</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->academic->akta_number ?? '-' }} / {{ $student->academic->un_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Tinggi / Berat / Lingkar Kepala</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->academic->height ?? '-' }} Cm / {{ $student->academic->weight ?? '-' }} Kg / {{ $student->academic->head_circum ?? '-' }} Cm</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Mata Pelajaran yang Diikuti</td>
                                    <td class="border border-black px-2.5 py-1.5">
                                        @forelse($student->subjects as $subject)
                                            {{ $subject->name }} ({{ $subject->code }}){{ !$loop->last ? ', ' : '' }}
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Kegiatan Ekstrakurikuler</td>
                                    <td class="border border-black px-2.5 py-1.5">
                                        @forelse($student->extracurriculars as $ekskul)
                                            {{ $ekskul->name }}{{ !$loop->last ? ', ' : '' }}
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                </tr>
                            </table>

                            <div class="section-keep-together">
                            <div class="font-bold text-xs uppercase mt-4 mb-1.5 border-b border-black pb-1">V. Bantuan & Keterangan Khusus</div>
                            <table class="section-table w-full border-collapse mb-4 text-xs">
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5 w-1/3">Penerima KPS / KIP</td>
                                    <td class="border border-black px-2.5 py-1.5">KPS: {{ ($student->financial->is_kps ?? false) ? 'Ya (' . $student->financial->kps_number . ')' : 'Tidak' }} | KIP: {{ ($student->financial->is_kip ?? false) ? 'Ya (' . $student->financial->kip_number . ')' : 'Tidak' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">PIP Eligible / Alasan Usulan</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ ($student->financial->is_pip_eligible ?? false) ? 'Ya' : 'Tidak' }} | Alasan: {{ $student->financial->pip_reason ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Data Perbankan PIP</td>
                                    <td class="border border-black px-2.5 py-1.5">Bank: {{ $student->financial->bank_name ?? '-' }} | No Rekening: {{ $student->financial->bank_account ?? '-' }} | Atas Nama: {{ $student->financial->bank_holder ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-black px-2.5 py-1.5">Kebutuhan Khusus / Anak Ke / Saudara</td>
                                    <td class="border border-black px-2.5 py-1.5">{{ $student->financial->special_needs ?? 'Tidak Ada' }} | Anak ke-{{ $student->parent->birth_order ?? '-' }} dari {{ $student->parent->siblings ?? 0 }} bersaudara</td>
                                </tr>
                            </table>

                            <div class="mt-10 pt-4 w-full text-xs">
                                <div class="float-right w-60 text-center">
                                    <p class="m-0">Garut, {{ date('d-m-Y') }}</p>
                                    <p class="m-0">Kepala Sekolah,</p>
                                    <div class="h-16"></div>
                                    <p class="m-0"><strong><u>{{ $schoolProfile->headmaster_name ?? 'Est nemo labore temp' }}</u></strong></p>
                                    <p class="m-0">NIP. {{ $schoolProfile->headmaster_nip ?? 'Sed illo in amet ve' }}</p>
                                </div>
                                <div class="clear-both"></div>
                            </div>
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
