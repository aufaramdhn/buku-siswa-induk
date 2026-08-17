<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserAction
{
    public function execute(array $data, int $schoolId): User
    {
        return User::create([
            'uuid' => 'usr-' . Str::lower(Str::random(12)),
            'school_id' => $schoolId,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }
}
