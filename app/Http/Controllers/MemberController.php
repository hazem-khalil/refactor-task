<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MemberController extends Controller
{
    # you should get member list with
    # 1. search by name, email, phone
    # 2. order them `DESC`
    # 3. load latest visits date as last_visit_date column (hint: use AddSelect)
    # 4. load max receipt on visits as max_receipt
    # 5. load total receipt on visits as total_receipt
    # 6. load total loyalty points as total_points
    public function index(Request $request)
    {
        $member = Member::query()
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . request('search') . '%')
                    ->orWhere('last_name', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%');
            })
            ->withCount(['visits as total_receipt' => function ($query) {
                $query->select(\DB::raw('sum(receipt)'));
            }])
            ->orderBy('id', 'desc')
            ->get();

        return MemberResource::collection($member);
    }


    public function getMemberHasNoVisit(): AnonymousResourceCollection
    {
        $member = Member::query()
            ->whereDoesntHave('visits')
            ->get();

        return MemberResource::collection($member);
    }

    public function getMemberHasVisit(): AnonymousResourceCollection
    {
        $member = Member::query()
            ->whereHas('visits')
            ->get();

        return MemberResource::collection($member);
    }

    # create member
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:members,email',
            'phone'      => 'required|numeric|unique:members,phone',
        ]);

        Member::created($request->all());
    }

    # update member
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:members,email,' . $member->id,
            'phone'      => 'required|numeric|unique:members,phone,' . $member->id,
        ]);

        $member->update($request->all());
    }

    # delete member
    public function destroy(Member $member)
    {
        $member->delete();
    }
}
