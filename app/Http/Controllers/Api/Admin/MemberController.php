<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMemberRequest;
use App\Http\Requests\Admin\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Services\ActivityLogger;
use App\Services\MemberCreationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::with('user.role')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();
                $query->where(fn ($query) => $query->where('member_code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($query) => $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")));
            })
            ->when($request->filled('status'), fn ($query) => $query->where('membership_status', $request->string('status')))
            ->when($request->filled('membership_type'), fn ($query) => $query->where('membership_type', $request->string('membership_type')))
            ->latest()->paginate(min($request->integer('per_page', 15), 100))->withQueryString();

        return MemberResource::collection($members);
    }

    public function store(StoreMemberRequest $request, MemberCreationService $service): JsonResponse
    {
        $member = $service->create($request->validated(), $request->user())->load('user.role');

        return (new MemberResource($member))->response()->setStatusCode(201);
    }

    public function show(Member $member): MemberResource
    {
        return new MemberResource($member->load('user.role'));
    }

    public function update(UpdateMemberRequest $request, Member $member, ActivityLogger $logger): MemberResource
    {
        $data = $request->validated();
        $member->load('user');
        $old = array_merge($member->toArray(), ['user' => $member->user->toArray()]);

        DB::transaction(function () use ($request, $data, $member, $old, $logger): void {
            $member->user->update([
                'login_id' => $data['member_id'], 'name' => $data['name'], 'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'status' => $data['status'] === 'cancelled' ? 'inactive' : $data['status'],
                'updated_by' => $request->user()->id,
            ]);
            $member->update([
                'member_code' => $data['member_id'], 'joining_date' => $data['joining_date'],
                'membership_type' => $data['membership_type'], 'membership_status' => $data['status'],
                'date_of_birth' => $data['date_of_birth'] ?? null, 'gender' => $data['gender'] ?? null,
                'blood_group' => $data['blood_group'] ?? null, 'occupation' => $data['profession'] ?? null,
                'organization' => $data['organization'] ?? null, 'address' => $data['address'] ?? null,
                'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $data['emergency_contact_phone'] ?? null,
            ]);
            $logger->log('update', 'member', "Updated member {$member->member_code}.", $member, $old, $member->fresh()->load('user')->toArray());
        });

        return new MemberResource($member->fresh()->load('user.role'));
    }

    public function destroy(Member $member, ActivityLogger $logger): JsonResponse
    {
        $old = $member->load('user')->toArray();
        DB::transaction(function () use ($member, $old, $logger): void {
            $logger->log('delete', 'member', "Deleted member {$member->member_code}.", $member, $old);
            $member->delete();
            $member->user->delete();
        });

        return response()->json(['message' => 'Member deleted successfully.']);
    }
}
