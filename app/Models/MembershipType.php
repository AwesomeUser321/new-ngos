<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    protected $fillable = [
        'name'
    ];

    // Relationship with Member
    public function members()
    {
        return $this->hasMany(Member::class, 'member_type_id');
    }
}
