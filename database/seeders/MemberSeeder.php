<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Seed a default Member account.
     */
    public function run(): void
    {
        $memberRole = Role::where('name', 'member')->firstOrFail();
        $superAdmin = User::where('login_id', 'SA-001')->firstOrFail();

        $member = User::firstOrCreate(
            ['login_id' => 'M-001'],
            [
                'role_id' => $memberRole->id,
                'name' => 'Default Member',
                'email' => 'member@example.com',
                'phone' => null,
                'password' => Hash::make('Temp@12345'),
                'must_change_password' => true,
                'status' => 'active',
                'created_by' => $superAdmin->id,
            ]
        );

        Member::updateOrCreate(
            ['user_id' => $member->id],
            [
                'member_code' => $member->login_id,
                'joining_date' => now()->toDateString(),
                'membership_type' => 'general',
                'membership_status' => 'active',
            ]
        );
    }
}
