<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffs = [
            [
                'staff_code' => 'STF001',
                'name' => 'John Doe',
                'department' => 'IT',
                'phone' => '0123456789',
                'email' => 'john@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF002',
                'name' => 'Jane Smith',
                'department' => 'HR',
                'phone' => '0123456790',
                'email' => 'jane@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF003',
                'name' => 'Michael Brown',
                'department' => 'Finance',
                'phone' => '0123456791',
                'email' => 'michael@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF004',
                'name' => 'Emily Davis',
                'department' => 'Marketing',
                'phone' => '0123456792',
                'email' => 'emily@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF005',
                'name' => 'William Johnson',
                'department' => 'IT',
                'phone' => '0123456793',
                'email' => 'william@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF006',
                'name' => 'Olivia Wilson',
                'department' => 'HR',
                'phone' => '0123456794',
                'email' => 'olivia@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF007',
                'name' => 'James Taylor',
                'department' => 'Finance',
                'phone' => '0123456795',
                'email' => 'james@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF008',
                'name' => 'Sophia Anderson',
                'department' => 'Marketing',
                'phone' => '0123456796',
                'email' => 'sophia@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF009',
                'name' => 'Daniel Thomas',
                'department' => 'IT',
                'phone' => '0123456797',
                'email' => 'daniel@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_code' => 'STF010',
                'name' => 'Isabella Martin',
                'department' => 'HR',
                'phone' => '0123456798',
                'email' => 'isabella@example.com',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Staff::insert($staffs);
    }
}
