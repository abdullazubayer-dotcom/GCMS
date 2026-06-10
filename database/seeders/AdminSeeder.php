<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed a default Admin account.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->firstOrFail();
        $superAdmin = User::where('login_id', 'SA-001')->firstOrFail();

        User::firstOrCreate(
            ['login_id' => 'AD-001'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Default Admin',
                'email' => 'club-admin@example.com',
                'phone' => null,
                'password' => Hash::make('Temp@12345'),
                'must_change_password' => true,
                'status' => 'active',
                'created_by' => $superAdmin->id,
            ]
        );
    }
}
