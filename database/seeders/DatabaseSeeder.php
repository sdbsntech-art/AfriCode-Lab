<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.bootstrap.email');
        $password = config('admin.bootstrap.password');

        if (! filled($email) && ! filled($password)) {
            return;
        }

        Validator::make([
            'email' => $email,
            'password' => $password,
        ], [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:12'],
        ])->validate();

        User::firstOrCreate(
            ['email' => strtolower(trim($email))],
            [
                'name' => config('admin.bootstrap.name') ?: 'Administrateur AfriCode Lab',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_active' => true,
            ],
        );
    }
}
