<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AimObjective extends Model
{
    protected $fillable = ['name'];

    protected $table = 'aim_objective_table'; // Set the correct table name

    public function basicInformation()
    {
        return $this->belongsToMany(
            BasicInformation::class,
            'basics_aim',
            'aim_obj_id',
            'basic_info_id'
        );
    }
}
