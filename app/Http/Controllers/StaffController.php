<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::all();
        return response()->json([
            'data' => $staffs,
            'message' => 'Staffs are retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
        $staff = Staff::create($request->validated());

        return response()->json([
            'data' => $staff,
            'message' => 'Staff is created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return response()->json([
            'data' => $staff,
            'message' => 'Staff is retrieved'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $staff->update($request->validated());

        return response()->json([
            'message' => 'Staff is updated successfully',
            'data' => $staff
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return response()->json([
            'data' => $staff,
            'message' => 'Staff deleted successfully'
        ]);
    }
}
