<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Seed the default Super Admin account.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super_admin')->firstOrFail();

        User::firstOrCreate(
            ['login_id' => 'SA-001'],
            [
                'role_id' => $superAdminRole->id,
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'phone' => null,
                'password' => Hash::make('Temp@12345'),
                'must_change_password' => true,
                'status' => 'active',
            ]
        );
    }
}
