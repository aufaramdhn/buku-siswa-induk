@extends('layouts.app')

@section('title', 'Operator Sekolah')

@section('breadcrumbs')
    <span class="text-neutral-500 font-normal">Operator Sekolah</span>
@endsection

@section('content')
    <x-data.section-header title="Manajemen Operator Sekolah" subtitle="Kelola akun akses staf tata usaha dan administrator sekolah" />

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="w-full lg:w-1/3 order-first lg:order-last">
            <x-ui.card>
                <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider mb-4 font-sans select-none">Tambah Akun Operator</h3>
                
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-4">
                        <x-form.form-group label="Username" name="username">
                            <x-form.input name="username" placeholder="Masukkan username login" value="{{ old('username') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="Alamat Email" name="email">
                            <x-form.input name="email" type="email" placeholder="Contoh: staff@bukuinduk.sch.id" value="{{ old('email') }}" required />
                        </x-form.form-group>

                        <x-form.form-group label="Kata Sandi" name="password" helper="Kata sandi minimal 6 karakter">
                            <x-form.input name="password" type="password" placeholder="••••••••" required />
                        </x-form.form-group>

                        <x-form.form-group label="Peran / Akses" name="role">
                            <x-form.select name="role">
                                <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staf Tata Usaha</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Kepala Sekolah / Admin</option>
                            </x-form.select>
                        </x-form.form-group>

                        <x-ui.button type="submit" variant="primary" class="w-full mt-2">
                            <x-ui.icon name="plus" class="w-4 h-4 text-white stroke-white" />
                            <span>Tambah Operator</span>
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
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Username</th>
                            <th class="px-6 py-2.5 text-left text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Email</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Peran / Role</th>
                            <th class="px-6 py-2.5 text-center text-xs font-semibold text-neutral-700 uppercase tracking-wider font-sans">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-b border-neutral-200 hover:bg-neutral-50/50 transition-colors">
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900 font-semibold">{{ $user->username }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-neutral-900">{{ $user->email }}</td>
                                <td class="px-6 py-2.5 text-sm font-sans text-center">
                                    <x-ui.badge :type="$user->role === 'admin' ? 'success' : 'neutral'">
                                        {{ $user->role === 'admin' ? 'Admin / Kepsek' : 'Staf Tata Usaha' }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-6 py-2.5 text-sm font-sans">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-ui.button-icon 
                                            icon="edit" 
                                            variant="warning" 
                                            data-modal-target="#edit-operator-modal-{{ $user->id }}" 
                                        />

                                        <x-ui.button-icon 
                                            icon="trash" 
                                            variant="danger" 
                                            data-modal-target="#delete-confirm-modal-{{ $user->id }}" 
                                        />

                                        <x-feedback.modal id="edit-operator-modal-{{ $user->id }}" size="max-w-md">
                                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider mb-4 font-sans select-none">Ubah Operator Sekolah</h3>
                                                
                                                <div class="flex flex-col gap-4">
                                                    <x-form.form-group label="Username" name="username">
                                                        <x-form.input name="username" placeholder="Username" value="{{ old('username', $user->username) }}" required />
                                                    </x-form.form-group>
                                                    
                                                    <x-form.form-group label="Email" name="email">
                                                        <x-form.input name="email" type="email" placeholder="Email" value="{{ old('email', $user->email) }}" required />
                                                    </x-form.form-group>
                                                    
                                                    <x-form.form-group label="Kata Sandi Baru (Kosongkan jika tidak diubah)" name="password">
                                                        <x-form.input name="password" type="password" placeholder="••••••••" />
                                                    </x-form.form-group>
                                                    
                                                    <x-form.form-group label="Peran / Role" name="role">
                                                        <x-form.select name="role">
                                                            <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staf Tata Usaha</option>
                                                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Kepala Sekolah / Admin</option>
                                                        </x-form.select>
                                                    </x-form.form-group>
                                                    
                                                    <div class="grid grid-cols-2 gap-3 mt-4 select-none">
                                                        <x-ui.button variant="secondary" type="button" data-modal-dismiss="#edit-operator-modal-{{ $user->id }}">
                                                            Batal
                                                        </x-ui.button>
                                                        <x-ui.button variant="primary" type="submit">
                                                            Simpan
                                                        </x-ui.button>
                                                    </div>
                                                </div>
                                            </form>
                                        </x-feedback.modal>

                                        <x-feedback.modal-confirm 
                                            id="delete-confirm-modal-{{ $user->id }}" 
                                            action="{{ route('users.destroy', $user->id) }}" 
                                            method="DELETE"
                                            title="Hapus Akun Operator" 
                                            confirmText="Hapus" 
                                            confirmVariant="danger"
                                        >
                                            Apakah Anda yakin ingin menghapus akun operator <strong>{{ $user->username }}</strong>? Hak akses login operator ini akan dicabut secara permanen.
                                        </x-feedback.modal-confirm>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-neutral-500 font-sans">
                                    Belum ada operator terdaftar selain Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-data.table>
            </div>

            <!-- Mobile Cards (< md) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
                @forelse($users as $user)
                    <div class="bg-white border border-neutral-200 rounded-xl p-4 shadow-sm flex flex-col justify-between gap-3">
                        <div class="flex items-start justify-between gap-2 border-b border-neutral-100 pb-2.5 select-none">
                            <div>
                                <h4 class="text-sm font-semibold text-neutral-900 font-sans">{{ $user->username }}</h4>
                                <span class="text-xs text-neutral-500 font-sans">{{ $user->email }}</span>
                            </div>
                            <x-ui.badge :type="$user->role === 'admin' ? 'success' : 'neutral'">
                                {{ $user->role === 'admin' ? 'Admin' : 'Staf' }}
                            </x-ui.badge>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-2.5 border-t border-neutral-100">
                            <x-ui.button-icon 
                                icon="edit" 
                                variant="warning" 
                                data-modal-target="#edit-operator-modal-mobile-{{ $user->id }}" 
                            />

                            <x-ui.button-icon 
                                icon="trash" 
                                variant="danger" 
                                data-modal-target="#delete-confirm-modal-mobile-{{ $user->id }}" 
                            />

                            <x-feedback.modal id="edit-operator-modal-mobile-{{ $user->id }}" size="max-w-md">
                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <h3 class="text-sm font-semibold text-neutral-800 uppercase tracking-wider mb-4 font-sans select-none">Ubah Operator Sekolah</h3>
                                    
                                    <div class="flex flex-col gap-4">
                                        <x-form.form-group label="Username" name="username">
                                            <x-form.input name="username" placeholder="Username" value="{{ old('username', $user->username) }}" required />
                                        </x-form.form-group>
                                        
                                        <x-form.form-group label="Email" name="email">
                                            <x-form.input name="email" type="email" placeholder="Email" value="{{ old('email', $user->email) }}" required />
                                        </x-form.form-group>
                                        
                                        <x-form.form-group label="Kata Sandi Baru (Kosongkan jika tidak diubah)" name="password">
                                            <x-form.input name="password" type="password" placeholder="••••••••" />
                                        </x-form.form-group>
                                        
                                        <x-form.form-group label="Peran / Role" name="role">
                                            <x-form.select name="role">
                                                <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staf Tata Usaha</option>
                                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Kepala Sekolah / Admin</option>
                                            </x-form.select>
                                        </x-form.form-group>
                                        
                                        <div class="grid grid-cols-2 gap-3 mt-4 select-none">
                                            <x-ui.button variant="secondary" type="button" data-modal-dismiss="#edit-operator-modal-mobile-{{ $user->id }}">
                                                Batal
                                            </x-ui.button>
                                            <x-ui.button variant="primary" type="submit">
                                                Simpan
                                            </x-ui.button>
                                        </div>
                                    </div>
                                </form>
                            </x-feedback.modal>

                            <x-feedback.modal-confirm 
                                id="delete-confirm-modal-mobile-{{ $user->id }}" 
                                action="{{ route('users.destroy', $user->id) }}" 
                                method="DELETE"
                                title="Hapus Akun Operator" 
                                confirmText="Hapus" 
                                confirmVariant="danger"
                            >
                                Apakah Anda yakin ingin menghapus akun operator <strong>{{ $user->username }}</strong>? Hak akses login operator ini akan dicabut secara permanen.
                            </x-feedback.modal-confirm>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-neutral-200 rounded-xl p-8 text-center text-sm text-neutral-500 font-sans">
                        Belum ada operator terdaftar selain Anda.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
