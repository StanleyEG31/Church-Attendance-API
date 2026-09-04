<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return response()->json(
            Member::orderBy('name')->get()
        );
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'group' => 'required|string|max:255',
        'archived' => 'sometimes|boolean',
    ]);

    $member = Member::firstOrCreate(
        [
            'name' => $validated['name'],
            'group' => $validated['group'],
        ],
        [
            'archived' => $validated['archived'] ?? false,
        ]
    );

    return response()->json($member, 201);
}

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'group' => 'sometimes|required|string|max:255',
            'archived' => 'sometimes|boolean',
        ]);

        $member->update($validated);

        return response()->json($member);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json([
            'message' => 'Member deleted successfully.',
        ]);
    }
}