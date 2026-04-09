<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class AttendanceController extends Controller
{
    // Staff check-in
    public function checkIn(Request $request)
    {

        $user = $request->user();
        $staff = $user->staff; // via user -> staff relation

        if (!$staff) {
            return response()->json(['message' => 'No staff profile found'], 404);
        }

        $today = Carbon::today()->toDateString();

        $attendance = Attendance::firstOrCreate(
            ['staff_id' => $staff->id, 'date' => $today],
            ['time_in' => Carbon::now()]
        );

        return response()->json([
            'message' => 'Checked in successfully',
            'data' => $attendance
        ]);
    }

    // Staff check-out
    public function checkOut(Request $request)
    {
        $user = $request->user();
        $staff = $user->staff;

        if (!$staff) {
            return response()->json(['message' => 'No staff profile found'], 404);
        }

        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('staff_id', $staff->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'You have not checked in today'], 400);
        }

        $attendance->time_out = Carbon::now();
        $attendance->save();

        return response()->json([
            'message' => 'Checked out successfully',
            'data' => $attendance
        ]);
    }

    // Admin view all attendances
    public function index(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        // Pagination and sorting
        $limit = $request->input('limit', 10);
        $sortBy = $request->input('sort_by', 'date');
        $sortDirection = $request->input('sort_direction', 'desc');

        $attendances = Attendance::with('staff')
            ->orderBy($sortBy, $sortDirection)
            ->paginate($limit);

        // Preserve query params
        $attendances->appends($request->all());

        return response()->json([
            'message' => 'Attendances retrieved successfully',
            'data' => $attendances
        ]);
    }


    // Staff view own attendances
    // public function myAttendance(Request $request)
    // {
    //     $staff = $request->user()->staff;

    //     $attendances = Attendance::where('staff_id', $staff->id)->get();

    //     return response()->json([
    //         'message' => 'Your attendances retrieved successfully',
    //         'data' => $attendances
    //     ]);
    // }


    public function myAttendance(Request $request)
    {
        $staff = $request->user()->staff;

        $attendances = Attendance::where('staff_id', $staff->id)->get()->map(function ($attendance) {

            $startWork = Carbon::createFromTime(9, 0, 0);
            $endWork = Carbon::createFromTime(17, 0, 0);

            if (!$attendance->time_in) {
                $attendance->status = 'absent';
            } else {
                $checkIn = Carbon::parse($attendance->time_in);

                if ($checkIn->greaterThan($startWork)) {
                    $attendance->status = 'late';
                } else {
                    $attendance->status = 'present';
                }

                if ($attendance->time_out) {
                    $checkOut = Carbon::parse($attendance->time_out);

                    if ($checkOut->lessThan($endWork)) {
                        $attendance->status = 'left early';
                    }
                }
            }

            return $attendance;
        });

        return response()->json([
            'message' => 'Your attendances retrieved successfully',
            'data' => $attendances
        ]);
    }
}
