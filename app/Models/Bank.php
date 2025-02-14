<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';
    protected $fillable = ['name'];

    public function financialDetails()
    {
        return $this->hasMany(Financial::class, 'bank_id');
    }
}
