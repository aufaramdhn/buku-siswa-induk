@extends('layouts.app')

@section('title', 'Ubah Data Siswa')

@section('breadcrumbs')
    <a href="{{ route('students.index') }}" class="hover:text-blue-600 transition-colors">Data Siswa</a>
    <span class="text-neutral-300 font-sans text-[10px]">></span>
    <span class="text-neutral-500 font-normal">Ubah Data</span>
@endsection

@section('content')
    <x-data.section-header title="Ubah Data Siswa" subtitle="Edit data induk siswa dan data relasional terkait" :back-url="route('students.index')">
        @slot('actions')
            <x-ui.button href="{{ route('students.single_student_print', $student->id) }}" target="_blank" variant="secondary">
                <x-ui.icon name="printer" class="w-4 h-4 text-neutral-700 stroke-neutral-700" />
                <span>Cetak Laporan</span>
            </x-ui.button>
        @endslot
    </x-data.section-header>

    <form action="{{ route('students.update', $student->id) }}" method="POST" id="edit-student-form" autocomplete="one-time-code">
        @csrf
        @method('PUT')

        <div class="flex border-b border-neutral-200 mb-8 gap-2 no-print select-none overflow-x-auto whitespace-nowrap pb-1">
            <x-navigation.tab-item target="tab-pribadi" label="1. Info Pribadi & Kontak" active />
            <x-navigation.tab-item target="tab-alamat" label="2. Alamat Lengkap" />
            <x-navigation.tab-item target="tab-ortu" label="3. Orang Tua & Wali" />
            <x-navigation.tab-item target="tab-akademik" label="4. Akademik & Bantuan" />
        </div>

        <x-ui.card class="mb-6">
            <div id="tab-pribadi" class="tab-pane flex flex-col gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form.form-group label="Nama Lengkap Siswa" name="name" helper="Masukkan nama lengkap sesuai ijazah/akta" :required="true">
                        <x-form.input name="name" placeholder="Contoh: Ahmad Wijaya" value="{{ old('name', $student->name) }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="NIPD (Nomor Induk Peserta Didik)" name="nipd" helper="Nomor Induk sekolah unik 6 digit" :required="true">
                        <x-form.input name="nipd" placeholder="Contoh: 250001" value="{{ old('nipd', $student->nipd) }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="NISN (Nomor Induk Siswa Nasional)" name="nisn" helper="Nomor Induk siswa skala nasional 10 digit" :required="true">
                        <x-form.input name="nisn" placeholder="Contoh: 3100000001" value="{{ old('nisn', $student->nisn) }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Jenis Kelamin" name="gender" :required="true">
                        <x-form.select name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender', $student->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $student->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Tempat Lahir" name="birth_place" :required="true">
                        <x-form.input name="birth_place" placeholder="Contoh: Garut" value="{{ old('birth_place', $student->birth_place) }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Tanggal Lahir" name="birth_date" :required="true">
                        <x-form.datepicker name="birth_date" value="{{ old('birth_date', $student->birth_date) }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Agama" name="religion" :required="true">
                        <x-form.select name="religion" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('religion', $student->religion) === 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('religion', $student->religion) === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('religion', $student->religion) === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('religion', $student->religion) === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('religion', $student->religion) === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('religion', $student->religion) === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Kartu Keluarga" name="family_card_no" helper="Nomor KK 16 digit (data terenkripsi)" :required="true">
                        <x-form.input name="family_card_no" placeholder="Masukkan 16 digit Nomor KK" value="{{ old('family_card_no', $student->family_card_no) }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Alamat Email Siswa" name="email">
                        <x-form.input name="email" type="email" placeholder="Contoh: siswa@bukuinduk.sch.id" value="{{ old('email', $student->email) }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nomor HP / WhatsApp" name="mobile_phone" helper="Gunakan format nomor lokal aktif" :required="true">
                        <x-form.input name="mobile_phone" placeholder="Contoh: 081234567890" value="{{ old('mobile_phone', $student->mobile_phone) }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Telepon Rumah" name="phone">
                        <x-form.input name="phone" placeholder="Contoh: 022123456" value="{{ old('phone', $student->phone) }}" />
                    </x-form.form-group>
                </div>
            </div>

            <div id="tab-alamat" class="tab-pane flex flex-col gap-6 hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-form.form-group label="Alamat Jalan Lengkap" name="address" :required="true">
                            <x-form.textarea name="address" placeholder="Contoh: Jl. Cisewu No. 15 RT 01 RW 02" value="{{ old('address', $student->address->address ?? '') }}" required />
                        </x-form.form-group>
                    </div>

                    <x-form.form-group label="RT" name="rt" :required="true">
                        <x-form.input name="rt" placeholder="Contoh: 001" value="{{ old('rt', $student->address->rt ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="RW" name="rw" :required="true">
                        <x-form.input name="rw" placeholder="Contoh: 002" value="{{ old('rw', $student->address->rw ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Nama Dusun" name="dusun">
                        <x-form.input name="dusun" placeholder="Contoh: Dusun Sukasari" value="{{ old('dusun', $student->address->dusun ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Desa / Kelurahan" name="village" :required="true">
                        <x-form.input name="village" placeholder="Contoh: Desa Cisewu" value="{{ old('village', $student->address->village ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Kecamatan" name="district" :required="true">
                        <x-form.input name="district" placeholder="Contoh: Cisewu" value="{{ old('district', $student->address->district ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Kode Pos" name="postal_code" :required="true">
                        <x-form.input name="postal_code" placeholder="Contoh: 44190" value="{{ old('postal_code', $student->address->postal_code ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Jenis Tempat Tinggal" name="residence_type" :required="true">
                        <x-form.select name="residence_type" required>
                            <option value="">Pilih Jenis Tinggal</option>
                            <option value="Bersama orang tua" {{ old('residence_type', $student->address->residence_type ?? '') === 'Bersama orang tua' ? 'selected' : '' }}>Bersama orang tua</option>
                            <option value="Kos" {{ old('residence_type', $student->address->residence_type ?? '') === 'Kos' ? 'selected' : '' }}>Kos</option>
                            <option value="Wali" {{ old('residence_type', $student->address->residence_type ?? '') === 'Wali' ? 'selected' : '' }}>Wali</option>
                            <option value="Asrama" {{ old('residence_type', $student->address->residence_type ?? '') === 'Asrama' ? 'selected' : '' }}>Asrama</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Alat Transportasi ke Sekolah" name="transportation" :required="true">
                        <x-form.select name="transportation" required>
                            <option value="">Pilih Alat Transportasi</option>
                            <option value="Jalan kaki" {{ old('transportation', $student->address->transportation ?? '') === 'Jalan kaki' ? 'selected' : '' }}>Jalan kaki</option>
                            <option value="Sepeda motor" {{ old('transportation', $student->address->transportation ?? '') === 'Sepeda motor' ? 'selected' : '' }}>Sepeda motor</option>
                            <option value="Sepeda" {{ old('transportation', $student->address->transportation ?? '') === 'Sepeda' ? 'selected' : '' }}>Sepeda</option>
                            <option value="Angkutan umum" {{ old('transportation', $student->address->transportation ?? '') === 'Angkutan umum' ? 'selected' : '' }}>Angkutan umum</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Koordinat Lintang (Latitude)" name="latitude">
                        <x-form.input name="latitude" type="number" step="any" placeholder="Contoh: -7.234567" value="{{ old('latitude', $student->address->latitude ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Koordinat Bujur (Longitude)" name="longitude">
                        <x-form.input name="longitude" type="number" step="any" placeholder="Contoh: 107.456789" value="{{ old('longitude', $student->address->longitude ?? '') }}" />
                    </x-form.form-group>
                </div>
            </div>

            <div id="tab-ortu" class="tab-pane flex flex-col gap-6 hidden">
                <div class="border-b border-neutral-100 pb-4 mb-4 select-none">
                    <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider font-sans">A. Informasi Ayah Kandung</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <x-form.form-group label="Nama Ayah Kandung" name="father_name" :required="true">
                        <x-form.input name="father_name" placeholder="Nama Ayah" value="{{ old('father_name', $student->parent->father_name ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="NIK Ayah" name="father_nik" helper="Nomor Induk Kependudukan 16 digit (data terenkripsi)" :required="true">
                        <x-form.input name="father_nik" placeholder="NIK Ayah" value="{{ old('father_nik', $student->parent->father_nik ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Tahun Lahir Ayah" name="father_birth_year" :required="true">
                        <x-form.input name="father_birth_year" placeholder="Contoh: 1975" value="{{ old('father_birth_year', $student->parent->father_birth_year ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Pendidikan Terakhir Ayah" name="father_education" :required="true">
                        <x-form.select name="father_education" required>
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD" {{ old('father_education', $student->parent->father_education ?? '') === 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('father_education', $student->parent->father_education ?? '') === 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('father_education', $student->parent->father_education ?? '') === 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="Diploma" {{ old('father_education', $student->parent->father_education ?? '') === 'Diploma' ? 'selected' : '' }}>Diploma</option>
                            <option value="S1" {{ old('father_education', $student->parent->father_education ?? '') === 'S1' ? 'selected' : '' }}>S1 / Sederajat</option>
                            <option value="S2/S3" {{ old('father_education', $student->parent->father_education ?? '') === 'S2/S3' ? 'selected' : '' }}>Pascasarjana</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Pekerjaan Ayah" name="father_occupation" :required="true">
                        <x-form.input name="father_occupation" placeholder="Pekerjaan Ayah" value="{{ old('father_occupation', $student->parent->father_occupation ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Penghasilan Bulanan Ayah" name="father_income" :required="true">
                        <x-form.select name="father_income" required>
                            <option value="">Pilih Rentang Penghasilan</option>
                            <option value="Tidak Berpenghasilan" {{ old('father_income', $student->parent->father_income ?? '') === 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                            <option value="< Rp 1.000.000" {{ old('father_income', $student->parent->father_income ?? '') === '< Rp 1.000.000' ? 'selected' : '' }}>< Rp 1.000.000</option>
                            <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('father_income', $student->parent->father_income ?? '') === 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                            <option value="Rp 2.000.000 - Rp 5.000.000" {{ old('father_income', $student->parent->father_income ?? '') === 'Rp 2.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 5.000.000</option>
                            <option value="> Rp 5.000.000" {{ old('father_income', $student->parent->father_income ?? '') === '> Rp 5.000.000' ? 'selected' : '' }}>> Rp 5.000.000</option>
                        </x-form.select>
                    </x-form.form-group>
                </div>

                <div class="border-b border-neutral-100 pb-4 mb-4 select-none">
                    <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider font-sans">B. Informasi Ibu Kandung</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <x-form.form-group label="Nama Ibu Kandung" name="mother_name" :required="true">
                        <x-form.input name="mother_name" placeholder="Nama Ibu" value="{{ old('mother_name', $student->parent->mother_name ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="NIK Ibu" name="mother_nik" helper="Nomor Induk Kependudukan 16 digit (data terenkripsi)" :required="true">
                        <x-form.input name="mother_nik" placeholder="NIK Ibu" value="{{ old('mother_nik', $student->parent->mother_nik ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Tahun Lahir Ibu" name="mother_birth_year" :required="true">
                        <x-form.input name="mother_birth_year" placeholder="Contoh: 1978" value="{{ old('mother_birth_year', $student->parent->mother_birth_year ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Pendidikan Terakhir Ibu" name="mother_education" :required="true">
                        <x-form.select name="mother_education" required>
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD" {{ old('mother_education', $student->parent->mother_education ?? '') === 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('mother_education', $student->parent->mother_education ?? '') === 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('mother_education', $student->parent->mother_education ?? '') === 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="Diploma" {{ old('mother_education', $student->parent->mother_education ?? '') === 'Diploma' ? 'selected' : '' }}>Diploma</option>
                            <option value="S1" {{ old('mother_education', $student->parent->mother_education ?? '') === 'S1' ? 'selected' : '' }}>S1 / Sederajat</option>
                            <option value="S2/S3" {{ old('mother_education', $student->parent->mother_education ?? '') === 'S2/S3' ? 'selected' : '' }}>Pascasarjana</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Pekerjaan Ibu" name="mother_occupation" :required="true">
                        <x-form.input name="mother_occupation" placeholder="Pekerjaan Ibu" value="{{ old('mother_occupation', $student->parent->mother_occupation ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Penghasilan Bulanan Ibu" name="mother_income" :required="true">
                        <x-form.select name="mother_income" required>
                            <option value="">Pilih Rentang Penghasilan</option>
                            <option value="Tidak Berpenghasilan" {{ old('mother_income', $student->parent->mother_income ?? '') === 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                            <option value="< Rp 1.000.000" {{ old('mother_income', $student->parent->mother_income ?? '') === '< Rp 1.000.000' ? 'selected' : '' }}>< Rp 1.000.000</option>
                            <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('mother_income', $student->parent->mother_income ?? '') === 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                            <option value="Rp 2.000.000 - Rp 5.000.000" {{ old('mother_income', $student->parent->mother_income ?? '') === 'Rp 2.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 5.000.000</option>
                            <option value="> Rp 5.000.000" {{ old('mother_income', $student->parent->mother_income ?? '') === '> Rp 5.000.000' ? 'selected' : '' }}>> Rp 5.000.000</option>
                        </x-form.select>
                    </x-form.form-group>
                </div>

                <div class="border-b border-neutral-100 pb-4 mb-4 select-none">
                    <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider font-sans">C. Informasi Wali (Opsional)</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <x-form.form-group label="Nama Lengkap Wali" name="guardian_name">
                        <x-form.input name="guardian_name" placeholder="Nama Wali" value="{{ old('guardian_name', $student->parent->guardian_name ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="NIK Wali" name="guardian_nik" helper="Nomor Induk Kependudukan 16 digit (data terenkripsi)">
                        <x-form.input name="guardian_nik" placeholder="NIK Wali" value="{{ old('guardian_nik', $student->parent->guardian_nik ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Tahun Lahir Wali" name="guardian_birth_year">
                        <x-form.input name="guardian_birth_year" placeholder="Contoh: 1968" value="{{ old('guardian_birth_year', $student->parent->guardian_birth_year ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Pendidikan Terakhir Wali" name="guardian_education">
                        <x-form.select name="guardian_education">
                            <option value="">Pilih Pendidikan</option>
                            <option value="SD" {{ old('guardian_education', $student->parent->guardian_education ?? '') === 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('guardian_education', $student->parent->guardian_education ?? '') === 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('guardian_education', $student->parent->guardian_education ?? '') === 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="Diploma" {{ old('guardian_education', $student->parent->guardian_education ?? '') === 'Diploma' ? 'selected' : '' }}>Diploma</option>
                            <option value="S1" {{ old('guardian_education', $student->parent->guardian_education ?? '') === 'S1' ? 'selected' : '' }}>S1 / Sederajat</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Pekerjaan Wali" name="guardian_occupation">
                        <x-form.input name="guardian_occupation" placeholder="Pekerjaan Wali" value="{{ old('guardian_occupation', $student->parent->guardian_occupation ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Penghasilan Bulanan Wali" name="guardian_income">
                        <x-form.select name="guardian_income">
                            <option value="">Pilih Rentang Penghasilan</option>
                            <option value="Tidak Berpenghasilan" {{ old('guardian_income', $student->parent->guardian_income ?? '') === 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                            <option value="< Rp 1.000.000" {{ old('guardian_income', $student->parent->guardian_income ?? '') === '< Rp 1.000.000' ? 'selected' : '' }}>< Rp 1.000.000</option>
                            <option value="Rp 1.000.000 - Rp 2.000.000" {{ old('guardian_income', $student->parent->guardian_income ?? '') === 'Rp 1.000.000 - Rp 2.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 2.000.000</option>
                            <option value="Rp 2.000.000 - Rp 5.000.000" {{ old('guardian_income', $student->parent->guardian_income ?? '') === 'Rp 2.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 2.000.000 - Rp 5.000.000</option>
                            <option value="> Rp 5.000.000" {{ old('guardian_income', $student->parent->guardian_income ?? '') === '> Rp 5.000.000' ? 'selected' : '' }}>> Rp 5.000.000</option>
                        </x-form.select>
                    </x-form.form-group>
                </div>

                <div class="border-b border-neutral-100 pb-4 mb-4 select-none">
                    <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider font-sans">D. Hubungan Anak</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form.form-group label="Jumlah Saudara Kandung" name="siblings" :required="true">
                        <x-form.input name="siblings" type="number" placeholder="Contoh: 2" value="{{ old('siblings', $student->parent->siblings ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Anak Ke- (dalam Keluarga)" name="birth_order" :required="true">
                        <x-form.input name="birth_order" type="number" placeholder="Contoh: 1" value="{{ old('birth_order', $student->parent->birth_order ?? '') }}" required />
                    </x-form.form-group>
                </div>
            </div>

            <div id="tab-akademik" class="tab-pane flex flex-col gap-6 hidden">
                <div class="border-b border-neutral-100 pb-4 mb-4 select-none">
                    <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider font-sans">A. Informasi Akademik</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <x-form.form-group label="Kelas" name="rombel" :required="true">
                        <x-form.select name="rombel" required>
                            <option value="">Pilih Kelas</option>
                            <option value="VII-A" {{ old('rombel', $student->rombel) === 'VII-A' ? 'selected' : '' }}>Kelas VII-A</option>
                            <option value="VII-B" {{ old('rombel', $student->rombel) === 'VII-B' ? 'selected' : '' }}>Kelas VII-B</option>
                            <option value="VIII-A" {{ old('rombel', $student->rombel) === 'VIII-A' ? 'selected' : '' }}>Kelas VIII-A</option>
                            <option value="VIII-B" {{ old('rombel', $student->rombel) === 'VIII-B' ? 'selected' : '' }}>Kelas VIII-B</option>
                            <option value="IX-A" {{ old('rombel', $student->rombel) === 'IX-A' ? 'selected' : '' }}>Kelas IX-A</option>
                            <option value="IX-B" {{ old('rombel', $student->rombel) === 'IX-B' ? 'selected' : '' }}>Kelas IX-B</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Sekolah Asal (SD/MI)" name="previous_school">
                        <x-form.input name="previous_school" placeholder="Contoh: SDN 1 Cisewu" value="{{ old('previous_school', $student->previous_school) }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nomor SKHUN SD" name="skhun_number">
                        <x-form.input name="skhun_number" placeholder="SKHUN" value="{{ old('skhun_number', $student->academic->skhun_number ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Peserta Ujian Nasional SD" name="un_number">
                        <x-form.input name="un_number" placeholder="Nomor Ujian Nasional" value="{{ old('un_number', $student->academic->un_number ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Seri Ijazah SD" name="ijazah_number">
                        <x-form.input name="ijazah_number" placeholder="Nomor Ijazah" value="{{ old('ijazah_number', $student->academic->ijazah_number ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Registrasi Akta Lahir" name="akta_number" :required="true">
                        <x-form.input name="akta_number" placeholder="Nomor Akta Lahir" value="{{ old('akta_number', $student->academic->akta_number ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Berat Badan (Kg)" name="weight" :required="true">
                        <x-form.input name="weight" type="number" placeholder="Contoh: 45" value="{{ old('weight', $student->academic->weight ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Tinggi Badan (Cm)" name="height" :required="true">
                        <x-form.input name="height" type="number" placeholder="Contoh: 155" value="{{ old('height', $student->academic->height ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Lingkar Kepala (Cm)" name="head_circum" :required="true">
                        <x-form.input name="head_circum" type="number" placeholder="Contoh: 54" value="{{ old('head_circum', $student->academic->head_circum ?? '') }}" required />
                    </x-form.form-group>

                    <x-form.form-group label="Jarak Tempat Tinggal ke Sekolah (Km)" name="school_dist_km" :required="true">
                        <x-form.input name="school_dist_km" type="number" step="0.1" placeholder="Contoh: 1.5" value="{{ old('school_dist_km', $student->academic->school_dist_km ?? '') }}" required />
                    </x-form.form-group>
                </div>

                <div class="border-b border-neutral-100 pb-4 mb-4 select-none">
                    <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider font-sans">B. Bantuan & Dukungan Finansial</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <x-form.form-group label="Penerima KPS (Kartu Perlindungan Sosial)" name="is_kps">
                        <x-form.select name="is_kps">
                            <option value="0" {{ old('is_kps', $student->financial->is_kps ?? false) == false ? 'selected' : '' }}>Tidak</option>
                            <option value="1" {{ old('is_kps', $student->financial->is_kps ?? false) == true ? 'selected' : '' }}>Ya</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Kartu KPS" name="kps_number">
                        <x-form.input name="kps_number" placeholder="Nomor KPS jika ya" value="{{ old('kps_number', $student->financial->kps_number ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Penerima KIP (Kartu Indonesia Pintar)" name="is_kip">
                        <x-form.select name="is_kip">
                            <option value="0" {{ old('is_kip', $student->financial->is_kip ?? false) == false ? 'selected' : '' }}>Tidak</option>
                            <option value="1" {{ old('is_kip', $student->financial->is_kip ?? false) == true ? 'selected' : '' }}>Ya</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Kartu KIP" name="kip_number">
                        <x-form.input name="kip_number" placeholder="Nomor KIP jika ya" value="{{ old('kip_number', $student->financial->kip_number ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nama Tertera di KIP" name="kip_name">
                        <x-form.input name="kip_name" placeholder="Nama di KIP jika ya" value="{{ old('kip_name', $student->financial->kip_name ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Kartu Keluarga Sejahtera (KKS)" name="kks_number">
                        <x-form.input name="kks_number" placeholder="Nomor KKS" value="{{ old('kks_number', $student->financial->kks_number ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Usulan Layak PIP (Program Indonesia Pintar)" name="is_pip_eligible">
                        <x-form.select name="is_pip_eligible">
                            <option value="0" {{ old('is_pip_eligible', $student->financial->is_pip_eligible ?? false) == false ? 'selected' : '' }}>Tidak</option>
                            <option value="1" {{ old('is_pip_eligible', $student->financial->is_pip_eligible ?? false) == true ? 'selected' : '' }}>Ya</option>
                        </x-form.select>
                    </x-form.form-group>

                    <x-form.form-group label="Alasan Usulan Layak PIP" name="pip_reason">
                        <x-form.input name="pip_reason" placeholder="Contoh: Pemegang KIP / Miskin" value="{{ old('pip_reason', $student->financial->pip_reason ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nama Bank Penerima PIP" name="bank_name" helper="Misal: BRI (untuk jenjang SMP)">
                        <x-form.input name="bank_name" placeholder="Contoh: BRI" value="{{ old('bank_name', $student->financial->bank_name ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Nomor Rekening Bank Penerima PIP" name="bank_account" helper="Rekening bank terenkripsi di sistem">
                        <x-form.input name="bank_account" placeholder="Nomor Rekening" value="{{ old('bank_account', $student->financial->bank_account ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Atas Nama Rekening Bank" name="bank_holder">
                        <x-form.input name="bank_holder" placeholder="Atas Nama Pemilik Rekening" value="{{ old('bank_holder', $student->financial->bank_holder ?? '') }}" />
                    </x-form.form-group>

                    <x-form.form-group label="Kebutuhan Khusus Siswa" name="special_needs">
                        <x-form.input name="special_needs" placeholder="Contoh: Lambat Belajar / Tidak Ada" value="{{ old('special_needs', $student->financial->special_needs ?? 'Tidak Ada') }}" />
                    </x-form.form-group>
                </div>

                <div class="border-b border-neutral-100 pb-4 mb-4 select-none">
                    <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider font-sans">C. Mata Pelajaran & Ekstrakurikuler Wajib/Pilihan</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 select-none">
                    <div class="flex flex-col gap-3">
                        <label class="text-sm font-medium text-neutral-700 block">Registrasi Mata Pelajaran</label>
                        <div class="border border-neutral-200 rounded-xl p-4 flex flex-col gap-3 max-h-60 overflow-y-auto bg-neutral-50/50">
                            @foreach($subjects as $subject)
                                <x-form.checkbox 
                                    name="subjects[]" 
                                    value="{{ $subject->id }}" 
                                    label="{{ $subject->code }} - {{ $subject->name }}" 
                                    :checked="$student->subjects->contains($subject->id)" 
                                />
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <label class="text-sm font-medium text-neutral-700 block">Registrasi Ekstrakurikuler</label>
                        <div class="border border-neutral-200 rounded-xl p-4 flex flex-col gap-3 max-h-60 overflow-y-auto bg-neutral-50/50">
                            @foreach($extracurriculars as $ekskul)
                                <x-form.checkbox 
                                    name="extracurriculars[]" 
                                    value="{{ $ekskul->id }}" 
                                    label="{{ $ekskul->code }} - {{ $ekskul->name }}" 
                                    :checked="$student->extracurriculars->contains($ekskul->id)" 
                                />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <div class="flex items-center justify-end gap-3 no-print select-none">
            <x-ui.button href="{{ route('students.index') }}" variant="secondary">
                Batal
            </x-ui.button>

            <x-ui.button 
                type="button" 
                variant="primary"
                id="btn-trigger-save"
            >
                <x-ui.icon name="save" class="w-4 h-4 text-white stroke-white" />
                <span>Simpan Perubahan</span>
            </x-ui.button>
        </div>

    </form>

    <x-feedback.modal-confirm 
        id="save-confirm-modal" 
        title="Simpan Perubahan Data Siswa" 
        confirmText="Simpan" 
        confirmVariant="primary"
    >
        Apakah Anda yakin ingin menyimpan seluruh perubahan data yang Anda lakukan pada data siswa <strong>{{ $student->name }}</strong>?
    </x-feedback.modal-confirm>
@endsection
