<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    // Staff check-in
    public function checkIn(Request $request)
    {
        $user = $request->user();
        $staff = $user->staff; // via user -> staff relation

        if (!$staff) {
            return response()->json(['message'=>'No staff profile found'], 404);
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
            return response()->json(['message'=>'No staff profile found'], 404);
        }

        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('staff_id', $staff->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json(['message'=>'You have not checked in today'], 400);
        }

        $attendance->time_out = Carbon::now();
        $attendance->save();

        return response()->json([
            'message' => 'Checked out successfully',
            'data' => $attendance
        ]);
    }

    // Admin view all attendances
    public function index()
    {
        $attendances = Attendance::with('staff')->get();
        return response()->json($attendances);
    }

    // Staff view own attendances
    public function myAttendance(Request $request)
    {
        $staff = $request->user()->staff;
        $attendances = Attendance::where('staff_id', $staff->id)->get();

        return response()->json($attendances);
    }
}
