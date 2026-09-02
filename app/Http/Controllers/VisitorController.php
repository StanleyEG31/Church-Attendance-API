<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        return response()->json(
            Visitor::orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'invited_by' => 'nullable|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|date_format:H:i:s',
            'service' => 'sometimes|string|max:255',
        ]);

        $visitor = Visitor::create([
            'name' => $validated['name'],
            'purpose' => $validated['purpose'],
            'invited_by' => $validated['invited_by'] ?? null,
            'date' => $validated['date'],
            'time' => $validated['time'] ?? null,
            'service' => $validated['service'] ?? 'Sunday Morning',
        ]);

        return response()->json($visitor, 201);
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();

        return response()->json([
            'message' => 'Visitor deleted successfully.',
        ]);
    }
}