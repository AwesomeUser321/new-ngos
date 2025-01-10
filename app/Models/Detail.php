<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'name', 'father_name', 'gender', 'date_of_birth', 'qualification',
        'designation', 'occupation', 'email', 'contact', 'address', 'cnic',
        'cv', 'city_id', 'status_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'details_id');
    }
}