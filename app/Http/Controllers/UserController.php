<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateUserAction;
use App\Actions\User\UpdateUserAction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('id', '!=', auth()->id())->orderBy('username')->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request, CreateUserAction $createUserAction): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,staff'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'role.required' => 'Peran wajib dipilih.',
        ]);

        $createUserAction->execute(
            $request->only('username', 'email', 'password', 'role'),
            auth()->user()->school_id
        );

        return redirect()->route('users.index')->with('success', 'Operator baru berhasil ditambahkan.');
    }

    public function update(int $id, Request $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => ['required', 'string', 'max:100', 'unique:users,username,' . $id],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,staff'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'role.required' => 'Peran wajib dipilih.',
        ]);

        $updateUserAction->execute($user, $request->only('username', 'email', 'password', 'role'));

        return redirect()->route('users.index')->with('success', 'Data operator berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        if ($id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Operator berhasil dihapus.');
    }
}
