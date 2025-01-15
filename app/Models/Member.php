<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'details_id', 'member_type_id'
    ];

    // Relationship with Detail
    public function detail()
    {
        return $this->belongsTo(Detail::class, 'details_id');
    }

    // Relationship with MembershipType
    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class, 'member_type_id');
    }
}