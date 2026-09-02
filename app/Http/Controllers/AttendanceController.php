<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return response()->json(
            Attendance::with('member')
                ->orderBy('date', 'desc')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'date' => 'required|date',
            'time' => 'nullable|date_format:H:i:s',
            'status' => 'sometimes|string|max:50',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'member_id' => $validated['member_id'],
                'date' => $validated['date'],
            ],
            [
                'time' => $validated['time'] ?? null,
                'status' => $validated['status'] ?? 'Present',
            ]
        );

        return response()->json($attendance->load('member'), 201);
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return response()->json([
            'message' => 'Attendance deleted successfully.',
        ]);
    }
}