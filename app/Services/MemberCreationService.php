<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberCreationService
{
    public function __construct(private ActivityLogger $activityLogger)
    {
    }

    /**
     * Create the login user and member profile in one database transaction.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data, User $creator): Member
    {
        return DB::transaction(function () use ($data, $creator): Member {
            $memberRole = Role::where('name', 'member')->firstOrFail();
            $memberId = $data['member_id'];
            $accountStatus = $data['status'] === 'cancelled' ? 'inactive' : $data['status'];

            $user = User::create([
                'role_id' => $memberRole->id,
                'login_id' => $memberId,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['temporary_password']),
                'must_change_password' => true,
                'status' => $accountStatus,
                'created_by' => $creator->id,
            ]);

            $member = Member::create([
                'user_id' => $user->id,
                'member_code' => $memberId,
                'joining_date' => $data['joining_date'],
                'membership_type' => $data['membership_type'],
                'membership_status' => $data['status'],
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'gender' => $data['gender'] ?? null,
                'blood_group' => $data['blood_group'] ?? null,
                'occupation' => $data['profession'] ?? null,
                'organization' => $data['organization'] ?? null,
                'address' => $data['address'] ?? null,
                'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $data['emergency_contact_phone'] ?? null,
            ]);

            $this->activityLogger->log(
                'create',
                'member',
                "Created member {$member->member_code}.",
                $member,
                null,
                $member->load('user')->toArray()
            );

            return $member;
        });
    }
}
