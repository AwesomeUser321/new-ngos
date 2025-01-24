<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_of_operation_id',
        'future_plan_file',
        'plan_operation_file',
        'progress_report_file',
        'first_meeting_file',
        'last_meeting_file',
    ];

    public function areaOfOperation()
    {
        return $this->belongsTo(AreaOfOperation::class);
    }
}
