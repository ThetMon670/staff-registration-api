<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Resources\StaffResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Admin: View all staff
     */
    public function index(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // GET SEARCH PARAMETERS
        $searchTerm = $request->input('q');
        $department = $request->input('department');

        // VALIDATE AND SET SORTING PARAMETERS
        $validSortColumns = [
            'id',
            'staff_code',
            'name',
            'email',
            'phone',
            'department',
            'created_at'
        ];

        $sortBy = in_array($request->input('sort_by'), $validSortColumns, true)
            ? $request->input('sort_by')
            : 'id';

        $sortDirection = in_array($request->input('sort_direction'), ['asc', 'desc'], true)
            ? $request->input('sort_direction')
            : 'desc';

        // VALIDATE AND SET PAGINATION LIMIT
        $limit = $request->input('limit', 5);
        $limit = is_numeric($limit) && $limit > 0 && $limit <= 100
            ? (int) $limit
            : 10;

        // INITIALIZE QUERY
        $query = Staff::with('user');

        // APPLY SEARCH FILTER
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('staff_code', 'like', '%' . $searchTerm . '%');
            });
        }

        // APPLY DEPARTMENT FILTER
        if ($department) {
            $query->where('department', '=', $department);
        }

        // APPLY SORTING
        $query->orderBy($sortBy, $sortDirection);

        // EXECUTE PAGINATED QUERY
        $staffs = $query->paginate($limit);

        // PRESERVE QUERY PARAMETERS IN PAGINATION LINKS
        $staffs->appends([
            'q' => $searchTerm,
            'department' => $department,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'limit' => $limit,
        ]);

        // RETURN RESOURCE COLLECTION
        return StaffResource::collection($staffs)
            ->additional([
                'message' => 'Staff retrieved successfully',
            ]);
    }

    /**
     * Admin: Create staff
     */
    public function store(StoreStaffRequest $request)
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password ?? 'default123'),
            'role' => 'staff',
        ]);

        $staffData = [
            ...$request->validated(),
            'user_id' => $user->id
        ];

        $staff = Staff::create($staffData);
        $staff->load('user');

        return response()->json([
            'message' => 'Staff created successfully',
            'data' => new StaffResource($staff)
        ]);
    }

    /**
     * Admin OR Owner: View staff
     */
    public function show(Request $request, Staff $staff)
    {
        if (
            !Gate::allows('isAdmin') &&
            $request->user()->id !== $staff->user_id
        ) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'message' => 'Staff retrieved successfully',
            'data' => new StaffResource($staff)
        ]);
    }

    /**
     * Admin: Update staff
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $staff->update($request->validated());

        return response()->json([
            'message' => 'Staff updated successfully',
            'data' => new StaffResource($staff)
        ]);
    }

    /**
     * Admin: Delete staff
     */
    public function destroy(Staff $staff)
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // delete related user
        $staff->user()->delete();

        // delete staff
        $staff->delete();

        return response()->json([
            'message' => 'Staff and user deleted successfully'
        ]);
    }

    /**
     * Staff: View own profile
     */
    public function myProfile(Request $request)
    {
        $staff = Staff::where('user_id', $request->user()->id)
            ->with('user')
            ->first();

        return response()->json([
            'message' => 'Profile retrieved successfully',
            'data' => new StaffResource($staff)
        ]);
    }
}
