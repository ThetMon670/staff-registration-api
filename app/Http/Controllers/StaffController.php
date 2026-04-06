<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Resources\StaffResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password ?? 'default123'),
            'role' => 'staff',
        ]);

        $staffData = [...$request->validated(), 'user_id' => user()->id];

        $staff = Staff::create($staffData);

        return response()->json([
            "message" => "Staff created successfully",
            "data" => new StaffResource($staff)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return response()->json([
            'message' => 'Staff is retrieved successfully',
            'data' => new StaffResource($staff)
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
            'data' => new StaffResource($staff)
        ], 200);
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
