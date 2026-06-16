<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MobileTestDataSeeder extends Seeder
{
    public function run(): void
    {
        $memberRole = Role::firstOrCreate(
            ['name' => 'member'],
            ['display_name' => 'Member']
        );

        $admin = User::where('login_id', 'SA-001')
            ->orWhereHas('role', fn ($query) => $query->whereIn('name', ['super_admin', 'admin']))
            ->first();

        $user = User::updateOrCreate(
            ['login_id' => 'MOB-TEST-001'],
            [
                'role_id' => $memberRole->id,
                'name' => 'Mobile Test Member',
                'email' => 'mobile.test.member@example.com',
                'phone' => '01700000001',
                'password' => Hash::make('TempPass123'),
                'must_change_password' => true,
                'status' => 'active',
                'created_by' => $admin?->id,
            ]
        );

        $member = Member::updateOrCreate(
            ['member_code' => 'MOB-TEST-001'],
            [
                'user_id' => $user->id,
                'joining_date' => now()->toDateString(),
                'membership_type' => 'general',
                'membership_status' => 'active',
                'date_of_birth' => '1995-01-15',
                'gender' => 'male',
                'blood_group' => 'O+',
                'occupation' => 'Software Tester',
                'organization' => 'GCMS Demo Club',
                'address' => 'Dhaka, Bangladesh',
                'emergency_contact_name' => 'Demo Contact',
                'emergency_contact_phone' => '01800000001',
            ]
        );

        $event = Event::updateOrCreate(
            ['slug' => 'mobile-demo-club-night'],
            [
                'title' => 'Mobile Demo Club Night',
                'event_date' => now()->addDays(10)->toDateString(),
                'start_time' => '18:00',
                'end_time' => '21:00',
                'venue' => 'Main Club Hall',
                'description' => 'Test event for the mobile admin app.',
                'event_fee' => 500,
                'capacity' => 120,
                'status' => 'published',
                'created_by' => $admin?->id,
            ]
        );

        Payment::updateOrCreate(
            ['payment_no' => 'PAY-MOBILE-TEST-001'],
            [
                'member_id' => $member->id,
                'event_id' => $event->id,
                'payment_type' => 'event_fee',
                'amount' => 500,
                'payment_date' => now()->toDateString(),
                'payment_method' => 'cash',
                'transaction_reference' => 'MOBILE-TEST',
                'payment_status' => 'paid',
                'remarks' => 'Mobile CRUD test payment.',
                'received_by' => $admin?->id,
            ]
        );
    }
}
