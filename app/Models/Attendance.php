<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;
    protected $fillable = [
        'staff_id',
        'date',
        'time_in',
        'time_out',
        'status'
    ];
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
