<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => env('ADMIN_EMAIL', getenv('ADMIN_EMAIL') ?? 'admin@example.com'),
        ], [
            'name' => getenv('ADMIN_NAME') ?? 'Super Admin',
            'password' => Hash::make(getenv('ADMIN_PASSWORD') ?? 'password'),
        ]);

        $admin->assignRole('super_admin');
    }
}

