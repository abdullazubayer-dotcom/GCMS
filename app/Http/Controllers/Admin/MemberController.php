<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMemberRequest;
use App\Http\Requests\Admin\UpdateMemberRequest;
use App\Models\Member;
use App\Services\ActivityLogger;
use App\Services\MemberCreationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $members = Member::query()
            ->with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('member_code', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('membership_status', $request->string('status')->toString());
            })
            ->when($request->filled('membership_type'), function ($query) use ($request) {
                $query->where('membership_type', $request->string('membership_type')->toString());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.members.index', [
            'members' => $members,
            'filters' => $request->only(['search', 'status', 'membership_type']),
        ]);
    }

    public function create(): View
    {
        return view('admin.members.create');
    }

    public function store(StoreMemberRequest $request, MemberCreationService $memberCreationService): RedirectResponse
    {
        $memberCreationService->create($request->validated(), Auth::user());

        return redirect()
            ->route('admin.members.create')
            ->with('status', 'Member created successfully. The member must change the temporary password after first login.');
    }

    public function show(Member $member): View
    {
        $member->load('user.role');

        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member): View
    {
        $member->load('user');

        return view('admin.members.edit', compact('member'));
    }

    public function update(UpdateMemberRequest $request, Member $member, ActivityLogger $activityLogger): RedirectResponse
    {
        $data = $request->validated();
        $accountStatus = $data['status'] === 'cancelled' ? 'inactive' : $data['status'];
        $member->load('user');
        $oldValues = $member->toArray();
        $oldValues['user'] = $member->user->toArray();

        DB::transaction(function () use ($data, $member, $accountStatus, $activityLogger, $oldValues): void {
            $member->user->update([
                'login_id' => $data['member_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'status' => $accountStatus,
                'updated_by' => Auth::id(),
            ]);

            $member->update([
                'member_code' => $data['member_id'],
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

            $member->refresh()->load('user');

            $activityLogger->log(
                'update',
                'member',
                "Updated member {$member->member_code}.",
                $member,
                $oldValues,
                array_merge($member->toArray(), ['user' => $member->user->toArray()])
            );
        });

        return redirect()
            ->route('admin.members.show', $member)
            ->with('status', 'Member updated successfully.');
    }
}
