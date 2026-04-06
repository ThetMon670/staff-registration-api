<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffsData = [
            [
                'staff_code' => 'STF001',
                'name' => 'John Doe',
                'department' => 'IT',
                'phone' => '0123456789',
                'email' => 'john@example.com',
                'password' => 'asdffdsa'
            ],
            [
                'staff_code' => 'STF002',
                'name' => 'Jane Smith',
                'department' => 'HR',
                'phone' => '0123456790',
                'email' => 'jane@example.com',
                'password' => 'asdffdsa'
            ],
            [
                'staff_code' => 'STF003',
                'name' => 'Michael Brown',
                'department' => 'Finance',
                'phone' => '0123456791',
                'email' => 'michael@example.com',
                'password' => 'asdffdsa'
            ],
            // Add more staff as needed
        ];

        foreach ($staffsData as $data) {
            // 1️⃣ Create a User first
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'staff',
            ]);

            // 2️⃣ Create Staff and link to user
            Staff::create([
                'staff_code' => $data['staff_code'],
                'name' => $data['name'],
                'department' => $data['department'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'user_id' => $user->id,
            ]);
        }
    }
}